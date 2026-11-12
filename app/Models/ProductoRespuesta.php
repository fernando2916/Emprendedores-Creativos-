<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProductoRespuesta extends Model
{
    protected $table = 'producto_respuestas';

    protected $fillable = [
        'user_id',
        'contenido',
        'parent_id',
    ];

    public function respondible(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            ProductoRespuesta::class,
            'parent_id'
        );
    }

    public function replies(): HasMany
    {
        return $this->hasMany(
            ProductoRespuesta::class,
            'parent_id'
        )->latest();
    }

    public function valoraciones(): MorphMany
    {
        return $this->morphMany(
            ProductoValoracion::class,
            'valoracionable'
        );
    }
}