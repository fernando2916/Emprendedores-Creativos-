<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductoVariante extends Model
{
    //
    protected $fillable = [
        'producto_id',
        'sku',
        'precio',
        'stock',
        'estado',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'estado' => 'boolean',
    ]; 

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function valores(): BelongsToMany
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'producto_variante_attribute_value',
            'producto_variante_id',
            'attribute_value_id'
        );
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(VarianteAttribute::class);
    }

}