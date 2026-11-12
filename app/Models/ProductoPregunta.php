<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProductoPregunta extends Model
{
    protected $table = 'producto_preguntas';

    protected $fillable = [
        'producto_id',
        'user_id',
        'contenido',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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