<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    //
    protected $fillable = [
        'nombre',
        'slug',
    ];

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class);
    } 
}