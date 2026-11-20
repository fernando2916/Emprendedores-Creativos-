<?php

namespace App\Services\Shop;

use App\Models\CheckoutIntento;
use Illuminate\Support\Facades\Log;
use Throwable;

class ExpirarCheckoutIntentosService
{
    public function __construct(
        private MercadoPagoService $mercadoPago,
        private ActualizarEstadoCheckoutMercadoPagoService $actualizarEstado,
        private ProcesarPagoCheckoutService $procesarPago
        
    ) {
    }

    public function ejecutar(): array
    {
        $resultado = [
            'expirados' => 0,
            'cancelados_pasarela' => 0,
            'pendientes' => 0,
            'errores' => 0,
            'pagos_recuperados' => 0,
        ];

        CheckoutIntento::query()
            ->whereNotNull('fecha_expiracion')
            ->where('fecha_expiracion', '<=', now())
            ->whereNull('orden_id')
            ->where(function ($query) {
                $query
                    ->whereIn('estado', ['pendiente', 'procesando'])

                    /*
                    * También recuperar intentos ya expirados,
                    * rechazados o cancelados que todavía tienen
                    * una orden externa pendiente de sincronizar.
                    */
                    ->orWhere(function ($query) {
                        $query
                            ->whereIn(
                                'estado',
                                ['rechazado', 'cancelado', 'expirado']
                            )
                            ->whereNotNull('mercadopago_order_id')
                            ->whereNull(
                                'respuesta_pasarela->mercadopago_estado->expiracion_sincronizada_en'
                            );
                    });
            })
            ->orderBy('id')
            ->chunkById(50, function ($intentos) use (&$resultado) {
                foreach ($intentos as $intento) {
                    try {
                        $this->procesarIntento(
                            $intento,
                            $resultado
                        );
                    } catch (Throwable $e) {
                        report($e);

                        $resultado['errores']++;

                        Log::error(
                            'Error al procesar la expiración de un checkout.',
                            [
                                'intento_id' => $intento->id,
                                'error' => $e->getMessage(),
                            ]
                        );
                    }
                }
            });

        return $resultado;
    }

    private function procesarIntento(
        CheckoutIntento $intento,
        array &$resultado
    ): void {

        /*
         * Si nunca se creó una orden en Mercado Pago,
         * no existe una operación externa que pueda cobrarse.
         */
        if (!$intento->mercadopago_order_id) {
            $this->actualizarEstado->actualizar(
                (int) $intento->id,
                [
                    'order_status' => 'expired',
                    'order_status_detail' => 'local_expiration',
                ]
            );

            $resultado['expirados']++;

            return;
        }

        /*
         * Consultar siempre el estado real de Mercado Pago.
         */
        $ordenMP = $this->mercadoPago->consultarOrden(
            $intento->mercadopago_order_id
        );

        /*
         * Comprobar que la orden pertenece a este intento.
         */
        $referenciaCorrecta = hash_equals(
            (string) $intento->referencia_externa,
            (string) $ordenMP->external_reference
        );

        $importeEsperado = number_format(
            (float) $intento->total,
            2,
            '.',
            ''
        );

        $importeRecibido = number_format(
            (float) $ordenMP->total_amount,
            2,
            '.',
            ''
        );

        $monedaCorrecta = strtoupper(
            (string) $intento->moneda
        ) === strtoupper(
            (string) $ordenMP->currency
        );

        if (
            !$referenciaCorrecta ||
            $importeEsperado !== $importeRecibido ||
            !$monedaCorrecta
        ) {
            Log::critical(
                'La orden consultada durante la expiración no coincide con el intento local.',
                [
                    'intento_id' => $intento->id,
                    'mercadopago_order_id' => $ordenMP->id,
                ]
            );

            $resultado['errores']++;

            return;
        }

        $estado = strtolower(
            (string) $ordenMP->status
        );

        /*
        |--------------------------------------------------------------------------
        | Recuperar pagos acreditados
        |--------------------------------------------------------------------------
        |
        | La API oficial confirma el estado del pago. Si el webhook no llegó,
        | podemos procesarlo desde esta tarea programada.
        |
        | Se reutiliza ProcesarPagoCheckoutService para conservar la
        | idempotencia y la asignación atómica del inventario.
        */

        if (
            $estado === 'processed' &&
            $ordenMP->status_detail === 'accredited'
        ) {
            $pagos = collect(
                data_get($ordenMP, 'transactions.payments', [])
            );

            $pagosAcreditados = $pagos->filter(
                fn ($pago) =>
                    data_get($pago, 'status') === 'processed' &&
                    data_get($pago, 'status_detail') === 'accredited'
            )->values();

            if ($pagosAcreditados->count() !== 1) {
                Log::critical(
                    'No se pudo recuperar el pago: la orden no contiene exactamente un pago acreditado.',
                    [
                        'intento_id' => $intento->id,
                        'mercadopago_order_id' => $ordenMP->id,
                        'cantidad_pagos' => $pagosAcreditados->count(),
                    ]
                );

                $resultado['errores']++;

                return;
            }

            $pago = $pagosAcreditados->first();

            $pagoId = data_get($pago, 'id');

            $importePagado = number_format(
                (float) data_get($pago, 'paid_amount', 0),
                2,
                '.',
                ''
            );

            $totalPagadoOrden = number_format(
                (float) $ordenMP->total_paid_amount,
                2,
                '.',
                ''
            );

            if (
                empty($pagoId) ||
                $importePagado !== $importeEsperado ||
                $totalPagadoOrden !== $importeEsperado
            ) {
                Log::critical(
                    'No se pudo recuperar el pago: el importe acreditado no coincide.',
                    [
                        'intento_id' => $intento->id,
                        'mercadopago_order_id' => $ordenMP->id,
                        'payment_id' => $pagoId,
                        'importe_esperado' => $importeEsperado,
                        'importe_pagado' => $importePagado,
                        'total_pagado_orden' => $totalPagadoOrden,
                    ]
                );

                $resultado['errores']++;

                return;
            }

            $this->procesarPago->procesarPagoConfirmado(
                (int) $intento->id,
                (string) $pagoId,
                (string) $ordenMP->id,
                [
                    'proveedor' => 'mercado_pago',
                    'mercadopago_order_id' => (string) $ordenMP->id,
                    'mercadopago_payment_id' => (string) $pagoId,
                    'order_status' => $ordenMP->status,
                    'order_status_detail' => $ordenMP->status_detail,
                    'payment_status' => data_get($pago, 'status'),
                    'payment_status_detail' => data_get($pago, 'status_detail'),
                    'paid_amount' => $importePagado,
                    'currency' => $ordenMP->currency,
                    'origen' => 'recuperacion_automatica',
                ]
            );

            $resultado['pagos_recuperados']++;

            Log::info(
                'Pago acreditado recuperado correctamente mediante la tarea de expiración.',
                [
                    'intento_id' => $intento->id,
                    'mercadopago_order_id' => $ordenMP->id,
                    'mercadopago_payment_id' => $pagoId,
                ]
            );

            return;
        }

        /*
         * Una orden en procesamiento puede terminar en pago.
         * No la cancelamos ni liberamos el cupón.
         */
        if ($estado === 'processing') {
            $resultado['pendientes']++;

            return;
        }

        /*
         * Solo cancelamos órdenes que Mercado Pago permite cancelar.
         */
        if (in_array($estado, ['created', 'action_required'], true)) {

            $ordenMP = $this->mercadoPago->cancelarOrden(
                (string) $ordenMP->id,
                (int) $intento->id
            );

            $estado = strtolower(
                (string) $ordenMP->status
            );

            $resultado['cancelados_pasarela']++;
        }

        /*
         * Registrar únicamente estados definitivos conocidos.
         */
        if (
            in_array(
                $estado,
                ['canceled', 'cancelled', 'expired', 'failed'],
                true
            )
        ) {
            $pagos = collect(
                data_get($ordenMP, 'transactions.payments', [])
            )->map(fn ($pago) => [
                'id' => data_get($pago, 'id'),
                'status' => data_get($pago, 'status'),
                'status_detail' => data_get($pago, 'status_detail'),
                'amount' => data_get($pago, 'amount'),
                'paid_amount' => data_get($pago, 'paid_amount'),
            ])->values()->all();

            $this->actualizarEstado->actualizar(
                (int) $intento->id,
                [
                    'mercadopago_order_id' => (string) $ordenMP->id,
                    'order_status' => $estado,
                    'order_status_detail' =>
                        (string) $ordenMP->status_detail,
                    'payments' => $pagos,
                    'origen' => 'expiracion_automatica',
                    'expiracion_sincronizada_en' => now()->toIso8601String(),
                ]
            );

            $resultado['expirados']++;

            return;
        }

        /*
         * Cualquier estado desconocido requiere revisión.
         * Nunca liberar el cupón por un estado no reconocido.
         */
        $resultado['pendientes']++;

        Log::warning(
            'Estado de Mercado Pago no contemplado durante la expiración.',
            [
                'intento_id' => $intento->id,
                'mercadopago_order_id' => $ordenMP->id,
                'status' => $estado,
                'status_detail' => $ordenMP->status_detail,
            ]
        );
    }
}