<?php

namespace App\Services\Shop;

use App\Models\CheckoutIntento;
use Illuminate\Support\Str;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Order\OrderClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use RuntimeException;

class MercadoPagoService
{
    /**
     * Crear o recuperar el checkout de un intento de compra.
     *
     * Importante:
     * - No crea órdenes locales.
     * - No descuenta inventario.
     * - No modifica el estado del pago.
     */
    public function crearCheckout(CheckoutIntento $intento): string
    {
        $intento->loadMissing('usuario');

        if ($intento->estado !== 'pendiente') {
            throw new RuntimeException(
                'Este intento de compra ya no está pendiente.'
            );
        }

        if (
            $intento->fecha_expiracion &&
            $intento->fecha_expiracion->isPast()
        ) {
            throw new RuntimeException(
                'Este intento de compra ha expirado. Regresa al carrito para iniciar una nueva compra.'
            );
        }

        $accessToken = config('services.mercadopago.access_token');

        if (empty($accessToken)) {
            throw new RuntimeException(
                'No está configurado el Access Token de Mercado Pago.'
            );
        }

        // Reutilizar el checkout si ya fue creado.
        if (
            $intento->mercadopago_order_id &&
            $intento->mercadopago_checkout_url
        ) {
            return $intento->mercadopago_checkout_url;
        }

        // La clave debe ser única por intento y persistente.
        if (!$intento->mercadopago_idempotency_key) {
            $intento->forceFill([
                'mercadopago_idempotency_key' => (string) Str::uuid(),
            ])->save();
        }

        MercadoPagoConfig::setAccessToken($accessToken);

        $client = new OrderClient();

        $total = number_format(
            (float) $intento->total,
            2,
            '.',
            ''
        );

        // Una sola línea por el total final.
        // Incluye descuentos y envío.
        $request = [
            'type' => 'online',

            'processing_mode' => 'manual',

            'capture_mode' => 'automatic',

            'total_amount' => $total,

            // Identifica el intento, no una orden local.
            'external_reference' => $intento->referencia_externa,

            'description' => 'Compra ' . $intento->referencia_externa,

            'payer' => [
                'email' => $intento->usuario->email,
            ],

            'items' => [
                [
                    'title' => 'Compra en Emprendedores Creativos',
                    'quantity' => 1,
                    'unit_price' => $total,
                ],
            ],
        ];

        $requestOptions = new RequestOptions();

        $requestOptions->setCustomHeaders([
            'X-Idempotency-Key: ' .
            $intento->mercadopago_idempotency_key,
        ]);

        try {
            $respuesta = $client->create(
                $request,
                $requestOptions
            );

            if (
                empty($respuesta->id) ||
                empty($respuesta->checkout_url)
            ) {
                throw new RuntimeException(
                    'Mercado Pago no devolvió los datos necesarios para iniciar el pago.'
                );
            }

            $intento->forceFill([
                'mercadopago_order_id' => $respuesta->id,
                'mercadopago_checkout_url' => $respuesta->checkout_url,
                'metodo_pago' => 'mercado_pago',
            ])->save();

            return $respuesta->checkout_url;

        } catch (MPApiException $e) {

            report($e);

            throw new RuntimeException(
                'No fue posible crear el checkout de Mercado Pago. Revisa el registro de errores.',
                previous: $e
            );
        }
    }
}