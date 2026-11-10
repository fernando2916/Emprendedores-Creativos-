<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class License extends Model
{
    //
    protected $fillable = [
        'nombre',
        'imagen',
    ];

    public function products(): HasMany
{
    return $this->hasMany(Producto::class);
}
}