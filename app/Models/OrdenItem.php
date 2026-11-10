<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrdenItem extends Model
{
    protected $table = 'orden_items';
    
    protected $fillable = [
    'orden_id',
    'comprable_type',
    'comprable_id',
    'nombre_articulo',
    'sku',
    'imagen',
    'datos_articulo',
    'cantidad',
    'precio_original_unitario',
    'precio_unitario',
    'subtotal_original',
    'subtotal',
    ];

    protected function casts(): array
    {
    return [
        'datos_articulo' => 'array',
        'cantidad' => 'integer',
        'precio_original_unitario' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'subtotal_original' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];
    }

    public function orden(): BelongsTo
    {
    return $this->belongsTo(Orden::class);
    }

    public function comprable(): MorphTo
    {
    return $this->morphTo();
    }
}