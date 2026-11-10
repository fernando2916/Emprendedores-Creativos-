<?php

namespace App\Services\Shop;

use App\Models\ZonaEnvioCodigoPostal;

class CalculadoraEnvio
{
    /**
     * Calcular el costo de envío a partir del código postal
     * y del subtotal de productos después de descuentos.
     */
    public function calcular(
        string $codigoPostal,
        float $subtotal
    ): array {
        $codigoPostal = preg_replace(
            '/\D/',
            '',
            $codigoPostal
        ) ?? '';

        $subtotal = round(max(0, $subtotal), 2);

        // Validar que el código postal tenga cinco dígitos.
        if (strlen($codigoPostal) !== 5) {
            return $this->sinCobertura(
                'El código postal no es válido.'
            );
        }

        // Buscar la zona que cubre el código postal.
        $registro = ZonaEnvioCodigoPostal::query()
            ->with('zona')
            ->where('codigo_postal', $codigoPostal)
            ->whereHas('zona', function ($query) {
                $query->where('activa', true);
            })
            ->first();

        if (! $registro || ! $registro->zona) {
            return $this->sinCobertura(
                'Todavía no tenemos una tarifa de envío configurada para este código postal.'
            );
        }

        $zona = $registro->zona;

        $tarifaBase = round((float) $zona->tarifa, 2);

        $umbralEnvioGratis = $zona->monto_minimo_envio_gratis !== null
            ? (float) $zona->monto_minimo_envio_gratis
            : null;

        // Solo se aplica envío gratis si existe un umbral
        // y el subtotal alcanza o supera dicho monto.
        $envioGratis = $umbralEnvioGratis !== null
            && $subtotal >= $umbralEnvioGratis;

        $costoEnvio = $envioGratis
            ? 0.00
            : $tarifaBase;

        $montoFaltante = $umbralEnvioGratis !== null
            ? round(max(0, $umbralEnvioGratis - $subtotal), 2)
            : null;

        return [
            'disponible' => true,

            'zona' => $zona,

            'codigo_postal' => $codigoPostal,

            'tarifa_base' => $tarifaBase,

            'costo_envio' => $costoEnvio,

            'envio_gratis' => $envioGratis,

            'monto_minimo_envio_gratis' => $umbralEnvioGratis,

            'monto_faltante_envio_gratis' => $montoFaltante,

            'subtotal' => $subtotal,

            'total' => round($subtotal + $costoEnvio, 2),

            'mensaje' => $envioGratis
                ? '¡Tu compra cumple el requisito para envío gratis!'
                : (
                    $umbralEnvioGratis !== null
                        ? 'Agrega más productos para obtener envío gratis.'
                        : 'Se aplicará la tarifa de envío de esta zona.'
                ),
        ];
    }

    /**
     * Respuesta uniforme cuando no hay cobertura.
     */
    private function sinCobertura(string $mensaje): array
    {
        return [
            'disponible' => false,

            'zona' => null,

            'codigo_postal' => null,

            'tarifa_base' => null,

            'costo_envio' => null,

            'envio_gratis' => false,

            'monto_minimo_envio_gratis' => null,

            'monto_faltante_envio_gratis' => null,

            'subtotal' => null,

            'total' => null,

            'mensaje' => $mensaje,
        ];
    }
}