<?php

namespace App\Livewire\Admin\Ordenes;

use App\Models\Orden;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $busqueda = '';

    public string $estado = 'todos';

    public string $estadoPago = 'todos';

    public int $porPagina = 15;

    public function updatingBusqueda(): void
    {
        $this->resetPage();
    }

    public function updatingEstado(): void
    {
        $this->resetPage();
    }

    public function updatingEstadoPago(): void
    {
        $this->resetPage();
    }

    public function updatingPorPagina(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $estadosPermitidos = [
            'pendiente',
            'procesando',
            'en_preparacion',
            'enviado',
            'entregado',
            'completado',
            'cancelado',
            'listo_para_recoger',
        ];

        $pagosPermitidos = [
            'pendiente',
            'pagado',
            'cancelado',
        ];

        $pedidos = Orden::query()
            ->with('usuario')
            ->withCount('items')

            ->when(
                trim($this->busqueda) !== '',
                function ($query) {
                    $termino = mb_strtolower(trim($this->busqueda));

                    $query->where(function ($subquery) use ($termino) {
                        $subquery
                            ->whereRaw(
                                'LOWER(numero) LIKE ?',
                                ['%' . $termino . '%']
                            )
                            ->orWhereHas('usuario', function ($usuario) use ($termino) {
                                $usuario
                                    ->whereRaw(
                                        'LOWER(nombre_completo) LIKE ?',
                                        ['%' . $termino . '%']
                                    )
                                    ->orWhereRaw(
                                        'LOWER(email) LIKE ?',
                                        ['%' . $termino . '%']
                                    );
                            });
                    });
                }
            )

            ->when(
                in_array($this->estado, $estadosPermitidos, true),
                fn ($query) => $query->where(
                    'estado',
                    $this->estado
                )
            )

            ->when(
                in_array($this->estadoPago, $pagosPermitidos, true),
                fn ($query) => $query->where(
                    'estado_pago',
                    $this->estadoPago
                )
            )

            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($this->porPagina);

        return view('livewire.admin.ordenes.index', [
            'pedidos' => $pedidos,
        ])
            ->extends('components.layouts.admin')
            ->section('contenido');
    }
}