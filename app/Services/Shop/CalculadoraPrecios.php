<?php

namespace App\Services\Shop;

use App\Models\Descuento;
use App\Models\Producto;
use App\Models\ProductoVariante;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CalculadoraPrecios
{
    /**
     * Calcula el precio promocional de una variante.
     */
    public function calcular(
        Producto $producto,
        ProductoVariante $variante
    ): array {
        $descuentos = $this->obtenerDescuentosAplicables($producto);

        return $this->calcularPrecio(
            (float) $variante->precio,
            $descuentos
        );
    }

    /**
     * Calcula los precios de todas las variantes activas de un producto.
     *
     * Se consultan las promociones una sola vez para todas las variantes
     * del producto, evitando repetir esa consulta por cada variante.
     */
    public function calcularVariantes(Producto $producto): Collection
    {
        $descuentos = $this->obtenerDescuentosAplicables($producto);

        return $producto->variantes
            ->filter(fn (ProductoVariante $variante) => (bool) $variante->estado)
            ->map(function (ProductoVariante $variante) use ($descuentos) {
                return [
                    'variante' => $variante,
                ] + $this->calcularPrecio(
                    (float) $variante->precio,
                    $descuentos
                );
            })
            ->values();
    }

    /**
     * Obtiene las promociones vigentes que corresponden al producto.
     */
    private function obtenerDescuentosAplicables(
        Producto $producto
    ): Collection {
        return Descuento::query()
            ->vigentes()
            ->where(function (Builder $query) use ($producto) {
                // Promociones para toda la tienda.
                $query->where('alcance', 'tienda');

                // Promociones relacionadas con la categoría del producto.
                if ($producto->categoria_id !== null) {
                    $query->orWhere(function (Builder $subquery) use ($producto) {
                        $subquery
                            ->where('alcance', 'categoria')
                            ->whereHas('categorias', function (Builder $categorias) use ($producto) {
                                $categorias->where(
                                    'categorias.id',
                                    $producto->categoria_id
                                );
                            });
                    });
                }

                // Promociones asignadas directamente al producto.
                $query->orWhere(function (Builder $subquery) use ($producto) {
                    $subquery
                        ->where('alcance', 'producto')
                        ->whereHas('productos', function (Builder $productos) use ($producto) {
                            $productos->where(
                                'productos.id',
                                $producto->id
                            );
                        });
                });
            })
            ->orderBy('id')
            ->get();
    }

    /**
     * Calcula el precio final y elige una sola promoción.
     */
    private function calcularPrecio(
        float $precioOriginal,
        Collection $descuentos
    ): array {
        $precioOriginal = round(max(0, $precioOriginal), 2);

        $candidatos = [];

        foreach ($descuentos as $descuento) {
            $valor = (float) $descuento->valor;

            $precioFinal = match ($descuento->tipo) {
                'porcentaje' => round(
                    $precioOriginal * (1 - ($valor / 100)),
                    2
                ),

                'importe_fijo' => round(
                    max(0, $precioOriginal - $valor),
                    2
                ),

                // Un precio fijo igual o superior al original no es válido.
                'precio_fijo' => $valor < $precioOriginal
                    ? round($valor, 2)
                    : $precioOriginal,

                default => $precioOriginal,
            };

            $precioFinal = max(0, $precioFinal);

            // Ignorar promociones que no reduzcan el precio.
            if ($precioFinal >= $precioOriginal) {
                continue;
            }

            $candidatos[] = [
                'descuento' => $descuento,
                'precio_final' => $precioFinal,
                'prioridad' => $this->prioridadAlcance($descuento),
            ];
        }

        // Primero el precio más bajo. Si empatan, gana el alcance específico.
        usort($candidatos, function (array $a, array $b): int {
            $comparacionPrecio = $a['precio_final'] <=> $b['precio_final'];

            if ($comparacionPrecio !== 0) {
                return $comparacionPrecio;
            }

            $comparacionPrioridad = $a['prioridad'] <=> $b['prioridad'];

            if ($comparacionPrioridad !== 0) {
                return $comparacionPrioridad;
            }

            return $a['descuento']->id <=> $b['descuento']->id;
        });

        $mejor = $candidatos[0] ?? null;

        $precioFinal = $mejor['precio_final'] ?? $precioOriginal;
        $ahorro = round($precioOriginal - $precioFinal, 2);

        return [
            'precio_original' => $precioOriginal,
            'precio_final' => $precioFinal,
            'ahorro' => $ahorro,

            'porcentaje_ahorro' => $precioOriginal > 0
                ? round(($ahorro / $precioOriginal) * 100, 2)
                : 0,

            'descuento_aplicado' => $mejor['descuento'] ?? null,
            'aplicado' => $mejor !== null,
        ];
    }

    /**
     * Prioridad utilizada únicamente cuando dos promociones
     * dejan exactamente el mismo precio final.
     */
    private function prioridadAlcance(Descuento $descuento): int
    {
        return match ($descuento->alcance) {
            'producto' => 1,
            'categoria' => 2,
            'tienda' => 3,
            default => 4,
        };
    }
}