<?php

namespace App\Livewire\Shop;

use App\Models\Producto;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListaDeseosButton extends Component
{
    public Producto $producto;

    public bool $enLista = false;

    public bool $mostrarTexto = false;

    public function mount(Producto $producto, bool $mostrarTexto = false)
    {
        $this->producto = $producto;

        $this->mostrarTexto = $mostrarTexto;

        $this->comprobarLista();
    }

    public function comprobarLista()
    {
        if (!Auth::check()) {
            $this->enLista = false;

            return;
        }

        $this->enLista = Auth::user()
            ->listaDeseos()
            ->where('producto_id', $this->producto->id)
            ->exists();

            // Avisar a otros componentes Livewire
            $this->dispatch(
                'lista-deseos-actualizada',
                productoId: $this->producto->id
            );
    }
    
    public function toggle()
    {
        if (!Auth::check()) {

            $urlAnterior = request()->header('Referer');

            if ($urlAnterior) {
                session()->put('url.intended', $urlAnterior);
            } else {
                session()->put(
                    'url.intended',
                    route('tienda.index')
                );
            }

            $this->redirectRoute(
                'login',
                navigate: true
            );

            return;
        }

        $usuario = Auth::user();

        if ($this->enLista) {

        $usuario->listaDeseos()
            ->detach($this->producto->id);

        $this->enLista = false;

        Flux::toast(
            heading: 'Lista de deseos',
            text: 'Producto eliminado de tu lista de deseos.',
            variant: 'success'
        );

        $cantidadLista = $usuario
            ->listaDeseos()
            ->count();

        $this->dispatch(
            'lista-deseos-contador',
            cantidad: $cantidadLista
        );

        $this->dispatch(
            'lista-deseos-actualizada',
            productoId: $this->producto->id
        );

        return;
    }

        $usuario->listaDeseos()
        ->syncWithoutDetaching([
            $this->producto->id,
        ]);

        $this->enLista = true;

        Flux::toast(
            heading: 'Lista de deseos',
            text: 'Producto agregado a tu lista de deseos.',
            variant: 'success',
            link: [
                'text' => 'Ver lista',
                'href' => route('lista-deseos.index'),
                'navigate' => true,
            ],
        );

        $cantidadLista = $usuario
            ->listaDeseos()
            ->count();

        $this->dispatch(
            'lista-deseos-contador',
            cantidad: $cantidadLista
        );

        $this->dispatch(
            'lista-deseos-actualizada',
            productoId: $this->producto->id
        );
    }
    
    public function render()
    {
        return view('livewire.shop.lista-deseos-button');
    }
}