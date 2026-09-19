<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    //
    protected $fillable = [
        'nombre',
        'categoria',
        'formato',
        'imagen',
        'descripcion',
        'etiqueta',
        'precio',
        'archivo',
    ];
}
