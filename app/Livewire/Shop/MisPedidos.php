<?php

namespace App\Livewire\Shop;

use App\Models\Orden;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class MisPedidos extends Component
{
    use WithPagination;

    public string $busqueda = '';

    public string $estado = 'todos';

    
    /**
     * Reiniciar la paginación al buscar.
     */
    public function updatingBusqueda(): void
    {
        $this->resetPage();
    }

    /**
     * Reiniciar la paginación al cambiar el filtro.
     */
    public function updatingEstado(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $usuario = auth()->user();

        $estadosPermitidos = [
            'pendiente',
            'cancelado',
            'procesando',
            'en_preparacion',
            'enviado',
            'entregado',
            'completado',
            'listo_para_recoger',
        ];

        $pedidos = Orden::query()
            ->where('user_id', $usuario->id)
            ->withCount('items')
            ->when(
                trim($this->busqueda) !== '',
                function ($query) {
                    $termino = mb_strtolower(trim($this->busqueda));

                    $query->whereRaw(
                        'LOWER(numero) LIKE ?',
                        ['%' . $termino . '%']
                    );
                }
            )
            ->when(
                in_array($this->estado, $estadosPermitidos, true),
                fn ($query) => $query->where('estado', $this->estado)
            )
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.shop.mis-pedidos', [
            'pedidos' => $pedidos,
        ]);
    }
}