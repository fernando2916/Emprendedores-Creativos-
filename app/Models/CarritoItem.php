<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CarritoItem extends Model
{
    //

    protected $table = 'carrito_items';

    protected $fillable = [
        'carrito_id',
        'comprable_type',
        'comprable_id',
        'cantidad',
    ];

    protected $casts = [
        'cantidad' => 'integer',
    ];

    public function carrito(): BelongsTo
    {
        return $this->belongsTo(Carrito::class, 'carrito_id');
    }

    public function comprable(): MorphTo
    {
        return $this->morphTo();
    }
}