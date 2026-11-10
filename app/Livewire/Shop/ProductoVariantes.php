<?php

namespace App\Livewire\Shop;

use App\Models\Producto;
use Livewire\Component;
use Flux\Flux;
use Livewire\Attributes\On;
use App\Services\Shop\CalculadoraPrecios;
use App\Services\Shop\CarritoService;
use Illuminate\Support\Facades\Auth;

class ProductoVariantes extends Component
{
    public Producto $producto;

    public array $seleccionados = [];

    public $varianteSeleccionada = null;

    public function mount(Producto $producto)
    {
        $this->producto = $producto;

        $this->producto->load([
            'atributos',
            'variantes.valores.attribute',
        ]);
    }

    public function seleccionar($atributoId, $valorId)
    {
        $this->seleccionados[$atributoId] = $valorId;

        $this->buscarVariante();
    }

    public function buscarVariante(): void
    {
        $this->varianteSeleccionada = null;

        $cantidadAtributos = $this->producto->atributos->count();

        // Si aún faltan atributos, restablecemos los datos mostrados.
        if (count($this->seleccionados) !== $cantidadAtributos) {
            $this->restablecerDatosVariante();

            return;
        }

        foreach ($this->producto->variantes->where('estado', true) as $variante) {
            $valores = $variante->valores;

            $coincide = true;

            foreach ($this->seleccionados as $valorId) {
                if (! $valores->contains('id', $valorId)) {
                    $coincide = false;
                    break;
                }
            }

            if (
                $coincide &&
                $valores->count() === count($this->seleccionados)
            ) {
                $this->varianteSeleccionada = $variante;

                $resultado = app(CalculadoraPrecios::class)->calcular(
                    $this->producto,
                    $variante
                );

                $this->dispatch(
                    'variante-actualizada',
                    precio: $resultado['precio_final'],
                    precio_original: $resultado['precio_original'],
                    ahorro: $resultado['ahorro'],
                    porcentaje_ahorro: $resultado['porcentaje_ahorro'],
                    aplicado: $resultado['aplicado'],
                    sku: $variante->sku,
                    stock: $variante->stock
                );

                return;
            }
        }

        // No existe una variante que corresponda con la selección.
        $this->restablecerDatosVariante();
    }

    private function restablecerDatosVariante(): void
    {
        $this->dispatch(
            'variante-actualizada',
            precio: null,
            precio_original: null,
            ahorro: null,
            porcentaje_ahorro: null,
            aplicado: false,
            sku: null,
            stock: null
        );
    }

    #[On('agregar-al-carrito')]
    public function agregarAlCarrito($cantidad = 1)
    {
        // El usuario debe iniciar sesión antes de agregar productos.
        if (! Auth::check()) {
            session()->put(
                'url.intended',
                route('tienda.show', $this->producto)
            );

            $this->redirectRoute('login', navigate: true);

            return;
        }
        
        $cantidad = max(1, (int) $cantidad);

        // Si el producto tiene atributos, es obligatorio
        // seleccionar una variante.
        if ($this->producto->atributos->isNotEmpty() && !$this->varianteSeleccionada) {

            Flux::toast(
                heading: 'Selecciona una opción',
                text: 'Debes seleccionar las opciones que correspondan del producto antes de agregarlo al carrito.',
                variant: 'warning',
                duration: 3500,
            );

            return;
        }

        /*
        * Si el producto no tiene atributos y tiene una sola
        * variante activa, podemos utilizarla directamente.
        */
        if (!$this->varianteSeleccionada) {

            $variantesActivas = $this->producto
                ->variantes
                ->where('estado', true)
                ->values();

            if ($variantesActivas->count() === 1) {
                $this->varianteSeleccionada = $variantesActivas->first();
            }
        }

        if (!$this->varianteSeleccionada) {

            Flux::toast(
                heading: 'Producto no disponible',
                text: 'No se encontró una variante disponible para este producto.',
                variant: 'warning',
                duration: 3500,
            );

            return;
        }

        if (!$this->varianteSeleccionada->estado) {

            Flux::toast(
                heading: 'Variante no disponible',
                text: 'Esta variante ya no está disponible.',
                variant: 'danger',
                duration: 3500,
            );

            return;
        }

        if ($this->varianteSeleccionada->stock <= 0) {

            Flux::toast(
                heading: 'Producto agotado',
                text: 'La variante seleccionada no tiene existencias.',
                variant: 'danger',
                duration: 3500,
            );

            return;
        }

        if ($cantidad > $this->varianteSeleccionada->stock) {

            Flux::toast(
                heading: 'Stock insuficiente',
                text: 'No hay suficiente stock para la cantidad seleccionada.',
                variant: 'warning',
                duration: 3500,
            );

            return;
        }

        /*
        * Carrito temporal por sesión.
        */
        $servicioCarrito = app(CarritoService::class);

        $resultado = $servicioCarrito->agregarVariante(
            Auth::user(),
            (int) $this->varianteSeleccionada->id,
            $cantidad
        );
        
        if ($resultado === 'stock') {
            Flux::toast(
                heading: 'Stock insuficiente',
                text: 'No hay suficientes existencias para la cantidad solicitada.',
                variant: 'warning',
                duration: 3500,
            );
        
            return;
        }
        
        if ($resultado === 'no_disponible') {
            Flux::toast(
                heading: 'Producto no disponible',
                text: 'Esta variante o el producto ya no está disponible.',
                variant: 'warning',
                duration: 3500,
            );
        
            return;
        }
        
        $cantidadTotal = $servicioCarrito->cantidadTotal(Auth::user());
        
        $this->dispatch(
            'carrito-actualizado',
            cantidad: $cantidadTotal
        );
        
        Flux::toast(
            heading: '¡Agregado al carrito!',
            text: 'El producto se agregó correctamente.',
            variant: 'success',
            duration: 2500,
        );
    }
    
    public function render()
    {
        return view('livewire.shop.producto-variantes');
    }
}