<?php

namespace App\Services\Shop;

use App\Models\CheckoutIntento;
use App\Models\CuponUso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActualizarEstadoCheckoutMercadoPagoService
{
    public function actualizar(
        int $intentoId,
        array $datosMercadoPago
    ): void {
        DB::transaction(function () use (
            $intentoId,
            $datosMercadoPago
        ) {
            $intento = CheckoutIntento::query()
                ->whereKey($intentoId)
                ->lockForUpdate()
                ->firstOrFail();

            $estadoOrden = strtolower(
                (string) ($datosMercadoPago['order_status'] ?? '')
            );

            $detalleOrden = strtolower(
                (string) ($datosMercadoPago['order_status_detail'] ?? '')
            );

            /*
             * Traducir el estado de Mercado Pago
             * al estado interno de nuestro checkout.
             */
            $nuevoEstado = match ($estadoOrden) {
                'created' => 'pendiente',

                'action_required' => 'pendiente',

                'processing' => 'procesando',

                'failed' => 'rechazado',
                
                'expired' => 'expirado',

                'canceled' => $detalleOrden === 'expired'
                    ? 'expirado'
                    : 'cancelado',

                default => null,
            };

            /*
             * Guardar la información más reciente de Mercado Pago.
             * No sustituimos el resto de los datos de respuesta_pasarela.
             */
            $respuesta = (array) $intento->respuesta_pasarela;

            $respuesta['mercadopago_estado'] = array_merge(
                (array) ($respuesta['mercadopago_estado'] ?? []),
                $datosMercadoPago,
                [
                    'consultado_en' => now()->toIso8601String(),
                ]
            );

            $intento->respuesta_pasarela = $respuesta;

            /*
             * Si el pago ya generó una orden, nunca debemos
             * cambiar el estado del intento ni revertir el pago.
             *
             * Esto también permite registrar posteriormente
             * información de reembolsos o contracargos.
             */
            if (
                $intento->orden_id ||
                $intento->estado === 'aprobado'
            ) {
                $intento->save();

                if (
                    in_array(
                        $estadoOrden,
                        ['refunded', 'charged_back'],
                        true
                    )
                ) {
                    Log::warning(
                        'Mercado Pago notificó un cambio posterior al pago.',
                        [
                            'intento_id' => $intento->id,
                            'orden_id' => $intento->orden_id,
                            'order_status' => $estadoOrden,
                            'order_status_detail' => $detalleOrden,
                        ]
                    );
                }

                return;
            }

            /*
             * No modificar estados definitivos por una notificación
             * posterior que indique un estado anterior.
             */
            $estadosDefinitivos = [
                'rechazado',
                'cancelado',
                'expirado',
            ];

            if (
                ! in_array(
                    $intento->estado,
                    $estadosDefinitivos,
                    true
                ) &&
                $nuevoEstado !== null
            ) {
                $intento->estado = $nuevoEstado;
            }

            $intento->save();

            /*
             * Si Mercado Pago confirmó un rechazo, cancelación
             * o vencimiento, liberar la reserva del cupón.
             *
             * No se toca inventario porque este checkout
             * nunca reservó existencias temporalmente.
             */
            if (
                in_array(
                    $nuevoEstado,
                    ['rechazado', 'cancelado', 'expirado'],
                    true
                )
            ) {
                CuponUso::query()
                    ->where('checkout_intento_id', $intento->id)
                    ->where('estado', 'reservado')
                    ->update([
                        'estado' => 'cancelado',
                        'updated_at' => now(),
                    ]);
            }

            /*
             * Un reembolso o contracargo sin orden local requiere
             * revisión, no debemos crear una orden automáticamente.
             */
            if (
                in_array(
                    $estadoOrden,
                    ['refunded', 'charged_back'],
                    true
                )
            ) {
                Log::critical(
                    'Se recibió un reembolso o contracargo sin orden local vinculada.',
                    [
                        'intento_id' => $intento->id,
                        'mercadopago_order_id' =>
                            $intento->mercadopago_order_id,
                        'order_status' => $estadoOrden,
                        'order_status_detail' => $detalleOrden,
                    ]
                );
            }
        }, 3);
    }
}