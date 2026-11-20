<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use App\Services\Shop\ExpirarCheckoutIntentosService;
use Illuminate\Console\Command;

#[Signature('app:expirar-checkout-intentos')]
#[Description('Command description')]
class ExpirarCheckoutIntentos extends Command
{
    /**
     * Execute the console command.
     */

    protected $signature = 'checkout:expirar-intentos';

    protected $description =
        'Expira intentos de checkout vencidos y libera cupones cuando corresponde.';
        
    public function handle( ExpirarCheckoutIntentosService $servicio ): int
    {
        $resultado = $servicio->ejecutar();

        $this->info('Proceso de expiración terminado.');

        $this->table(
            ['Resultado', 'Cantidad'],
            [
                ['Intentos expirados', $resultado['expirados']],
                ['Órdenes canceladas en Mercado Pago', $resultado['cancelados_pasarela']],
                ['Intentos pendientes de resolución', $resultado['pendientes']],
                ['Errores', $resultado['errores']],
            ]
        );

        return $resultado['errores'] > 0
            ? self::FAILURE
            : self::SUCCESS;
    }
}