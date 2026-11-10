<?php

namespace App\Livewire\Admin\Descuentos;

use App\Models\Categoria;
use App\Models\Descuento;
use App\Models\Producto;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Formulario extends Component
{
    public ?Descuento $descuento = null;

    public string $nombre = '';

    public ?string $descripcion = null;

    public string $tipo = 'porcentaje';

    public string $valor = '';

    public string $alcance = 'tienda';

    public ?string $fecha_inicio = null;

    public string $fecha_fin = '';

    public bool $estado = true;

    public array $categoriasSeleccionadas = [];

    public array $productosSeleccionados = [];

    public string $busquedaCategoria = '';

    public string $busquedaProducto = '';

    public function mount(?Descuento $descuento = null): void
    {
        if (! $descuento) {
            return;
        }

        $this->descuento = $descuento;

        $this->nombre = $descuento->nombre;
        $this->descripcion = $descuento->descripcion;
        $this->tipo = $descuento->tipo;
        $this->valor = (string) $descuento->valor;
        $this->alcance = $descuento->alcance;
        $this->fecha_inicio = $descuento->fecha_inicio?->format('Y-m-d\TH:i');
        $this->fecha_fin = $descuento->fecha_fin?->format('Y-m-d\TH:i') ?? '';
        $this->estado = $descuento->estado;

        $this->categoriasSeleccionadas = $descuento
            ->categorias()
            ->pluck('categorias.id')
            ->map(fn ($id) => (string) $id)
            ->all();

        $this->productosSeleccionados = $descuento
            ->productos()
            ->pluck('productos.id')
            ->map(fn ($id) => (string) $id)
            ->all();
    }

    public function updatedAlcance(): void
    {
        // Evita conservar productos o categorías de un alcance anterior.
        $this->categoriasSeleccionadas = [];
        $this->productosSeleccionados = [];

        $this->resetValidation([
            'categoriasSeleccionadas',
            'productosSeleccionados',
        ]);
    }

    public function guardar()
    {
        $reglasValor = [
            'required',
            'numeric',
            'gt:0',
        ];

        if ($this->tipo === 'porcentaje') {
            $reglasValor[] = 'lte:100';
        }

        $reglasFechaFin = [
            'required',
            'date',
        ];

        if ($this->fecha_inicio) {
            $reglasFechaFin[] = 'after:fecha_inicio';
        }

        $reglas = [
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => [
                'required',
                'in:porcentaje,importe_fijo,precio_fijo',
            ],
            'valor' => $reglasValor,
            'alcance' => ['required', 'in:tienda,categoria,producto'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => $reglasFechaFin,
            'estado' => ['required', 'boolean'],

            'categoriasSeleccionadas' => ['array'],
            'categoriasSeleccionadas.*' => [
                'integer',
                'exists:categorias,id',
            ],

            'productosSeleccionados' => ['array'],
            'productosSeleccionados.*' => [
                'integer',
                'exists:productos,id',
            ],
        ];

        if ($this->alcance === 'categoria') {
            $reglas['categoriasSeleccionadas'][] = 'min:1';
        }

        if ($this->alcance === 'producto') {
            $reglas['productosSeleccionados'][] = 'min:1';
        }

        $mensajes = [
            'nombre.required' => 'El nombre del descuento es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 150 caracteres.',
            'tipo.required' => 'Selecciona un tipo de descuento.',
            'tipo.in' => 'El tipo de descuento seleccionado no es válido.',
            'valor.required' => 'Ingresa el valor del descuento.',
            'valor.numeric' => 'El valor debe ser numérico.',
            'valor.gt' => 'El valor debe ser mayor que cero.',
            'valor.lte' => 'El porcentaje no puede superar el 100%.',
            'alcance.required' => 'Selecciona dónde se aplicará el descuento.',
            'fecha_fin.required' => 'La fecha de finalización es obligatoria.',
            'fecha_fin.after' => 'La fecha de finalización debe ser posterior a la de inicio.',
            'categoriasSeleccionadas.min' => 'Selecciona al menos una categoría.',
            'productosSeleccionados.min' => 'Selecciona al menos un producto.',
        ];

        $datos = $this->validate($reglas, $mensajes);

        $categorias = $this->alcance === 'categoria'
            ? $this->categoriasSeleccionadas
            : [];

        $productos = $this->alcance === 'producto'
            ? $this->productosSeleccionados
            : [];

        unset(
            $datos['categoriasSeleccionadas'],
            $datos['productosSeleccionados']
        );

        // Un campo de fecha opcional debe guardarse como null si está vacío.
        $datos['fecha_inicio'] = $this->fecha_inicio ?: null;

        $esEdicion = $this->descuento !== null;

        DB::transaction(function () use ($datos, $categorias, $productos) {
            $descuento = $this->descuento ?? new Descuento();

            $descuento->fill($datos);
            $descuento->save();

            // Solo se guardan relaciones correspondientes al alcance elegido.
            $descuento->categorias()->sync($categorias);
            $descuento->productos()->sync($productos);
        });

        Flux::toast(
            heading: 'Descuentos',
            text: $esEdicion
                ? 'Descuento actualizado correctamente.'
                : 'Descuento creado correctamente.',
            variant: 'success'
        );

        $this->redirectRoute('descuento.index', navigate: true);
    }

    public function render(): View
    {
        $categorias = Categoria::query()
            ->when(
                trim($this->busquedaCategoria) !== '',
                function ($query) {
                    $termino = mb_strtolower(trim($this->busquedaCategoria));

                    $query->whereRaw(
                        'LOWER(nombre) LIKE ?',
                        ['%' . $termino . '%']
                    );
                }
            )
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        $productos = Producto::query()
            ->where('estado', true)
            ->when(
                trim($this->busquedaProducto) !== '',
                function ($query) {
                    $termino = mb_strtolower(trim($this->busquedaProducto));

                    $query->whereRaw(
                        'LOWER(nombre) LIKE ?',
                        ['%' . $termino . '%']
                    );
                }
            )
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return view('livewire.admin.descuentos.formulario', [
            'categorias' => $categorias,
            'productos' => $productos,
        ])->extends('components.layouts.admin')->section('contenido');
    }
}