<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Descuento extends Model
{
    //
    protected $table = 'descuentos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'valor',
        'alcance',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'estado' => 'boolean',
    ];

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(
            Categoria::class,
            'descuento_categoria',
            'descuento_id',
            'categoria_id'
        );
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(
            Producto::class,
            'descuento_producto',
            'descuento_id',
            'producto_id'
        );
    }

    /**
     * Consulta únicamente descuentos activos y dentro de su vigencia.
     */
    public function scopeVigentes(Builder $query): Builder
    {
        return $query
            ->where('estado', true)
            ->where(function (Builder $consulta) {
                $consulta
                    ->whereNull('fecha_inicio')
                    ->orWhere('fecha_inicio', '<=', now());
            })
            ->where('fecha_fin', '>=', now());
    }

    /**
     * Comprueba si este descuento está vigente en este momento.
     */
    public function estaVigente(): bool
    {
        return $this->estado
            && (
                $this->fecha_inicio === null
                || $this->fecha_inicio->lte(now())
            )
            && $this->fecha_fin !== null
            && $this->fecha_fin->gte(now());
    }

    public function estadoVigencia(): string
{
    if (! $this->estado) {
        return 'Inactivo';
    }

    if ($this->fecha_inicio?->isFuture()) {
        return 'Programado';
    }

    if ($this->fecha_fin?->isPast()) {
        return 'Vencido';
    }

    return 'Vigente';
}
}