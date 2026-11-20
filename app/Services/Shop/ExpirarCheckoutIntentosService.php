<?php

namespace App\Services\Shop;

use App\Models\CheckoutIntento;
use Illuminate\Support\Facades\Log;
use Throwable;

class ExpirarCheckoutIntentosService
{
    public function __construct(
        private MercadoPagoService $mercadoPago,
        private ActualizarEstadoCheckoutMercadoPagoService $actualizarEstado
    ) {
    }

    public function ejecutar(): array
    {
        $resultado = [
            'expirados' => 0,
            'cancelados_pasarela' => 0,
            'pendientes' => 0,
            'errores' => 0,
        ];

        CheckoutIntento::query()
            ->whereIn('estado', ['pendiente', 'procesando'])
            ->whereNotNull('fecha_expiracion')
            ->where('fecha_expiracion', '<=', now())
            ->whereNull('orden_id')
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
         * Si ya se acreditó, jamás cancelar ni liberar el cupón.
         * El webhook se encargará del procesamiento definitivo.
         */
        if (
            $estado === 'processed' &&
            $ordenMP->status_detail === 'accredited'
        ) {
            Log::warning(
                'Se encontró un pago acreditado durante la expiración de un checkout. Se espera el webhook.',
                [
                    'intento_id' => $intento->id,
                    'mercadopago_order_id' => $ordenMP->id,
                ]
            );

            $resultado['pendientes']++;

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