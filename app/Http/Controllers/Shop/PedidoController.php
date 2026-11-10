<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Orden;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Shop\CancelarOrdenService;
use DomainException;
use Throwable;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function show(Orden $orden): View
    {
        // Cada usuario solo puede ver sus propios pedidos.
        abort_unless(
            (int) $orden->user_id === (int) Auth::id(),
            404
        );

        $orden->load('items');

        return view(
            'plataforma.shop.pedidos.showConfirmacion',
            compact('orden')
        );
    }

    public function cancelar(
        Orden $orden,
        CancelarOrdenService $servicio
        ) {
        abort_unless(
            (int) $orden->user_id === (int) Auth::id(),
            404
        );

        try {
            $servicio->cancelar(
                $orden,
                (int) Auth::id()
            );

        } catch (DomainException $e) {

            return redirect()
                ->route('pedido.confirmacion', ['orden' => $orden->id])
                ->with('error', $e->getMessage());

        } catch (Throwable $e) {

            report($e);

            return redirect()
                ->route('pedido.confirmacion', ['orden' => $orden->id])
                ->with(
                    'error',
                    'No se pudo cancelar el pedido. Inténtalo nuevamente.'
                );
        }

        return redirect()
            ->route('pedido.confirmacion', ['orden' => $orden->id])
            ->with(
                'success',
                'El pedido se canceló correctamente y se liberaron sus reservas.'
            );
    }
}