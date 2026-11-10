<?php

namespace App\Livewire\Admin\Envios;

use App\Models\ZonaEnvio;
use App\Models\ZonaEnvioCodigoPostal;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormularioZona extends Component
{
    public ?int $zonaId = null;

    public string $nombre = '';

    public ?string $descripcion = null;

    public string $tarifa = '0.00';

    public ?string $monto_minimo_envio_gratis = null;

    public bool $activa = true;

    public string $codigosPostales = '';

    public function mount(?int $zona = null): void
    {
        if ($zona === null) {
            return;
        }

        $registro = ZonaEnvio::with('codigosPostales')
            ->findOrFail($zona);

        $this->zonaId = $registro->id;
        $this->nombre = $registro->nombre;
        $this->descripcion = $registro->descripcion;
        $this->tarifa = (string) $registro->tarifa;

        $this->monto_minimo_envio_gratis =
            $registro->monto_minimo_envio_gratis !== null
                ? (string) $registro->monto_minimo_envio_gratis
                : null;

        $this->activa = $registro->activa;

        $this->codigosPostales = $registro->codigosPostales
            ->pluck('codigo_postal')
            ->implode("\n");
    }

    public function guardar()
    {
        $datos = $this->validate([
            'nombre' => ['required', 'string', 'max:120'],

            'descripcion' => ['nullable', 'string'],

            'tarifa' => ['required', 'numeric', 'min:0'],

            'monto_minimo_envio_gratis' => [
                'nullable',
                'numeric',
                'gt:0',
            ],

            'activa' => ['required', 'boolean'],

            'codigosPostales' => ['required', 'string'],
        ], [
            'nombre.required' => 'El nombre de la zona es obligatorio.',
            'nombre.max' => 'El nombre no puede superar 120 caracteres.',
            'tarifa.required' => 'Ingresa la tarifa de envío.',
            'tarifa.numeric' => 'La tarifa debe ser numérica.',
            'tarifa.min' => 'La tarifa no puede ser negativa.',
            'monto_minimo_envio_gratis.numeric' =>
                'El monto mínimo debe ser numérico.',
            'monto_minimo_envio_gratis.gt' =>
                'El monto mínimo debe ser mayor que cero.',
            'codigosPostales.required' =>
                'Ingresa al menos un código postal.',
        ]);

        /*
        * Aceptar códigos postales separados por comas,
        * espacios o saltos de línea.
        */
        $codigos = collect(
            preg_split('/[\s,;]+/', trim($this->codigosPostales)) ?: []
        )
            ->map(fn ($codigo) => trim($codigo))
            ->filter(fn ($codigo) => $codigo !== '')
            ->values();

        if ($codigos->isEmpty()) {
            $this->addError(
                'codigosPostales',
                'Ingresa al menos un código postal.'
            );

            return;
        }

        $invalidos = $codigos->filter(
            fn ($codigo) => ! preg_match('/^\d{5}$/', $codigo)
        );

        if ($invalidos->isNotEmpty()) {
            $this->addError(
                'codigosPostales',
                'Estos códigos no tienen cinco dígitos: '
                . $invalidos->unique()->implode(', ')
            );

            return;
        }

        $duplicados = $codigos->duplicates()->unique();

        if ($duplicados->isNotEmpty()) {
            $this->addError(
                'codigosPostales',
                'Repetiste estos códigos en la lista: '
                . $duplicados->implode(', ')
            );

            return;
        }

        /*
        * Impedir que un código postal pertenezca a dos zonas.
        * Al editar, se excluyen los códigos de la propia zona.
        */
        $consulta = ZonaEnvioCodigoPostal::query()
            ->whereIn('codigo_postal', $codigos->all());

        if ($this->zonaId !== null) {
            $consulta->where('zona_envio_id', '!=', $this->zonaId);
        }

        $yaAsignados = $consulta
            ->pluck('codigo_postal')
            ->unique()
            ->values();

        if ($yaAsignados->isNotEmpty()) {
            $this->addError(
                'codigosPostales',
                'Estos códigos ya pertenecen a otra zona: '
                . $yaAsignados->implode(', ')
            );

            return;
        }

        $datos['monto_minimo_envio_gratis'] =
            $this->monto_minimo_envio_gratis === ''
                ? null
                : $this->monto_minimo_envio_gratis;

        $esEdicion = $this->zonaId !== null;

        DB::transaction(function () use ($datos, $codigos) {
            $zona = $this->zonaId !== null
                ? ZonaEnvio::findOrFail($this->zonaId)
                : new ZonaEnvio();

            $zona->fill([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'tarifa' => $datos['tarifa'],
                'monto_minimo_envio_gratis' =>
                    $datos['monto_minimo_envio_gratis'],
                'activa' => $datos['activa'],
            ]);

            $zona->save();

            // Sustituir la cobertura por la lista actualizada.
            $zona->codigosPostales()->delete();

            $zona->codigosPostales()->createMany(
                $codigos->map(fn ($codigo) => [
                    'codigo_postal' => $codigo,
                ])->all()
            );
        });

        Flux::toast(
            heading: 'Zonas de envío',
            text: $esEdicion
                ? 'Zona actualizada correctamente.'
                : 'Zona creada correctamente.',
            variant: 'success',
        );

        $this->redirectRoute(
            'zona-envio.index',
            navigate: true
        );
    }

    public function cancelar()
    {
        $this->redirectRoute(
            'zona-envio.index',
            navigate: true
        );
    }

    public function render(): View
    {
        return view('livewire.admin.envios.formulario-zona')
            ->extends('components.layouts.admin')
            ->section('contenido');
    }
    }