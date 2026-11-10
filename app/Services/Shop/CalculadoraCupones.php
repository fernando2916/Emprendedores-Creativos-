<?php

namespace App\Services\Shop;

use App\Models\Categoria;
use App\Models\Cupon;
use App\Models\CuponObjetivo;
use App\Models\CuponUso;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CalculadoraCupones
{
    /**
     * Busca el código y calcula su descuento sobre las líneas
     * que ya tienen aplicado el descuento automático.
     *
     * Cada línea debe contener:
     * modelo, cantidad y precio_unitario.
     */
    public function validarYCalcular(
        string $codigo,
        User $usuario,
        Collection $lineas
    ): array {
        $codigo = mb_strtoupper(trim($codigo));

        if ($codigo === '') {
            return $this->respuestaInvalida(
                'Escribe un código de cupón.',
                null,
                $this->totalLineas($lineas)
            );
        }

        $cupon = Cupon::query()
            ->where('codigo', $codigo)
            ->first();

        if (!$cupon) {
            return $this->respuestaInvalida(
                'El código de cupón no existe.',
                null,
                $this->totalLineas($lineas)
            );
        }

        return $this->calcularCupon($cupon, $usuario, $lineas);
    }

    /**
     * Recalcula un cupón que ya está asociado al carrito.
     * Se utiliza al volver a cargar el checkout o cambiar productos.
     */
    public function calcularCupon(
        Cupon $cupon,
        User $usuario,
        Collection $lineas
    ): array {
        $lineas = $this->normalizarLineas($lineas);

        $subtotalCarrito = round(
            (float) $lineas->sum('subtotal'),
            2
        );

        if ($lineas->isEmpty() || $subtotalCarrito <= 0) {
            return $this->respuestaInvalida(
                'Tu carrito no contiene artículos que puedan recibir un cupón.',
                $cupon,
                $subtotalCarrito
            );
        }

        if (!$cupon->estado) {
            return $this->respuestaInvalida(
                'Este cupón está desactivado.',
                $cupon,
                $subtotalCarrito
            );
        }

        $ahora = now();

        if (
            $cupon->fecha_inicio &&
            $ahora->lt($cupon->fecha_inicio)
        ) {
            return $this->respuestaInvalida(
                'Este cupón todavía no está vigente.',
                $cupon,
                $subtotalCarrito
            );
        }

        if (
            $cupon->fecha_fin &&
            $ahora->gt($cupon->fecha_fin)
        ) {
            return $this->respuestaInvalida(
                'Este cupón ya venció.',
                $cupon,
                $subtotalCarrito
            );
        }

        // Los usos se consumen al confirmar la compra,
        // no cuando el cliente simplemente aplica el cupón.
        $usos = CuponUso::query()
            ->where('cupon_id', $cupon->id)
            ->whereIn('estado', ['reservado', 'usado']);

        if (
            $cupon->max_usos_global !== null &&
            $usos->count() >= (int) $cupon->max_usos_global
        ) {
            return $this->respuestaInvalida(
                'Este cupón alcanzó su límite de usos.',
                $cupon,
                $subtotalCarrito
            );
        }

        if ($cupon->max_usos_por_usuario !== null) {
            $usosUsuario = CuponUso::query()
                ->where('cupon_id', $cupon->id)
                ->where('user_id', $usuario->id)
                ->whereIn('estado', ['reservado', 'usado'])
                ->count();

            if (
                $usosUsuario >= (int) $cupon->max_usos_por_usuario
            ) {
                return $this->respuestaInvalida(
                    'Ya alcanzaste el límite de usos de este cupón.',
                    $cupon,
                    $subtotalCarrito
                );
            }
        }

        $objetivos = $cupon->objetivos()->get();

        // Solo sumamos las líneas a las que corresponde el cupón.
        $lineasElegibles = $lineas->filter(
            fn (array $linea) => $this->lineaEsElegible(
                $cupon,
                $linea['modelo'],
                $objetivos
            )
        )->values();

        $subtotalElegible = round(
            (float) $lineasElegibles->sum('subtotal'),
            2
        );

        if ($subtotalElegible <= 0) {
            return $this->respuestaInvalida(
                'Este cupón no aplica a los artículos de tu carrito.',
                $cupon,
                $subtotalCarrito
            );
        }

        // La compra mínima se comprueba sobre el subtotal elegible,
        // después de los descuentos automáticos y antes del cupón.
        if (
            $cupon->monto_minimo_compra !== null &&
            $subtotalElegible < (float) $cupon->monto_minimo_compra
        ) {
            $faltante = round(
                (float) $cupon->monto_minimo_compra - $subtotalElegible,
                2
            );

            return $this->respuestaInvalida(
                'Necesitas agregar $' .
                number_format($faltante, 2) .
                ' más en artículos elegibles para usar este cupón.',
                $cupon,
                $subtotalCarrito,
                $subtotalElegible
            );
        }

        // Calculamos el descuento sin permitir un importe negativo.
        if ($cupon->tipo === 'porcentaje') {
            $porcentaje = min(
                100,
                max(0, (float) $cupon->valor)
            );

            $descuento = round(
                $subtotalElegible * ($porcentaje / 100),
                2
            );
        } elseif ($cupon->tipo === 'importe_fijo') {
            $descuento = min(
                $subtotalElegible,
                max(0, (float) $cupon->valor)
            );
        } else {
            return $this->respuestaInvalida(
                'El tipo de cupón no es válido.',
                $cupon,
                $subtotalCarrito,
                $subtotalElegible
            );
        }

        $descuento = min($subtotalElegible, max(0, $descuento));
        $descuento = round($descuento, 2);

        return [
            'valido' => true,
            'aplicado' => true,
            'mensaje' => 'Cupón aplicado correctamente.',
            'cupon' => $cupon,
            'codigo' => $cupon->codigo,
            'subtotal_carrito' => $subtotalCarrito,
            'subtotal_elegible' => $subtotalElegible,
            'descuento' => $descuento,
            'subtotal_final' => max(
                0,
                round($subtotalCarrito - $descuento, 2)
            ),
        ];
    }

    /**
     * Convierte las líneas a una estructura uniforme para el cálculo.
     */
    private function normalizarLineas(Collection $lineas): Collection
    {
        return $lineas->map(function ($linea) {
            $modelo = data_get($linea, 'modelo')
                ?? data_get($linea, 'comprable')
                ?? data_get($linea, 'variante');

            $cantidad = (int) data_get($linea, 'cantidad', 0);

            $precioUnitario = (float) (
                data_get($linea, 'precio_unitario')
                ?? data_get($linea, 'precio_final')
                ?? data_get($linea, 'precio', 0)
            );

            if (
                !($modelo instanceof Model) ||
                $cantidad <= 0 ||
                $precioUnitario < 0
            ) {
                return null;
            }

            $precioUnitario = round($precioUnitario, 2);

            return [
                'modelo' => $modelo,
                'cantidad' => $cantidad,
                'precio_unitario' => $precioUnitario,
                'subtotal' => round($precioUnitario * $cantidad, 2),
            ];
        })->filter()->values();
    }

    private function totalLineas(Collection $lineas): float
    {
        return round(
            (float) $this->normalizarLineas($lineas)->sum('subtotal'),
            2
        );
    }

    /**
     * Determina si una línea entra en el alcance del cupón.
     */
    private function lineaEsElegible(
        Cupon $cupon,
        Model $modelo,
        Collection $objetivos
    ): bool {
        if ($cupon->alcance === 'tienda') {
            return true;
        }

        foreach ($objetivos as $objetivo) {
            if (
                $cupon->alcance === 'articulo' &&
                $objetivo->tipo_objetivo === 'articulo' &&
                $this->coincideArticulo($modelo, $objetivo)
            ) {
                return true;
            }

            if (
                $cupon->alcance === 'categoria' &&
                $objetivo->tipo_objetivo === 'categoria' &&
                $this->coincideCategoria($modelo, $objetivo)
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Permite que un cupón para un Producto también coincida
     * cuando la línea del carrito es una ProductoVariante.
     */
    private function coincideArticulo(
        Model $modelo,
        CuponObjetivo $objetivo
    ): bool {
        foreach ($this->modelosRelacionados($modelo) as $relacionado) {
            if (
                $relacionado::class === $objetivo->objetivo_type &&
                (int) $relacionado->getKey() === (int) $objetivo->objetivo_id
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Comprueba la categoría del artículo o de su modelo relacionado.
     */
    private function coincideCategoria(
        Model $modelo,
        CuponObjetivo $objetivo
    ): bool {
        foreach ($this->modelosRelacionados($modelo) as $relacionado) {
            // Relación categoría, si el modelo la tiene.
            if (method_exists($relacionado, 'categoria')) {
                $categoria = $relacionado->categoria;

                if (
                    $categoria instanceof Model &&
                    $categoria::class === $objetivo->objetivo_type &&
                    (int) $categoria->getKey() === (int) $objetivo->objetivo_id
                ) {
                    return true;
                }
            }

            // Compatibilidad con modelos que guardan categoria_id.
            if (
                $objetivo->objetivo_type === Categoria::class &&
                (int) $relacionado->getAttribute('categoria_id') ===
                    (int) $objetivo->objetivo_id
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Obtiene el artículo principal de la línea y relaciones conocidas.
     * Podemos ampliar esta lista al implementar cursos o descargas.
     */
    private function modelosRelacionados(Model $modelo): Collection
    {
        $modelos = collect([$modelo]);

        foreach (['producto', 'recurso', 'recursoDescargable', 'curso'] as $relacion) {
            if (!method_exists($modelo, $relacion)) {
                continue;
            }

            $relacionado = $modelo->{$relacion};

            if ($relacionado instanceof Model) {
                $modelos->push($relacionado);
            }
        }

        return $modelos->unique(
            fn (Model $item) => $item::class . ':' . $item->getKey()
        )->values();
    }

    private function respuestaInvalida(
        string $mensaje,
        ?Cupon $cupon = null,
        float $subtotalCarrito = 0,
        float $subtotalElegible = 0
    ): array {
        $subtotalCarrito = round($subtotalCarrito, 2);

        return [
            'valido' => false,
            'aplicado' => false,
            'mensaje' => $mensaje,
            'cupon' => $cupon,
            'codigo' => $cupon?->codigo,
            'subtotal_carrito' => $subtotalCarrito,
            'subtotal_elegible' => round($subtotalElegible, 2),
            'descuento' => 0.0,
            'subtotal_final' => $subtotalCarrito,
        ];
    }
}