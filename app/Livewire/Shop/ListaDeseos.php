<?php

namespace App\Livewire\Shop;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ListaDeseos extends Component
{
    use WithPagination;

    #[On('lista-deseos-actualizada')]
    public function actualizarLista()
    {
        $this->resetPage();
    }

    public function render()
    {
        $productos = Auth::user()
            ->listaDeseos()
            ->where('estado', true)
            ->with([
                'images',
                'categoria',
                'subCategoria',
                'tags',
                'variantes',
                'reseñas',
            ])
            ->orderByPivot('created_at', 'desc')
            ->paginate(9);

        return view(
            'livewire.shop.lista-deseos',
            [
                'productos' => $productos,
            ]
        );
    }
}