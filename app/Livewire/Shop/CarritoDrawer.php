<?php

namespace App\Livewire\Shop;

use App\Models\ProductoVariante;
use App\Services\Shop\CalculadoraPrecios;
use App\Services\Shop\CarritoService;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;


class CarritoDrawer extends Component
{
    public function mount(): void
    {
        if (! Auth::check()) {
            return;
        }

        $servicio = app(CarritoService::class);

        $servicio->sincronizarSesion(Auth::user());

        $this->dispatch(
            'carrito-actualizado',
            cantidad: $servicio->cantidadTotal(Auth::user())
        );
    }

    #[On('carrito-actualizado')]
    public function sincronizarCarrito(?int $cantidad = null): void
    {
        // Livewire volverá a renderizar el drawer al recibir el evento.
    }

    public function eliminar(int $varianteId): void
    {
            if (! Auth::check()) {
                return;
            }

            $servicio = app(CarritoService::class);

            $eliminado = $servicio->eliminarVariante(
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
        if (! Auth::check()) {
            session()->put('url.intended', route('carrito.index'));

            $this->redirectRoute('login', navigate: true);

            return;
        }

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

        $productoId = $variante->producto->id;

        $usuario->listaDeseos()->syncWithoutDetaching([
            $productoId,
        ]);

        $servicio->eliminarVariante($usuario, $varianteId);

        $this->notificarCarrito();

        $this->dispatch(
            'lista-deseos-contador',
            cantidad: $usuario->listaDeseos()->count()
        );

        $this->dispatch(
            'lista-deseos-actualizada',
            productoId: $productoId
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
        $total = 0;
        $ahorroTotal = 0;

        if (Auth::check()) {
            $servicio = app(CarritoService::class);

            $servicio->sincronizarSesion(Auth::user());

            $carrito = $servicio->obtenerOCrear(Auth::user());

            $lineas = $carrito->items()
                ->where('comprable_type', ProductoVariante::class)
                ->with('comprable')
                ->get();

            $lineas->loadMorph('comprable', [
                ProductoVariante::class => [
                    'producto.images',
                    'valores.attribute',
                ],
            ]);

            $calculadora = app(CalculadoraPrecios::class);

            foreach ($lineas as $linea) {
                $variante = $linea->comprable;

                if (! $variante || ! $variante->producto) {
                    $linea->delete();

                    continue;
                }

                $producto = $variante->producto;

                $precio = $calculadora->calcular(
                    $producto,
                    $variante
                );

                $cantidad = (int) $linea->cantidad;

                $imagen = $producto->images
                    ->firstWhere('principal', true)
                    ?? $producto->images->first();

                $items->push([
                    'key' => (string) $variante->id,
                    'producto' => $producto,
                    'variante' => $variante,
                    'imagen' => $imagen,
                    'cantidad' => $cantidad,

                    'precio_original' => $precio['precio_original'],
                    'precio_final' => $precio['precio_final'],
                    'ahorro_unitario' => $precio['ahorro'],
                    'porcentaje_ahorro' => $precio['porcentaje_ahorro'],
                    'descuento_aplicado' => $precio['aplicado'],

                    'subtotal' => round(
                        $precio['precio_final'] * $cantidad,
                        2
                    ),

                    'ahorro_total' => round(
                        $precio['ahorro'] * $cantidad,
                        2
                    ),

                    'disponible' =>
                        (bool) $variante->estado
                        && (bool) $producto->estado
                        && $variante->stock >= $cantidad,
                ]);
            }

            $total = round($items->sum('subtotal'), 2);
            $ahorroTotal = round($items->sum('ahorro_total'), 2);
        }

        return view('livewire.shop.carrito-drawer', [
            'items' => $items,
            'total' => $total,
            'ahorroTotal' => $ahorroTotal,
            'cantidadTotal' => $items->sum('cantidad'),
        ]);
    }
}