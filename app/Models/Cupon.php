<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cupon extends Model
{
    protected $table = 'cupones';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'tipo',
        'valor',
        'alcance',
        'monto_minimo_compra',
        'max_usos_global',
        'max_usos_por_usuario',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'monto_minimo_compra' => 'decimal:2',
        'max_usos_global' => 'integer',
        'max_usos_por_usuario' => 'integer',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'estado' => 'boolean',
    ];

    public function setCodigoAttribute(string $valor): void
    {
        $this->attributes['codigo'] = mb_strtoupper(trim($valor));
    }

    public function objetivos(): HasMany
    {
        return $this->hasMany(CuponObjetivo::class, 'cupon_id');
    }

    public function usos(): HasMany
    {
        return $this->hasMany(CuponUso::class, 'cupon_id');
    }

    public function scopeVigentes(Builder $query): Builder
    {
        return $query
            ->where('estado', true)
            ->where(function (Builder $subquery) {
                $subquery
                    ->whereNull('fecha_inicio')
                    ->orWhere('fecha_inicio', '<=', now());
            })
            ->where(function (Builder $subquery) {
                $subquery
                    ->whereNull('fecha_fin')
                    ->orWhere('fecha_fin', '>=', now());
            });
    }

    public function estaVigente(): bool
    {
        return $this->estado
            && (
                $this->fecha_inicio === null
                || $this->fecha_inicio->lte(now())
            )
            && (
                $this->fecha_fin === null
                || $this->fecha_fin->gte(now())
            );
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