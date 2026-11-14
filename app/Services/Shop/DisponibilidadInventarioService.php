<?php

namespace App\Services\Shop;

use App\Models\OrdenStockEspera;
use App\Models\ProductoVariante;

class DisponibilidadInventarioService
{
    /**
     * Consulta las unidades comprometidas en pedidos pagados
     * que todavía están esperando inventario.
     */
    public function unidadesComprometidas(int $varianteId): int
    {
        return (int) OrdenStockEspera::query()
            ->where('producto_variante_id', $varianteId)
            ->where('estado', 'pendiente')
            ->whereHas('orden', function ($query) {
                $query
                    ->where('estado', 'en_espera_stock')
                    ->where('estado_pago', 'pagado')
                    ->where(function ($query) {
                        $query
                            ->whereNull('estado_reembolso')
                            ->orWhere('estado_reembolso', '!=', 'refunded');
                    });
            })
            ->sum('cantidad');
    }

    /**
     * Calcula el stock que realmente puede venderse.
     */
    public function consultar(ProductoVariante $variante): array
    {
        $stockFisico = (int) $variante->stock;

        $comprometido = $this->unidadesComprometidas(
            $variante->id
        );

        $disponible = max(0, $stockFisico - $comprometido);

        return [
            'stock_fisico' => $stockFisico,
            'unidades_comprometidas' => $comprometido,
            'disponible' => $disponible,
        ];
    }

    /**
     * Devuelve únicamente las unidades disponibles para venta.
     */
    public function disponibleParaVenta(ProductoVariante $variante): int
    {
        return $this->consultar($variante)['disponible'];
    }

    /**
     * Comprueba si existe disponibilidad suficiente.
     */
    public function puedeSatisfacer(
        ProductoVariante $variante,
        int $cantidad
    ): bool {
        if ($cantidad < 1) {
            return false;
        }

        return $this->disponibleParaVenta($variante) >= $cantidad;
    }
}