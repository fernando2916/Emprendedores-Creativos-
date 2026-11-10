<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoImage extends Model
{
    //
    protected $fillable = [
        'producto_id',
        'producto_variante_id',
        'imagen',
        'orden',
        'principal',
    ];

    protected $casts = [
        'principal' =>'boolean', 
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function variante(): BelongsTo
    {
        return $this->belongsTo(ProductoVariante::class, 'producto_variante_id');
    }
}