<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categoria extends Model
{
    //
    protected $fillable = [
        'nombre',
        'slug',
        'estado',
    ];

    public function subcategorias(): HasMany
    {
        return $this->hasMany(SubCategoria::class);
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    public function descuentos(): BelongsToMany
    {
        return $this->belongsToMany(
            Descuento::class,
            'descuento_categoria',
            'categoria_id',
            'descuento_id'
        );
    }
}