<?php

namespace App\Livewire\Shop;

use App\Models\CarritoItem;
use App\Models\ProductoVariante;
use App\Services\Shop\CalculadoraPrecios;
use App\Services\Shop\CarritoService;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Carrito extends Component
{

    public function mount(): void
    {
        if (! Auth::check()) {
            session()->put('url.intended', route('carrito.index'));

            $this->redirectRoute('login', navigate: true);

            return;
        }

        $servicio = app(CarritoService::class);

        $servicio->sincronizarSesion(Auth::user());

        $this->dispatch(
            'carrito-actualizado',
            cantidad: $servicio->cantidadTotal(Auth::user())
        );
    }

    public function incrementar(int $varianteId): void
    {
        $resultado = app(CarritoService::class)->cambiarCantidad(
            Auth::user(),
            $varianteId,
            1
        );

        if ($resultado === 'stock') {
            Flux::toast(
                heading: 'Stock insuficiente',
                text: 'No hay más existencias disponibles.',
                variant: 'warning',
            );

            return;
        }

        if ($resultado === 'no_disponible') {
            Flux::toast(
                heading: 'Producto no disponible',
                text: 'Esta variante ya no está disponible.',
                variant: 'warning',
            );

            return;
        }

        if ($resultado !== 'actualizado') {
            return;
        }

        $this->notificarCarrito();
    }

    public function disminuir(int $varianteId): void
    {
        $resultado = app(CarritoService::class)->cambiarCantidad(
            Auth::user(),
            $varianteId,
            -1
        );

        if ($resultado === 'minimo') {
            return;
        }

        if ($resultado !== 'actualizado') {
            return;
        }

        $this->notificarCarrito();
    }

    public function eliminar(int $varianteId): void
    {
        $eliminado = app(CarritoService::class)->eliminarVariante(
            Auth::user(),
            $varianteId
        );

        if (! $eliminado) {
            return;
        }

        $this->notificarCarrito();

        Flux::toast(
            heading: 'Carrito de compras',
            text: 'Producto eliminado del carrito.',
            variant: 'success',
        );
    }

    public function moverAListaDeseos(int $varianteId): void
    {
        $usuario = Auth::user();
        $servicio = app(CarritoService::class);

        if (! $servicio->contieneVariante($usuario, $varianteId)) {
            return;
        }

        $variante = ProductoVariante::with('producto')
            ->find($varianteId);

        if (! $variante || ! $variante->producto) {
            Flux::toast(
                heading: 'Producto no disponible',
                text: 'No se encontró el producto que deseas guardar.',
                variant: 'warning',
            );

            return;
        }

        // La lista de deseos está asociada al producto,
        // no a una variante específica.
        $usuario->listaDeseos()->syncWithoutDetaching([
            $variante->producto->id,
        ]);

        $servicio->eliminarVariante($usuario, $varianteId);

        $this->notificarCarrito();

        $this->dispatch(
            'lista-deseos-contador',
            cantidad: $usuario->listaDeseos()->count()
        );

        $this->dispatch(
            'lista-deseos-actualizada',
            productoId: $variante->producto->id
        );

        Flux::toast(
            heading: 'Lista de deseos',
            text: 'Producto movido a tu lista de deseos.',
            variant: 'success',
            link: [
                'text' => 'Ver lista',
                'href' => route('lista-deseos.index'),
                'navigate' => true,
            ],
        );
    }

    private function notificarCarrito(): void
    {
        $cantidadTotal = app(CarritoService::class)
            ->cantidadTotal(Auth::user());

        $this->dispatch(
            'carrito-actualizado',
            cantidad: $cantidadTotal
        );
    }

    public function render(): View
    {
        $items = collect();
        $totalOriginal = 0;
        $total = 0;
        $ahorroTotal = 0;
        $cantidadTotal = 0;

        if (Auth::check()) {
            $servicio = app(CarritoService::class);

            $servicio->sincronizarSesion(Auth::user());

            $carrito = $servicio->obtenerOCrear(Auth::user());

            $lineas = $carrito->items()
                ->where('comprable_type', ProductoVariante::class)
                ->with('comprable')
                ->get();

            // Cargar relaciones específicas de las variantes físicas.
            $lineas->loadMorph('comprable', [
                ProductoVariante::class => [
                    'producto.images',
                    'valores.attribute',
                ],
            ]);

            $calculadora = app(CalculadoraPrecios::class);

            foreach ($lineas as $linea) {
                $variante = $linea->comprable;

                // Retirar referencias que ya no existen.
                if (! $variante || ! $variante->producto) {
                    $linea->delete();

                    continue;
                }

                $producto = $variante->producto;
                $cantidad = (int) $linea->cantidad;

                $precio = $calculadora->calcular(
                    $producto,
                    $variante
                );

                $subtotalOriginal = round(
                    $precio['precio_original'] * $cantidad,
                    2
                );

                $subtotal = round(
                    $precio['precio_final'] * $cantidad,
                    2
                );

                $items->push([
                    'key' => (string) $variante->id,
                    'producto' => $producto,
                    'variante' => $variante,
                    'cantidad' => $cantidad,

                    'precio_original' => $precio['precio_original'],
                    'precio_final' => $precio['precio_final'],
                    'ahorro_unitario' => $precio['ahorro'],
                    'porcentaje_ahorro' => $precio['porcentaje_ahorro'],
                    'descuento_aplicado' => $precio['aplicado'],

                    'subtotal_original' => $subtotalOriginal,
                    'subtotal' => $subtotal,
                    'ahorro_total' => round(
                        $subtotalOriginal - $subtotal,
                        2
                    ),

                    'disponible' =>
                        (bool) $variante->estado
                        && (bool) $producto->estado
                        && $variante->stock >= $cantidad,
                ]);
            }

            $totalOriginal = round(
                $items->sum('subtotal_original'),
                2
            );

            $total = round(
                $items->sum('subtotal'),
                2
            );

            $ahorroTotal = round(
                $totalOriginal - $total,
                2
            );

            $cantidadTotal = $servicio->cantidadTotal(Auth::user());
        }

        return view('livewire.shop.carrito', [
            'items' => $items,
            'totalOriginal' => $totalOriginal,
            'total' => $total,
            'ahorroTotal' => $ahorroTotal,
            'cantidadTotal' => $cantidadTotal,
        ]);
    }
}