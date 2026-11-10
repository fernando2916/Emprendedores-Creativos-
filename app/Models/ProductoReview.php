<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoReview extends Model
{
    //
    protected $fillable = [
        'producto_id',
        'user_id',
        'calificacion',
        'comentario',
        'estado',
    ];

    protected $casts = [
        'calificacion' => 'integer',
        'estado' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}