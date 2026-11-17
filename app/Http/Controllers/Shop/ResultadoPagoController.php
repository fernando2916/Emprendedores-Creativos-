<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CheckoutIntento;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ResultadoPagoController extends Controller
{
    public function __invoke(
    Request $request,
    CheckoutIntento $intento,
    string $resultado
    ): View {
    // Solo aceptamos los tres resultados configurados.
    abort_unless(
        in_array($resultado, ['success', 'failure', 'pending'], true),
        404
    );

    /*
    * Mercado Pago agrega parámetros a la URL de retorno.
    * Los ignoramos únicamente para validar la firma;
    * nunca utilizamos esos parámetros para confirmar el pago.
    */
    $parametrosMercadoPago = [
        'order_id',
        'merchant_order_id',
        'preference_id',
        'site_id',
        'processing_mode',
        'merchant_account_id',
    ];

    abort_unless(
        $request->hasValidSignatureWhileIgnoring(
            $parametrosMercadoPago
        ),
        403,
        'El enlace de retorno no es válido o ha expirado.'
    );

    abort_unless(
        $intento->metodo_pago === 'mercado_pago',
        404
    );

    $intento->load([
        'orden.items',
    ]);

    return view(
        'plataforma.shop.pedidos.resultadoPago',
        [
            'intento' => $intento,
            'resultado' => $resultado,
            'puedeVerPedido' =>
                Auth::check()
                && (int) Auth::id() === (int) $intento->user_id,
        ]
    );
    }
}