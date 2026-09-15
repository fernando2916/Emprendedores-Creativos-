<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaqueteFoto extends Model
{
    //
    protected $fillable = [
        'titulo',
        'descripcion',
        'contenido',
        'precio',
    ];
}
