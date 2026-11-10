<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CuponObjetivo extends Model
{
    protected $table = 'cupon_objetivos';

    protected $fillable = [
        'cupon_id',
        'tipo_objetivo',
        'objetivo_type',
        'objetivo_id',
    ];

    public function cupon(): BelongsTo
    {
        return $this->belongsTo(Cupon::class, 'cupon_id');
    }

    public function objetivo(): MorphTo
    {
        return $this->morphTo();
    }
}