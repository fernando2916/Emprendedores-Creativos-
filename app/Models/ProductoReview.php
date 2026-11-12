<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProductoReview extends Model
{
    protected $table = 'producto_reviews';
    
    protected $fillable = [
        'producto_id',
        'user_id',
        'orden_id',
        'calificacion',
        'comentario',
        'estado',
    ];

    protected $casts = [
        'calificacion' => 'integer',
        'estado' => 'boolean',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    
    public function product(): BelongsTo
    {
        return $this->producto();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function respuestas(): MorphMany
    {
        return $this->morphMany(
            ProductoRespuesta::class,
            'respondible'
        )->whereNull('parent_id')->latest();
    }

    public function valoraciones(): MorphMany
    {
        return $this->morphMany(
            ProductoValoracion::class,
            'valoracionable'
        );
    }
}