<?php

namespace App\Services\Shop;

use App\Models\CuponUso;
use App\Models\Orden;
use App\Models\ProductoVariante;
use DomainException;
use Illuminate\Support\Facades\DB;
use App\Services\Shop\NotificadorPedidos;

class CancelarOrdenService
{
    public function cancelar(Orden $orden, int $userId,  bool $esAdministrativo = false ): void
    {
        DB::transaction(function () use ($orden, $userId, $esAdministrativo) {

            // Bloquear la orden para impedir dos cancelaciones simultáneas.
            $orden = Orden::query()
                ->whereKey($orden->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Verificar nuevamente que el pedido pertenezca al usuario.
            if (
                ! $esAdministrativo &&
                (int) $orden->user_id !== $userId
            ) {
                abort(404);
            }

            // No permitir cancelar dos veces ni cancelar pedidos pagados.
            if ($orden->estado !== 'pendiente') {
                throw new DomainException(
                    'Este pedido ya no está pendiente y no se puede cancelar desde esta pantalla.'
                );
            }

            if ($orden->estado_pago !== 'pendiente') {
                throw new DomainException(
                    'El estado del pago no permite cancelar este pedido automáticamente.'
                );
            }

            // Cargar las líneas en un orden estable para bloquear el inventario.
            $items = $orden->items()
                ->orderBy('comprable_id')
                ->lockForUpdate()
                ->get();

            foreach ($items as $item) {

                // En esta etapa solo reservamos inventario físico
                // para las variantes de productos.
                if (
                    $item->comprable_type !== ProductoVariante::class
                ) {
                    continue;
                }

                $variante = ProductoVariante::query()
                    ->whereKey($item->comprable_id)
                    ->lockForUpdate()
                    ->first();

                if (! $variante) {
                    // No existe una fila de inventario que restaurar.
                    // Registramos la incidencia y conservamos la cancelación.
                    report(new \RuntimeException(
                        "No se encontró la variante {$item->comprable_id} " .
                        "para liberar el inventario de la orden {$orden->id}."
                    ));

                    continue;
                }

                $cantidad = (int) $item->cantidad;

                if ($cantidad > 0) {
                    $variante->increment('stock', $cantidad);
                }
            }

            // Liberar la reserva del cupón sin borrar el historial.
            CuponUso::query()
                ->where('orden_id', $orden->id)
                ->where('estado', 'reservado')
                ->update([
                    'estado' => 'cancelado',
                    'usado_en' => null,
                ]);

            // Actualizar el pedido una vez liberadas sus reservas.
            $orden->estado = 'cancelado';
            $orden->estado_pago = 'cancelado';
            $orden->save();
        }, 3);

        /*
        |--------------------------------------------------------------------------
        | Notificar la cancelación
        |--------------------------------------------------------------------------
        |
        | Este código se ejecuta después de confirmar la transacción.
        | Un error de notificación no revierte el inventario liberado.
        |
        */

        try {

            $ordenActualizada = Orden::findOrFail($orden->id);

            app(NotificadorPedidos::class)
                ->pedidoCancelado($ordenActualizada);

        } catch (\Throwable $e) {

            report($e);

            logger()->error(
                'Error al notificar la cancelación del pedido.',
                [
                    'orden_id' => $orden->id,
                    'error' => $e->getMessage(),
                ]
            );
        }
        
    }
}