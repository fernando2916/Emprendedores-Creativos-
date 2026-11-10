<?php

namespace App\Livewire\Shop;

use App\Models\Orden;
use App\Services\Shop\CancelarOrdenService;
use DomainException;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Throwable;

class CancelarPedido extends Component
{
    public Orden $orden;
    
    public function mount(Orden $orden): void
    {
        abort_unless(
            (int) $orden->user_id === (int) Auth::id(),
            404
        );

        $this->orden = $orden;
    }

    
    public function cancelar(CancelarOrdenService $servicio): void
    {
        try {
            $servicio->cancelar(
                $this->orden,
                (int) Auth::id()
            );
        } catch (DomainException $e) {
            Flux::toast(
                heading: 'No se pudo cancelar el pedido',
                text: $e->getMessage(),
                variant: 'warning',
            );

            return;
        } catch (Throwable $e) {
            report($e);

            Flux::toast(
                heading: 'Error al cancelar',
                text: 'No fue posible cancelar el pedido. Inténtalo nuevamente.',
                variant: 'warning',
            );

            return;
        }

        Flux::toast(
            heading: 'Pedido cancelado',
            text: 'Se liberaron las existencias y el cupón reservado, si correspondía.',
            variant: 'success',
        );

        // Actualizar la página para reflejar el estado cancelado.
        $this->redirectRoute(
            'pedido.confirmacion',
            ['orden' => $this->orden->id],
            navigate: true
        );
    }

    public function render()
    {
        return view('livewire.shop.cancelar-pedido');
    }
}