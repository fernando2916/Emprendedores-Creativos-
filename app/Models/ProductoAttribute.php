<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductoAttribute extends Model
{
    //
    protected $fillable = [
        'nombre',
        'slug',
        'tipo',
        'estado',
        'producto_attribute_id',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'producto_attribute_id');
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(
            Producto::class,
            'producto_attribute_product',
            'producto_attribute_id',
            'producto_id',
        );
    }
}