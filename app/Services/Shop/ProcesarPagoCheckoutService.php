<?php

namespace App\Services\Shop;

use App\Models\CheckoutIntento;
use App\Models\CuponUso;
use App\Models\Orden;
use App\Models\OrdenItem;
use App\Models\OrdenStockEspera;
use App\Models\ProductoVariante;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProcesarPagoCheckoutService
{
    /**
     * Procesa un intento cuyo pago YA fue confirmado por la pasarela
     * o por el proceso administrativo correspondiente.
     *
     * IMPORTANTE:
     * Este método no verifica pagos con Mercado Pago.
     * El controlador/webhook debe verificar previamente el pago
     * consultando la API oficial de la pasarela.
     */
    public function procesarPagoConfirmado(
        int $intentoId,
        string $referenciaPago,
        ?string $mercadoPagoOrderId = null,
        ?array $respuestaPasarela = null
    ): Orden {
        $resultado = DB::transaction(function () use (
            $intentoId,
            $referenciaPago,
            $mercadoPagoOrderId,
            $respuestaPasarela
        ) {

            /*
            |--------------------------------------------------------------------------
            | 1. Bloquear el intento de checkout
            |--------------------------------------------------------------------------
            */

            $intento = CheckoutIntento::query()
                ->whereKey($intentoId)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * Protección de idempotencia:
             * si ya existe una orden vinculada, no procesamos nuevamente.
             */
            if ($intento->orden_id) {
                return [
                    'orden' => Orden::query()
                        ->with(['items', 'esperasStock'])
                        ->findOrFail($intento->orden_id),
                    'creada' => false,
                ];
            }

            $itemsIntento = $intento->items()
                ->orderBy('id')
                ->get();

            if ($itemsIntento->isEmpty()) {
                throw new DomainException(
                    'El intento de checkout no contiene artículos.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Obtener y bloquear las variantes en orden
            |--------------------------------------------------------------------------
            |
            | Todos los procesos que asignen inventario deben bloquear
            | las variantes en un orden estable para reducir deadlocks.
            */

            $idsVariantes = $itemsIntento
                ->where('comprable_type', ProductoVariante::class)
                ->pluck('comprable_id')
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->sort()
                ->values();

            $variantes = ProductoVariante::query()
                ->whereIn('id', $idsVariantes)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $inventario = app(
                DisponibilidadInventarioService::class
            );

            /*
            |--------------------------------------------------------------------------
            | 3. Crear la orden con los datos históricos del intento
            |--------------------------------------------------------------------------
            */

            $orden = Orden::create([
                'numero' => $this->generarNumeroOrden(),

                'user_id' => $intento->user_id,

                'cupon_id' => $intento->cupon_id,
                'cupon_codigo' => $intento->cupon_codigo,

                'estado' => 'procesando',
                'estado_pago' => 'pagado',

                'metodo_pago' => $intento->metodo_pago,
                'referencia_pago' => $referenciaPago,
                'fecha_pago' => now(),

                'tipo_entrega' => $intento->tipo_entrega,
                'direccion_entrega' => $intento->direccion_entrega,
                'zona_envio' => $intento->zona_envio,

                'subtotal_original' => $intento->subtotal_original,
                'descuento_promociones' => $intento->descuento_promociones,
                'descuento_cupon' => $intento->descuento_cupon,
                'subtotal' => $intento->subtotal,
                'costo_envio' => $intento->costo_envio,
                'total' => $intento->total,
                'moneda' => $intento->moneda,

                'mercadopago_order_id' =>
                    $mercadoPagoOrderId
                    ?? $intento->mercadopago_order_id,

                'mercadopago_idempotency_key' =>
                    $intento->mercadopago_idempotency_key,

                'mercadopago_checkout_url' =>
                    $intento->mercadopago_checkout_url,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 4. Crear los artículos y asignar inventario
            |--------------------------------------------------------------------------
            */

            $hayArticulosEnEspera = false;

            foreach ($itemsIntento as $itemIntento) {

                // Copiar el snapshot histórico a la orden.
                $itemOrden = $orden->items()->create([
                    'comprable_type' => $itemIntento->comprable_type,
                    'comprable_id' => $itemIntento->comprable_id,

                    'nombre_articulo' => $itemIntento->nombre_articulo,
                    'sku' => $itemIntento->sku,
                    'imagen' => $itemIntento->imagen,
                    'datos_articulo' => $itemIntento->datos_articulo,

                    'cantidad' => $itemIntento->cantidad,

                    'precio_original_unitario' =>
                        $itemIntento->precio_original_unitario,

                    'precio_unitario' =>
                        $itemIntento->precio_unitario,

                    'subtotal_original' =>
                        $itemIntento->subtotal_original,

                    'subtotal' => $itemIntento->subtotal,
                ]);

                /*
                 * El checkout actual solamente admite ProductoVariante.
                 * Esta condición deja preparada la estructura para
                 * otros tipos de artículos en futuras etapas.
                 */
                if (
                    $itemIntento->comprable_type !==
                    ProductoVariante::class
                ) {
                    continue;
                }

                $variante = $variantes->get(
                    (int) $itemIntento->comprable_id
                );

                /*
                 * Si la variante fue eliminada después del checkout,
                 * conservamos la orden pagada y registramos la incidencia.
                 * No podemos crear una espera porque su FK requiere
                 * una variante existente.
                 */
                if (! $variante) {

                    $hayArticulosEnEspera = true;

                    Log::critical(
                        'No se encontró una variante al procesar un pago confirmado.',
                        [
                            'orden_id' => $orden->id,
                            'orden_item_id' => $itemOrden->id,
                            'producto_variante_id' =>
                                $itemIntento->comprable_id,
                            'cantidad' => $itemIntento->cantidad,
                        ]
                    );

                    continue;
                }

                $cantidadSolicitada = (int) $itemIntento->cantidad;

                /*
                 * Consultar disponibilidad real:
                 * stock físico menos unidades comprometidas
                 * en órdenes que ya esperan inventario.
                 */
                $disponible = $inventario->disponibleParaVenta(
                    $variante
                );

                $cantidadAsignada = min(
                    $cantidadSolicitada,
                    $disponible
                );

                $cantidadFaltante = max(
                    0,
                    $cantidadSolicitada - $cantidadAsignada
                );

                /*
                 * Descontar únicamente las unidades disponibles.
                 */
                if ($cantidadAsignada > 0) {
                    $variante->decrement(
                        'stock',
                        $cantidadAsignada
                    );
                }

                /*
                 * Registrar solamente las unidades que faltan.
                 */
                if ($cantidadFaltante > 0) {

                    $hayArticulosEnEspera = true;

                    OrdenStockEspera::create([
                        'orden_id' => $orden->id,
                        'orden_item_id' => $itemOrden->id,
                        'producto_variante_id' => $variante->id,
                        'cantidad' => $cantidadFaltante,
                        'estado' => 'pendiente',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 5. Actualizar el estado de la orden
            |--------------------------------------------------------------------------
            */

            if ($hayArticulosEnEspera) {
                $orden->estado = 'en_espera_stock';
                $orden->save();
            }

            /*
            |--------------------------------------------------------------------------
            | 6. Confirmar el uso del cupón
            |--------------------------------------------------------------------------
            |
            | El uso reservado pasa a usado y queda vinculado
            | tanto al intento como a la orden definitiva.
            */

            if ($intento->cupon_id) {

                $usoCupon = CuponUso::query()
                    ->where('checkout_intento_id', $intento->id)
                    ->lockForUpdate()
                    ->first();

                if ($usoCupon) {

                    $usoCupon->update([
                        'orden_id' => $orden->id,
                        'estado' => 'usado',
                        'usado_en' => now(),
                    ]);

                } else {

                    // Protección ante intentos antiguos sin registro reservado.
                    CuponUso::create([
                        'cupon_id' => $intento->cupon_id,
                        'user_id' => $intento->user_id,
                        'orden_id' => $orden->id,
                        'checkout_intento_id' => $intento->id,
                        'estado' => 'usado',
                        'usado_en' => now(),
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 7. Marcar el intento como procesado
            |--------------------------------------------------------------------------
            */

            $intento->update([
                'orden_id' => $orden->id,
                'estado' => 'aprobado',
                'fecha_pago' => now(),
                'respuesta_pasarela' => array_merge(
                    (array) $intento->respuesta_pasarela,
                    $respuestaPasarela ?? []
                ),
            ]);

            return [
                'orden' => $orden->fresh([
                    'items',
                    'esperasStock',
                ]),
                'creada' => true,
            ];

        }, 3);

        /*
        |--------------------------------------------------------------------------
        | 8. Notificar después de confirmar la transacción
        |--------------------------------------------------------------------------
        |
        | Si falla una notificación, no se revierte el pago,
        | la orden ni el inventario.
        */

        if ($resultado['creada']) {

            try {

                app(NotificadorPedidos::class)
                    ->nuevoPedido($resultado['orden']);

            } catch (\Throwable $e) {

                report($e);

                Log::error(
                    'No se pudieron enviar las notificaciones de la orden.',
                    [
                        'orden_id' => $resultado['orden']->id,
                        'error' => $e->getMessage(),
                    ]
                );
            }
        }

        return $resultado['orden'];
    }

    /**
     * Generar un número único para la orden.
     */
    private function generarNumeroOrden(): string
    {
        return 'ORD-' .
            now()->format('Ymd') .
            '-' .
            Str::upper(Str::random(8));
    }
}