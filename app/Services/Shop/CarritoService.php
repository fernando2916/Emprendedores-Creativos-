<?php

namespace App\Services\Shop;

use App\Models\Carrito as CarritoModel;
use App\Models\ProductoVariante;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CarritoService
{
    /**
     * Obtener o crear el carrito del usuario autenticado.
     */
    public function obtenerOCrear(User $usuario): CarritoModel
    {
        return $usuario->carrito()->firstOrCreate([]);
    }

    /**
     * Migrar artículos de la sesión a la base de datos.
     * Las cantidades existentes se suman a las del carrito persistente.
     */
    public function sincronizarSesion(User $usuario): CarritoModel
    {
        $carrito = $this->obtenerOCrear($usuario);
        $lineasSesion = session()->get('carrito', []);

        if (! is_array($lineasSesion) || empty($lineasSesion)) {
            session()->forget('carrito');

            return $carrito;
        }

        DB::transaction(function () use ($carrito, $lineasSesion) {
            $ids = collect($lineasSesion)
                ->map(fn ($linea, $key) =>
                    (int) ($linea['variante_id'] ?? $key)
                )
                ->filter(fn ($id) => $id > 0)
                ->unique()
                ->values();

            $variantes = ProductoVariante::query()
                ->whereIn('id', $ids)
                ->get()
                ->keyBy('id');

            foreach ($lineasSesion as $key => $linea) {
                $varianteId = (int) ($linea['variante_id'] ?? $key);

                $variante = $variantes->get($varianteId);

                // Ignorar referencias a variantes que ya no existen.
                if (! $variante) {
                    continue;
                }

                $cantidad = max(
                    1,
                    (int) ($linea['cantidad'] ?? 1)
                );

                $item = $carrito->items()
                    ->where('comprable_type', ProductoVariante::class)
                    ->where('comprable_id', $variante->id)
                    ->lockForUpdate()
                    ->first();

                if ($item) {
                    $item->cantidad += $cantidad;
                    $item->save();
                } else {
                    $carrito->items()->create([
                        'comprable_type' => ProductoVariante::class,
                        'comprable_id' => $variante->id,
                        'cantidad' => $cantidad,
                    ]);
                }
            }
        });

        // La sesión deja de ser la fuente del carrito.
        session()->forget('carrito');

        return $carrito->fresh();
    }

    /**
     * Agregar una variante, respetando la cantidad que ya hay
     * en el carrito persistente.
     *
     * Resultados: agregado, stock, no_disponible.
     */
    public function agregarVariante(
        User $usuario,
        int $varianteId,
        int $cantidad
    ): string {
        $this->sincronizarSesion($usuario);

        return DB::transaction(function () use (
            $usuario,
            $varianteId,
            $cantidad
        ) {
            $variante = ProductoVariante::query()
                ->with('producto')
                ->lockForUpdate()
                ->find($varianteId);

            if (
                ! $variante ||
                ! $variante->estado ||
                ! $variante->producto ||
                ! $variante->producto->estado
            ) {
                return 'no_disponible';
            }

            $carrito = $this->obtenerOCrear($usuario);

            $item = $carrito->items()
                ->where('comprable_type', ProductoVariante::class)
                ->where('comprable_id', $variante->id)
                ->lockForUpdate()
                ->first();

            $cantidadActual = (int) ($item?->cantidad ?? 0);
            $cantidadNueva = $cantidadActual + max(1, $cantidad);

            if ($cantidadNueva > $variante->stock) {
                return 'stock';
            }

            if ($item) {
                $item->cantidad = $cantidadNueva;
                $item->save();
            } else {
                $carrito->items()->create([
                    'comprable_type' => ProductoVariante::class,
                    'comprable_id' => $variante->id,
                    'cantidad' => $cantidadNueva,
                ]);
            }

            return 'agregado';
        });
    }

    /**
     * Incrementar o disminuir la cantidad de una variante.
     *
     * Resultados: actualizado, minimo, stock, no_disponible,
     * no_encontrado.
     */
    public function cambiarCantidad(
        User $usuario,
        int $varianteId,
        int $cambio
    ): string {
        $carrito = $this->obtenerOCrear($usuario);

        return DB::transaction(function () use (
            $carrito,
            $varianteId,
            $cambio
        ) {
            $item = $carrito->items()
                ->where('comprable_type', ProductoVariante::class)
                ->where('comprable_id', $varianteId)
                ->lockForUpdate()
                ->first();

            if (! $item) {
                return 'no_encontrado';
            }

            $cantidadNueva = (int) $item->cantidad + $cambio;

            if ($cantidadNueva < 1) {
                return 'minimo';
            }

            $variante = ProductoVariante::query()
                ->with('producto')
                ->lockForUpdate()
                ->find($varianteId);

            if ($cambio > 0) {
                if (
                    ! $variante ||
                    ! $variante->estado ||
                    ! $variante->producto ||
                    ! $variante->producto->estado
                ) {
                    return 'no_disponible';
                }

                if ($cantidadNueva > $variante->stock) {
                    return 'stock';
                }
            }

            $item->cantidad = $cantidadNueva;
            $item->save();

            return 'actualizado';
        });
    }

    /**
     * Eliminar una variante del carrito del usuario.
     */
    public function eliminarVariante(
        User $usuario,
        int $varianteId
    ): bool {
        $carrito = $usuario->carrito()->first();

        if (! $carrito) {
            return false;
        }

        return $carrito->items()
            ->where('comprable_type', ProductoVariante::class)
            ->where('comprable_id', $varianteId)
            ->delete() > 0;
    }

    /**
     * Comprobar si la variante está dentro del carrito.
     */
    public function contieneVariante(
        User $usuario,
        int $varianteId
    ): bool {
        $carrito = $usuario->carrito()->first();

        if (! $carrito) {
            return false;
        }

        return $carrito->items()
            ->where('comprable_type', ProductoVariante::class)
            ->where('comprable_id', $varianteId)
            ->exists();
    }

    /**
     * Total de unidades de todos los tipos de artículos.
     */
    public function cantidadTotal(User $usuario): int
    {
        $carrito = $usuario->carrito()->first();

        if (! $carrito) {
            return 0;
        }

        return (int) $carrito->items()->sum('cantidad');
    }
}