<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Throwable;
use App\Models\Orden;
use App\Services\Shop\CancelarOrdenService;
use DomainException;

#[Signature('app:cancelar-ordenes-expiradas')]
#[Description('Command description')]
class CancelarOrdenesExpiradas extends Command
{
    /**
     * Execute the console command.
     */
    protected $signature = 'ordenes:cancelar-expiradas';

    protected $description =
        'Cancela pedidos pendientes que superaron su tiempo de reserva y libera sus recursos.';
    public function handle()
    {
        $ahora = now();

        $minutosReserva = max(
            1,
            (int) config('tienda.reserva_minutos_orden', 30)
        );

        // Compatibilidad con pedidos antiguos que todavía no
        // tenían registrada una fecha_expiracion.
        $limitePedidosAntiguos = $ahora
            ->copy()
            ->subMinutes($minutosReserva);

        $canceladas = 0;
        $omitidas = 0;
        $errores = 0;

        Orden::query()
            ->where('estado', 'pendiente')
            ->where('estado_pago', 'pendiente')
            ->where(function (Builder $query) use (
                $ahora,
                $limitePedidosAntiguos
            ) {
                $query
                    ->where(function (Builder $subquery) use ($ahora) {
                        $subquery
                            ->whereNotNull('fecha_expiracion')
                            ->where('fecha_expiracion', '<=', $ahora);
                    })
                    ->orWhere(function (Builder $subquery) use (
                        $limitePedidosAntiguos
                    ) {
                        $subquery
                            ->whereNull('fecha_expiracion')
                            ->where('created_at', '<=', $limitePedidosAntiguos);
                    });
            })
            ->orderBy('id')
            ->chunkById(100, function ($ordenes) use (
                $servicio,
                &$canceladas,
                &$omitidas,
                &$errores
            ) {
                foreach ($ordenes as $orden) {
                    try {
                        // Reutiliza la lógica centralizada para restaurar
                        // inventario y liberar el cupón reservado.
                        $servicio->cancelar(
                            $orden,
                            (int) $orden->user_id
                        );

                        $canceladas++;

                        $this->line(
                            "Pedido {$orden->numero} cancelado por expiración."
                        );
                    } catch (DomainException $e) {
                        // El pedido pudo cambiar de estado mientras
                        // el comando estaba procesándolo.
                        $omitidas++;

                        $this->warn(
                            "Pedido {$orden->numero} omitido: {$e->getMessage()}"
                        );
                    } catch (Throwable $e) {
                        report($e);

                        $errores++;

                        $this->error(
                            "Error al cancelar el pedido {$orden->numero}."
                        );
                    }
                }
            });

        $this->info("Pedidos cancelados: {$canceladas}");
        $this->info("Pedidos omitidos: {$omitidas}");
        $this->info("Errores: {$errores}");

        return $errores > 0 ? self::FAILURE : self::SUCCESS;
    }
}