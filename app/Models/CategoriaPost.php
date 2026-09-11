<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaPost extends Model
{
    //
    protected $fillable = [
        'nombre',
    ];

    public function blog(): HasMany
    {
        return $this->hasMany(Blog::class);
    }
}
