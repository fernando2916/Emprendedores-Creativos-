<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\CheckoutIntento;
use App\Services\Shop\MercadoPagoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class PagoController extends Controller
{
    public function iniciar(
        CheckoutIntento $intento,
        MercadoPagoService $mercadoPago
    ): RedirectResponse {

        // El intento solamente puede ser utilizado por su propietario.
        abort_unless(
            (int) $intento->user_id === (int) Auth::id(),
            404
        );

        try {
            $url = $mercadoPago->crearCheckout($intento);

            return redirect()->away($url);

        } catch (Throwable $e) {

            report($e);

            return redirect()
                ->route('checkout.index')
                ->with(
                    'error',
                    $e->getMessage() ?: 'No fue posible iniciar el pago. Inténtalo nuevamente.'
                );
        }
    }
}