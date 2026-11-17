<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CheckoutIntento;
use App\Services\Shop\MercadoPagoService;
use App\Services\Shop\ProcesarPagoCheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use MercadoPago\Exceptions\InvalidWebhookSignatureException;
use MercadoPago\Webhook\WebhookSignatureValidator;
use Throwable;

class MercadoPagoWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        MercadoPagoService $mercadoPago,
        ProcesarPagoCheckoutService $procesarPago
        ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | 1. Obtener los datos de la notificación
        |--------------------------------------------------------------------------
        */

        $dataId = $request->query('data_id')
        ?? $request->query('data.id');

        $firma = $request->header('x-signature');
        $requestId = $request->header('x-request-id');

        $secret = config('services.mercadopago.webhook_secret');

        if (empty($secret)) {
            Log::critical(
                'No está configurado el secreto del webhook de Mercado Pago.'
            );

            return response()->json([
                'message' => 'Webhook no configurado.',
            ], 500);
        }

        if (empty($dataId) || empty($firma) || empty($requestId)) {
            return response()->json([
                'message' => 'Notificación incompleta.',
            ], 400);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Verificar el tipo de notificación
        |--------------------------------------------------------------------------
        */

        $tipo = $request->query('type')
            ?? $request->input('type');

        if ($tipo !== 'order') {
            return response()->json([
                'received' => true,
                'message' => 'Evento ignorado.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Validar la firma de Mercado Pago
        |--------------------------------------------------------------------------
        */

        try {

            WebhookSignatureValidator::validate(
                $firma,
                $requestId,
                (string) $dataId,
                $secret,
                300
            );

        } catch (InvalidWebhookSignatureException $e) {

            Log::warning(
                'Firma inválida en webhook de Mercado Pago.',
                [
                    'request_id' => $e->getRequestId(),
                    'reason' => $e->getReason(),
                ]
            );

            return response()->json([
                'message' => 'Firma inválida.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Consultar la orden directamente en Mercado Pago
        |--------------------------------------------------------------------------
        */

        try {

            $ordenMP = $mercadoPago->consultarOrden(
                (string) $dataId
            );

        } catch (Throwable $e) {

            report($e);

            // Permite que Mercado Pago reintente la notificación.
            return response()->json([
                'message' => 'No fue posible consultar la orden.',
            ], 503);
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Comprobar la identidad de la orden
        |--------------------------------------------------------------------------
        */

        if (
            empty($ordenMP->id) ||
            ! hash_equals((string) $dataId, (string) $ordenMP->id)
        ) {
            Log::critical(
                'El ID consultado no coincide con la orden recibida.',
                [
                    'data_id' => $dataId,
                    'order_id' => $ordenMP->id ?? null,
                ]
            );

            return response()->json([
                'received' => true,
                'message' => 'Orden no coincidente.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Localizar el intento de checkout
        |--------------------------------------------------------------------------
        */

        $intento = CheckoutIntento::query()
            ->where('mercadopago_order_id', $ordenMP->id)
            ->where('metodo_pago', 'mercado_pago')
            ->first();

        if (! $intento) {

            Log::warning(
                'Se recibió una orden de Mercado Pago sin intento local asociado.',
                [
                    'mercadopago_order_id' => $ordenMP->id,
                    'external_reference' => $ordenMP->external_reference,
                ]
            );

            return response()->json([
                'received' => true,
                'message' => 'Orden sin intento local.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Validar referencia externa, importe y moneda
        |--------------------------------------------------------------------------
        */

        $referenciaCorrecta = hash_equals(
            (string) $intento->referencia_externa,
            (string) $ordenMP->external_reference
        );

        $importeEsperado = number_format(
            (float) $intento->total,
            2,
            '.',
            ''
        );

        $importeOrden = number_format(
            (float) $ordenMP->total_amount,
            2,
            '.',
            ''
        );

        $monedaCorrecta = strtoupper((string) $ordenMP->currency)
            === strtoupper((string) $intento->moneda);

        if (
            ! $referenciaCorrecta ||
            $importeEsperado !== $importeOrden ||
            ! $monedaCorrecta
        ) {

            Log::critical(
                'Los datos de la orden de Mercado Pago no coinciden con el checkout local.',
                [
                    'intento_id' => $intento->id,
                    'order_id' => $ordenMP->id,
                    'referencia_correcta' => $referenciaCorrecta,
                    'importe_esperado' => $importeEsperado,
                    'importe_recibido' => $importeOrden,
                    'moneda_local' => $intento->moneda,
                    'moneda_mp' => $ordenMP->currency,
                ]
            );

            return response()->json([
                'received' => true,
                'message' => 'Los datos de la orden no coinciden.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 8. Verificar que la orden esté pagada y acreditada
        |--------------------------------------------------------------------------
        */

        if (
            $ordenMP->status !== 'processed' ||
            $ordenMP->status_detail !== 'accredited'
        ) {

            Log::info(
                'La orden de Mercado Pago todavía no está acreditada.',
                [
                    'order_id' => $ordenMP->id,
                    'status' => $ordenMP->status,
                    'status_detail' => $ordenMP->status_detail,
                ]
            );

            return response()->json([
                'received' => true,
                'message' => 'El pago todavía no está acreditado.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 9. Obtener el pago aprobado
        |--------------------------------------------------------------------------
        */

        $pagos = collect(
            data_get($ordenMP, 'transactions.payments', [])
        );

        $pagosAcreditados = $pagos->filter(
            fn ($pago) =>
                data_get($pago, 'status') === 'processed' &&
                data_get($pago, 'status_detail') === 'accredited'
        )->values();

        // Checkout Pro debe tener un único pago acreditado para este flujo.
        if ($pagosAcreditados->count() !== 1) {

            Log::critical(
                'La orden no contiene exactamente un pago acreditado.',
                [
                    'order_id' => $ordenMP->id,
                    'cantidad_pagos_acreditados' => $pagosAcreditados->count(),
                ]
            );

            return response()->json([
                'received' => true,
                'message' => 'No se pudo identificar un único pago acreditado.',
            ]);
        }

        $pago = $pagosAcreditados->first();

        $pagoId = data_get($pago, 'id');

        $importePagado = number_format(
            (float) data_get($pago, 'paid_amount', 0),
            2,
            '.',
            ''
        );

        $totalPagadoOrden = number_format(
            (float) $ordenMP->total_paid_amount,
            2,
            '.',
            ''
        );

        if (
            empty($pagoId) ||
            $importePagado !== $importeEsperado ||
            $totalPagadoOrden !== $importeEsperado
        ) {

            Log::critical(
                'El importe efectivamente pagado no coincide con el checkout.',
                [
                    'order_id' => $ordenMP->id,
                    'payment_id' => $pagoId,
                    'importe_esperado' => $importeEsperado,
                    'importe_pagado' => $importePagado,
                    'total_pagado_orden' => $totalPagadoOrden,
                ]
            );

            return response()->json([
                'received' => true,
                'message' => 'El importe pagado no coincide.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 10. Procesar el pago confirmado
        |--------------------------------------------------------------------------
        */

        try {

            $ordenLocal = $procesarPago->procesarPagoConfirmado(
                (int) $intento->id,
                (string) $pagoId,
                (string) $ordenMP->id,
                [
                    'proveedor' => 'mercado_pago',
                    'mercadopago_order_id' => $ordenMP->id,
                    'mercadopago_payment_id' => $pagoId,
                    'order_status' => $ordenMP->status,
                    'order_status_detail' => $ordenMP->status_detail,
                    'payment_status' => data_get($pago, 'status'),
                    'payment_status_detail' => data_get($pago, 'status_detail'),
                    'paid_amount' => $importePagado,
                    'currency' => $ordenMP->currency,
                    'notification_id' => $request->input('id'),
                    'notification_action' => $request->input('action'),
                ]
            );

            Log::info(
                'Pago de Mercado Pago procesado correctamente.',
                [
                    'intento_id' => $intento->id,
                    'orden_local_id' => $ordenLocal->id,
                    'mercadopago_order_id' => $ordenMP->id,
                    'mercadopago_payment_id' => $pagoId,
                ]
            );

            return response()->json([
                'received' => true,
                'processed' => true,
            ]);

        } catch (Throwable $e) {

            report($e);

            // Si falla el procesamiento local, Mercado Pago podrá reintentar.
            return response()->json([
                'message' => 'No fue posible procesar el pago localmente.',
            ], 500);
        }
    }
}