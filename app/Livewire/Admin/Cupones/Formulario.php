<?php

namespace App\Livewire\Admin\Cupones;

use App\Models\Categoria;
use App\Models\Cupon;
use App\Models\Producto;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Formulario extends Component
{
    public ?int $cuponId = null;

    public string $nombre = '';

    public string $codigo = '';

    public ?string $descripcion = null;

    public string $tipo = 'porcentaje';

    public string $valor = '';

    public string $alcance = 'tienda';

    public ?string $monto_minimo_compra = null;

    public ?string $max_usos_global = null;

    public ?string $max_usos_por_usuario = null;

    public ?string $fecha_inicio = null;

    public ?string $fecha_fin = null;

    public bool $estado = true;

    public array $categoriasSeleccionadas = [];

    public array $productosSeleccionados = [];

    public string $busquedaCategoria = '';

    public string $busquedaProducto = '';

    public function mount(?int $cupon = null): void
    {
        if ($cupon === null) {
            return;
        }

        $registro = Cupon::with('objetivos')->findOrFail($cupon);

        $this->cuponId = $registro->id;
        $this->nombre = $registro->nombre;
        $this->codigo = $registro->codigo;
        $this->descripcion = $registro->descripcion;
        $this->tipo = $registro->tipo;
        $this->valor = (string) $registro->valor;
        $this->alcance = $registro->alcance;

        $this->monto_minimo_compra =
            $registro->monto_minimo_compra !== null
                ? (string) $registro->monto_minimo_compra
                : null;

        $this->max_usos_global =
            $registro->max_usos_global !== null
                ? (string) $registro->max_usos_global
                : null;

        $this->max_usos_por_usuario =
            $registro->max_usos_por_usuario !== null
                ? (string) $registro->max_usos_por_usuario
                : null;

        $this->fecha_inicio = $registro->fecha_inicio?->format('Y-m-d\TH:i');
        $this->fecha_fin = $registro->fecha_fin?->format('Y-m-d\TH:i');
        $this->estado = $registro->estado;

        $this->categoriasSeleccionadas = $registro->objetivos
            ->where('tipo_objetivo', 'categoria')
            ->where('objetivo_type', Categoria::class)
            ->pluck('objetivo_id')
            ->map(fn ($id) => (string) $id)
            ->values()
            ->all();

        $this->productosSeleccionados = $registro->objetivos
            ->where('tipo_objetivo', 'articulo')
            ->where('objetivo_type', Producto::class)
            ->pluck('objetivo_id')
            ->map(fn ($id) => (string) $id)
            ->values()
            ->all();
    }

    public function updatedAlcance(): void
    {
        $this->categoriasSeleccionadas = [];
        $this->productosSeleccionados = [];

        $this->resetValidation([
            'categoriasSeleccionadas',
            'productosSeleccionados',
        ]);
    }

    public function guardar()
    {
        // Los códigos se normalizan antes de comprobar su unicidad.
        $this->codigo = mb_strtoupper(trim($this->codigo));

        $reglasValor = [
            'required',
            'numeric',
            'gt:0',
        ];

        if ($this->tipo === 'porcentaje') {
            $reglasValor[] = 'lte:100';
        }

        $reglasFechaFin = ['nullable', 'date'];

        if ($this->fecha_inicio) {
            $reglasFechaFin[] = 'after:fecha_inicio';
        }

        $reglas = [
            'nombre' => ['required', 'string', 'max:150'],

            'codigo' => [
                'required',
                'string',
                'max:60',
                'regex:/^[A-Z0-9_-]+$/',
                Rule::unique('cupones', 'codigo')->ignore($this->cuponId),
            ],

            'descripcion' => ['nullable', 'string'],

            'tipo' => [
                'required',
                'in:porcentaje,importe_fijo',
            ],

            'valor' => $reglasValor,

            'alcance' => [
                'required',
                'in:tienda,categoria,articulo',
            ],

            'monto_minimo_compra' => [
                'nullable',
                'numeric',
                'gte:0',
            ],

            'max_usos_global' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'max_usos_por_usuario' => [
                'nullable',
                'integer',
                'min:1',
            ],

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
                Rule::exists('productos', 'id')
                    ->where(fn (Builder $query) => $query->where('estado', true)),
            ],
        ];

        if ($this->alcance === 'categoria') {
            $reglas['categoriasSeleccionadas'][] = 'min:1';
        }

        if ($this->alcance === 'articulo') {
            $reglas['productosSeleccionados'][] = 'min:1';
        }

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'codigo.required' => 'El código del cupón es obligatorio.',
            'codigo.regex' => 'Utiliza solamente letras, números, guiones y guiones bajos.',
            'codigo.unique' => 'Este código ya está registrado.',
            'tipo.in' => 'El tipo de cupón no es válido.',
            'valor.required' => 'Ingresa el valor del cupón.',
            'valor.numeric' => 'El valor debe ser numérico.',
            'valor.gt' => 'El valor debe ser mayor que cero.',
            'valor.lte' => 'El porcentaje no puede superar el 100%.',
            'alcance.in' => 'El alcance seleccionado no es válido.',
            'monto_minimo_compra.numeric' => 'El monto mínimo debe ser numérico.',
            'monto_minimo_compra.gte' => 'El monto mínimo no puede ser negativo.',
            'max_usos_global.min' => 'El límite global debe ser al menos 1.',
            'max_usos_por_usuario.min' => 'El límite por usuario debe ser al menos 1.',
            'fecha_fin.after' => 'La fecha de vencimiento debe ser posterior a la de inicio.',
            'categoriasSeleccionadas.min' => 'Selecciona al menos una categoría.',
            'productosSeleccionados.min' => 'Selecciona al menos un producto.',
        ];

        $datos = $this->validate($reglas, $mensajes);

        // Si se trata de una categoría o un artículo,
        // crear solamente sus objetivos correspondientes.
        $objetivos = [];

        if ($this->alcance === 'categoria') {
            foreach ($this->categoriasSeleccionadas as $id) {
                $objetivos[] = [
                    'tipo_objetivo' => 'categoria',
                    'objetivo_type' => Categoria::class,
                    'objetivo_id' => (int) $id,
                ];
            }
        }

        if ($this->alcance === 'articulo') {
            foreach ($this->productosSeleccionados as $id) {
                $objetivos[] = [
                    'tipo_objetivo' => 'articulo',
                    'objetivo_type' => Producto::class,
                    'objetivo_id' => (int) $id,
                ];
            }
        }

        $datos['monto_minimo_compra'] =
            $this->monto_minimo_compra === ''
                ? null
                : $this->monto_minimo_compra;

        $datos['max_usos_global'] =
            $this->max_usos_global === ''
                ? null
                : $this->max_usos_global;

        $datos['max_usos_por_usuario'] =
            $this->max_usos_por_usuario === ''
                ? null
                : $this->max_usos_por_usuario;

        $datos['fecha_inicio'] = $this->fecha_inicio ?: null;
        $datos['fecha_fin'] = $this->fecha_fin ?: null;

        unset(
            $datos['categoriasSeleccionadas'],
            $datos['productosSeleccionados']
        );

        $esEdicion = $this->cuponId !== null;

        DB::transaction(function () use ($datos, $objetivos) {
            $cupon = $this->cuponId
                ? Cupon::findOrFail($this->cuponId)
                : new Cupon();

            $cupon->fill($datos);
            $cupon->save();

            // Reemplazar los objetivos de forma atómica.
            $cupon->objetivos()->delete();

            if ($objetivos !== []) {
                $cupon->objetivos()->createMany($objetivos);
            }
        });

        Flux::toast(
            heading: 'Cupones',
            text: $esEdicion
                ? 'Cupón actualizado correctamente.'
                : 'Cupón creado correctamente.',
            variant: 'success',
        );

        $this->redirectRoute('cupon.index', navigate: true);
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
                        ["%{$termino}%"]
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
                        ["%{$termino}%"]
                    );
                }
            )
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return view('livewire.admin.cupones.formulario', [
            'categorias' => $categorias,
            'productos' => $productos,
        ])->extends('components.layouts.admin')->section('contenido');
    }
}