<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProductoValoracion extends Model
{
    protected $table = 'producto_valoraciones';

    protected $fillable = [
        'user_id',
        'util',
    ];

    protected $casts = [
        'util' => 'boolean',
    ];

    public function valoracionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}