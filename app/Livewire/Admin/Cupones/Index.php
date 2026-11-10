<?php

namespace App\Livewire\Admin\Cupones;

use App\Models\Cupon;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $busqueda = '';

    public string $filtroEstado = 'todos';

    public function updatingBusqueda(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroEstado(): void
    {
        $this->resetPage();
    }

    public function cambiarEstado(int $id): void
    {
        $cupon = Cupon::findOrFail($id);

        $cupon->update([
            'estado' => ! $cupon->estado,
        ]);

        Flux::toast(
            heading: 'Cupones',
            text: $cupon->estado
                ? 'Cupón activado correctamente.'
                : 'Cupón desactivado correctamente.',
            variant: 'success',
        );
    }

    public function eliminar(int $id): void
    {
        $cupon = Cupon::findOrFail($id);

        /*
        * Conservamos los cupones que tengan usos registrados
        * para no eliminar su historial de compras.
        */
        if ($cupon->usos()->exists()) {
            Flux::toast(
                heading: 'No se puede eliminar',
                text: 'Este cupón tiene usos registrados. Desactívalo si ya no deseas permitir su aplicación.',
                variant: 'warning',
            );

            return;
        }

        $cupon->delete();

        Flux::toast(
            heading: 'Cupones',
            text: 'Cupón eliminado correctamente.',
            variant: 'success',
        );
    }

    public function render(): View
    {
        $cupones = Cupon::query()
            ->withCount(['objetivos', 'usos'])
            ->when(
                trim($this->busqueda) !== '',
                function ($query) {
                    $termino = mb_strtoupper(trim($this->busqueda));

                    $query->where(function ($subquery) use ($termino) {
                        $subquery
                            ->whereRaw(
                                'LOWER(nombre) LIKE ?',
                                ['%' . mb_strtolower($termino) . '%']
                            )
                            ->orWhereRaw(
                                'LOWER(codigo) LIKE ?',
                                ['%' . mb_strtolower($termino) . '%']
                            );
                    });
                }
            )
            ->when(
                $this->filtroEstado === 'activos',
                fn ($query) => $query->where('estado', true)
            )
            ->when(
                $this->filtroEstado === 'inactivos',
                fn ($query) => $query->where('estado', false)
            )
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.admin.cupones.index', [
            'cupones' => $cupones,
        ])->extends('components.layouts.admin')->section('contenido');
    }
}