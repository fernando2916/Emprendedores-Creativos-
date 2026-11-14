<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenStockEspera extends Model
{
    protected $table = 'orden_stock_esperas';

    protected $fillable = [
        'orden_id',
        'orden_item_id',
        'producto_variante_id',
        'cantidad',
        'estado',
        'asignado_en',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'asignado_en' => 'datetime',
        ];
    }

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function ordenItem(): BelongsTo
    {
        return $this->belongsTo(OrdenItem::class, 'orden_item_id');
    }

    public function variante(): BelongsTo
    {
        return $this->belongsTo(
            ProductoVariante::class,
            'producto_variante_id'
        );
    }
}