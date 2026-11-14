<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Services\Shop\MercadoPagoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class PagoController extends Controller
{
    public function iniciar(
    Orden $orden,
    MercadoPagoService $mercadoPago
    ): RedirectResponse {

    // Comprobar que el pedido pertenece al usuario autenticado.
    abort_unless(
        (int) $orden->user_id === (int) Auth::id(),
        404
    );

    try {

        $url = $mercadoPago->crearCheckout($orden);

        // Redirigir al checkout alojado por Mercado Pago.
        return redirect()->away($url);

    } catch (Throwable $e) {

        report($e);

        return redirect()
            ->route('pedido.confirmacion', [
                'orden' => $orden->id,
            ])
            ->with(
                'error',
                $e->getMessage() ?: 'No fue posible iniciar el pago. Inténtalo nuevamente.'
            );
    }
    }
}