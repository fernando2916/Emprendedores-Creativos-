<?php

namespace App\Livewire\Admin\Pagos;

use App\Models\CheckoutIntento;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class IntentosIndex extends Component
{
use WithPagination;

public string $busqueda = '';

public string $estado = 'todos';

public string $metodoPago = 'todos';

public int $porPagina = 15;

public function updatingBusqueda(): void
{
    $this->resetPage();
}

public function updatingEstado(): void
{
    $this->resetPage();
}

public function updatingMetodoPago(): void
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
        'aprobado',
        'rechazado',
        'cancelado',
        'expirado',
    ];

    $metodosPermitidos = [
        'mercado_pago',
        'efectivo',
        'transferencia',
    ];

    $intentos = CheckoutIntento::query()
        ->with([
            'usuario:id,nombre_completo,email',
            'orden:id,numero,estado,estado_pago',
        ])
        ->when(
            trim($this->busqueda) !== '',
            function ($query) {
                $termino = trim($this->busqueda);

                $query->where(function ($subquery) use ($termino) {
                    $subquery
                        ->where('referencia_externa', 'like', "%{$termino}%")
                        ->orWhere('mercadopago_order_id', 'like', "%{$termino}%")
                        ->orWhereHas('usuario', function ($usuario) use ($termino) {
                            $usuario
                                ->where('nombre_completo', 'like', "%{$termino}%")
                                ->orWhere('email', 'like', "%{$termino}%");
                        })
                        ->orWhereHas('orden', function ($orden) use ($termino) {
                            $orden->where('numero', 'like', "%{$termino}%");
                        });
                });
            }
        )
        ->when(
            in_array($this->estado, $estadosPermitidos, true),
            fn ($query) => $query->where('estado', $this->estado)
        )
        ->when(
            in_array($this->metodoPago, $metodosPermitidos, true),
            fn ($query) => $query->where('metodo_pago', $this->metodoPago)
        )
        ->orderByDesc('created_at')
        ->orderByDesc('id')
        ->paginate($this->porPagina);

    $resumen = [
        'total' => CheckoutIntento::count(),

        'pendientes' => CheckoutIntento::where('estado', 'pendiente')->count(),

        'procesando' => CheckoutIntento::where('estado', 'procesando')->count(),

        'aprobados' => CheckoutIntento::where('estado', 'aprobado')->count(),

        'fallidos' => CheckoutIntento::whereIn(
            'estado',
            ['rechazado', 'cancelado', 'expirado']
        )->count(),
    ];

    return view('livewire.admin.pagos.intentos-index', [
        'intentos' => $intentos,
        'resumen' => $resumen,
    ])
        ->extends('components.layouts.admin')
        ->section('contenido');
}
}