<?php

namespace App\Services\Shop;

use App\Models\Orden;
use Illuminate\Support\Str;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Order\OrderClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use RuntimeException;

class MercadoPagoService
{
    /**
     * Crear o recuperar el checkout de una orden existente.
     */
    public function crearCheckout(Orden $orden): string
    {
        // Cargar al comprador.
        $orden->loadMissing('usuario');

        // Evitar iniciar otro pago para una orden pagada.
        if ($orden->estado_pago === 'pagado') {
            throw new RuntimeException(
                'Esta orden ya se encuentra pagada.'
            );
        }

        // Comprobar que existe el Access Token.
        $accessToken = config('services.mercadopago.access_token');

        if (empty($accessToken)) {
            throw new RuntimeException(
                'No está configurado el Access Token de Mercado Pago.'
            );
        }

        // Si ya existe una URL de checkout, reutilizarla.
        if (
            $orden->mercadopago_order_id &&
            $orden->mercadopago_checkout_url
        ) {
            return $orden->mercadopago_checkout_url;
        }

        // Crear y guardar la clave antes de realizar la petición.
        // Así podemos reutilizarla si ocurre un error de conexión.
        if (!$orden->mercadopago_idempotency_key) {
            $orden->forceFill([
                'mercadopago_idempotency_key' => (string) Str::uuid(),
            ])->save();
        }

        // Configurar el SDK.
        MercadoPagoConfig::setAccessToken($accessToken);

        // Inicializar el cliente de Orders API.
        $client = new OrderClient();

        // El total ya contempla descuentos y envío.
        $total = number_format(
            (float) $orden->total,
            2,
            '.',
            ''
        );

        // URL de regreso a la confirmación de nuestra orden.
        $urlConfirmacion = route(
            'pedido.confirmacion',
            ['orden' => $orden->id]
        );

        // Construir la solicitud de Checkout Pro.
        $request = [
            'type' => 'online',

            'processing_mode' => 'manual',

            'capture_mode' => 'automatic',

            'total_amount' => $total,

            'external_reference' => (string) $orden->numero,

            'description' => 'Pedido ' . $orden->numero,

            'payer' => [
                'email' => $orden->usuario->email,
            ],

            // Un solo concepto por el total final del pedido.
            // Así incluimos correctamente descuentos y envío.
            'items' => [
                [
                    'title' => 'Pedido ' . $orden->numero,
                    'quantity' => 1,
                    'unit_price' => $total,
                ],
            ],

            'config' => [
                'online' => [
                    'success_url' => $urlConfirmacion,
                    'failure_url' => $urlConfirmacion,
                    'pending_url' => $urlConfirmacion,
                ],
            ],
        ];

        // Configurar idempotencia.
        $requestOptions = new RequestOptions();

        $requestOptions->setCustomHeaders([
            'X-Idempotency-Key: ' .
            $orden->mercadopago_idempotency_key,
        ]);

        try {
            // Crear la orden en Mercado Pago.
            $respuesta = $client->create(
                $request,
                $requestOptions
            );

            // Verificar que recibimos los datos necesarios.
            if (
                empty($respuesta->id) ||
                empty($respuesta->checkout_url)
            ) {
                throw new RuntimeException(
                    'Mercado Pago no devolvió los datos del checkout.'
                );
            }

            // Guardar la referencia y URL de pago.
            $orden->forceFill([
                'mercadopago_order_id' => $respuesta->id,
                'mercadopago_checkout_url' => $respuesta->checkout_url,
                'metodo_pago' => 'mercadopago',
            ])->save();

            return $respuesta->checkout_url;

        } catch (MPApiException $e) {

            report($e);

            throw new RuntimeException(
                'No fue posible crear el checkout de Mercado Pago. ' .
                'Revisa el registro de errores para conocer el detalle.',
                previous: $e
            );
        }
    }
}