<?php

namespace App\Livewire\Admin\Envios;

use App\Models\ZonaEnvio;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ZonasIndex extends Component
{
    use WithPagination;

    public string $busqueda = '';

    public string $filtroEstado = 'todas';

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
        $zona = ZonaEnvio::findOrFail($id);

        $zona->update([
            'activa' => ! $zona->activa,
        ]);

        Flux::toast(
            heading: 'Zonas de envío',
            text: $zona->activa
                ? 'Zona activada correctamente.'
                : 'Zona desactivada correctamente.',
            variant: 'success',
        );
    }

    public function eliminar(int $id): void
    {
        $zona = ZonaEnvio::findOrFail($id);

        $nombre = $zona->nombre;

        $zona->delete();

        Flux::toast(
            heading: 'Zonas de envío',
            text: "La zona {$nombre} fue eliminada correctamente.",
            variant: 'success',
        );
    }

    public function render(): View
    {
        $zonas = ZonaEnvio::query()
            ->withCount('codigosPostales')
            ->when(
                trim($this->busqueda) !== '',
                function ($query) {
                    $termino = mb_strtolower(trim($this->busqueda));

                    $query->where(function ($subquery) use ($termino) {
                        $subquery
                            ->whereRaw(
                                'LOWER(nombre) LIKE ?',
                                ["%{$termino}%"]
                            )
                            ->orWhereRaw(
                                'LOWER(COALESCE(descripcion, \'\')) LIKE ?',
                                ["%{$termino}%"]
                            );
                    });
                }
            )
            ->when(
                $this->filtroEstado === 'activas',
                fn ($query) => $query->where('activa', true)
            )
            ->when(
                $this->filtroEstado === 'inactivas',
                fn ($query) => $query->where('activa', false)
            )
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.admin.envios.zonas-index', [
            'zonas' => $zonas,
        ])->extends('components.layouts.admin')->section('contenido');
    }
}