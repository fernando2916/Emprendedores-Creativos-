<?php

namespace App\Services\Shop;

use App\Models\CheckoutIntento;
use App\Models\CuponUso;
use App\Models\Orden;
use App\Models\OrdenStockEspera;
use App\Models\ProductoVariante;
use DomainException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProcesarPagoAprobadoService
{
    /**
     * Procesa un intento cuyo pago ya fue verificado
     * directamente contra Mercado Pago.
     *
     * Si todas las variantes tienen existencias:
     * - Crea la orden pagada.
     * - Descuenta el inventario.
     * - Registra el uso del cupón.
     *
     * Si falta inventario:
     * - Crea la orden pagada en espera de stock.
     * - Registra todas sus líneas en la cola de espera.
     * - No descuenta ninguna existencia.
     */
    public function procesar(CheckoutIntento $checkoutIntento): Orden
    {
        return DB::transaction(function () use ($checkoutIntento) {

            /*
            |--------------------------------------------------------------------------
            | 1. Bloquear el intento para garantizar idempotencia
            |--------------------------------------------------------------------------
            */

            $intento = CheckoutIntento::query()
                ->whereKey($checkoutIntento->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Si el intento ya generó una orden, no crear otra.
            if ($intento->orden_id) {
                return Orden::query()
                    ->whereKey($intento->orden_id)
                    ->firstOrFail();
            }

            if ($intento->fecha_pago === null) {
                throw new DomainException(
                    'El intento todavía no tiene registrada una fecha de pago aprobada.'
                );
            }

            if (! $intento->user_id) {
                throw new DomainException(
                    'El intento de compra no tiene un usuario asociado.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Recuperar el snapshot de los artículos
            |--------------------------------------------------------------------------
            */

            $itemsIntento = $intento->items()
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            if ($itemsIntento->isEmpty()) {
                throw new DomainException(
                    'El intento de compra no contiene artículos.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 3. Validar los tipos de artículos
            |--------------------------------------------------------------------------
            */

            foreach ($itemsIntento as $item) {

                if (
                    $item->comprable_type !== ProductoVariante::class
                ) {
                    throw new DomainException(
                        'El intento contiene un tipo de artículo no compatible con el inventario actual.'
                    );
                }

                if ((int) $item->cantidad < 1) {
                    throw new DomainException(
                        'El intento contiene una cantidad inválida.'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 4. Bloquear todas las variantes en orden ascendente
            |--------------------------------------------------------------------------
            |
            | El orden estable reduce el riesgo de deadlocks
            | cuando existen compras simultáneas.
            |
            */

            $idsVariantes = $itemsIntento
                ->pluck('comprable_id')
                ->unique()
                ->map(fn ($id) => (int) $id)
                ->sort()
                ->values();

            $variantes = ProductoVariante::query()
                ->with('producto')
                ->whereIn('id', $idsVariantes)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            /*
            |--------------------------------------------------------------------------
            | 5. Comprobar que todas las variantes sigan existiendo
            |--------------------------------------------------------------------------
            */

            foreach ($itemsIntento as $item) {

                $variante = $variantes->get(
                    (int) $item->comprable_id
                );

                if (! $variante || ! $variante->producto) {
                    throw new DomainException(
                        'Una variante del pedido ya no existe. El pago requiere revisión y posible reembolso.'
                    );
                }

                if (
                    ! $variante->estado ||
                    ! $variante->producto->estado
                ) {
                    throw new DomainException(
                        'Una variante o su producto fue desactivado después del inicio del pago. El pago requiere revisión y posible reembolso.'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 6. Comprobar disponibilidad de todo el pedido
            |--------------------------------------------------------------------------
            |
            | No descontamos inventario todavía.
            | Primero comprobamos todas las líneas.
            |
            */

            $hayFaltantes = false;

            foreach ($itemsIntento as $item) {

                $variante = $variantes->get(
                    (int) $item->comprable_id
                );

                if (
                    (int) $variante->stock <
                    (int) $item->cantidad
                ) {
                    $hayFaltantes = true;
                    break;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 7. Generar número de orden
            |--------------------------------------------------------------------------
            */

            do {
                $numero = 'EMP-ORDEN-' .
                    now()->format('dmY') .
                    '-' .
                    Str::upper(Str::random(8));

            } while (
                Orden::query()
                    ->where('numero', $numero)
                    ->exists()
            );

            /*
            |--------------------------------------------------------------------------
            | 8. Crear la orden con los importes del snapshot
            |--------------------------------------------------------------------------
            */

            $orden = Orden::create([

                'numero' => $numero,

                'user_id' => $intento->user_id,

                'cupon_id' => $intento->cupon_id,

                'cupon_codigo' => $intento->cupon_codigo,

                'estado' => $hayFaltantes
                    ? 'en_espera_stock'
                    : 'pendiente',

                'estado_pago' => 'pagado',

                'metodo_pago' => $intento->metodo_pago,

                'fecha_pago' => $intento->fecha_pago,

                'fecha_expiracion' => null,

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

                'mercadopago_order_id' => $intento->mercadopago_order_id,

                'mercadopago_idempotency_key' =>
                    $intento->mercadopago_idempotency_key,

            ]);

            /*
            |--------------------------------------------------------------------------
            | 9. Copiar todos los artículos desde el snapshot
            |--------------------------------------------------------------------------
            |
            | No recalculamos precios, promociones ni atributos.
            | La compra conserva exactamente las condiciones aceptadas
            | cuando se inició el pago.
            |
            */

            $itemsOrden = collect();

            foreach ($itemsIntento as $item) {

                $ordenItem = $orden->items()->create([

                    'comprable_type' => $item->comprable_type,

                    'comprable_id' => $item->comprable_id,

                    'nombre_articulo' => $item->nombre_articulo,

                    'sku' => $item->sku,

                    'imagen' => $item->imagen,

                    'datos_articulo' => $item->datos_articulo,

                    'cantidad' => $item->cantidad,

                    'precio_original_unitario' =>
                        $item->precio_original_unitario,

                    'precio_unitario' => $item->precio_unitario,

                    'subtotal_original' => $item->subtotal_original,

                    'subtotal' => $item->subtotal,

                ]);

                $itemsOrden->push([
                    'orden_item' => $ordenItem,
                    'variante' => $variantes->get(
                        (int) $item->comprable_id
                    ),
                    'cantidad' => (int) $item->cantidad,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | 10. Resolver inventario
            |--------------------------------------------------------------------------
            */

            if ($hayFaltantes) {

                /*
                | El pedido completo queda en espera.
                | No se descuenta ninguna variante.
                */

                $orden->update([

                    'decision_stock' => 'pendiente',

                    'fecha_notificacion_stock' => now(),

                    'fecha_limite_decision_stock' => now()->addDays(7),

                    'fecha_decision_stock' => null,

                    'estado_reembolso' => null,

                ]);

                /*
                | Todas las líneas entran en espera, no solamente
                | aquellas que actualmente tienen stock insuficiente.
                */

                foreach ($itemsOrden as $item) {

                    OrdenStockEspera::create([

                        'orden_id' => $orden->id,

                        'orden_item_id' => $item['orden_item']->id,

                        'producto_variante_id' => $item['variante']->id,

                        'cantidad' => $item['cantidad'],

                        'estado' => 'pendiente',

                    ]);
                }

            } else {

                /*
                | Todas las variantes tienen stock.
                | Ahora sí podemos descontar todas las existencias.
                */

                foreach ($itemsOrden as $item) {

                    $item['variante']->decrement(
                        'stock',
                        $item['cantidad']
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | 11. Registrar el uso definitivo del cupón
                |--------------------------------------------------------------------------
                |
                | El pago ya fue aprobado.
                | No volvemos a validar vigencia ni límites del cupón.
                |
                */

                if ($intento->cupon_id) {

                    CuponUso::create([

                        'cupon_id' => $intento->cupon_id,

                        'user_id' => $intento->user_id,

                        'orden_id' => $orden->id,

                        'estado' => 'usado',

                        'usado_en' => now(),

                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 12. Vincular el intento con la orden
            |--------------------------------------------------------------------------
            |
            | La relación y el estado se guardan en la misma transacción.
            | Una notificación repetida no generará otra orden.
            |
            */

            $intento->update([

                'orden_id' => $orden->id,

                'estado' => $hayFaltantes
                    ? 'en_espera_stock'
                    : 'completado',

            ]);

            return $orden->fresh([
                'items',
                'esperasStock',
            ]);

        }, 3);
    }
}