<?php

namespace App\Livewire\Admin\Descuentos;

use App\Models\Descuento;
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
        $descuento = Descuento::findOrFail($id);

        $descuento->update([
            'estado' => ! $descuento->estado,
        ]);

        Flux::toast(
            heading: 'Descuentos',
            text: $descuento->estado
                ? 'Descuento activado correctamente.'
                : 'Descuento desactivado correctamente.',
            variant: 'success'
        );
    }

    public function eliminar(int $id): void
    {
        $descuento = Descuento::findOrFail($id);

        $descuento->delete();

        Flux::toast(
            heading: 'Descuentos',
            text: 'Descuento eliminado correctamente.',
            variant: 'success'
        );
    }

    public function render(): View
    {
        $descuentos = Descuento::query()
            ->withCount(['categorias', 'productos'])
            ->when(
                trim($this->busqueda) !== '',
                function ($query) {
                    $termino = mb_strtolower(trim($this->busqueda));

                    $query->whereRaw(
                        'LOWER(nombre) LIKE ?',
                        ['%' . $termino . '%']
                    );
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

        return view('livewire.admin.descuentos.index', [
            'descuentos' => $descuentos,
        ])->extends('components.layouts.admin')->section('contenido');
    }
}