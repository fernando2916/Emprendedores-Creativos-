<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terminos extends Model
{
    //
    protected $casts = [
    'fecha' => 'date', // Reemplaza 'fecha' por el nombre exacto de tu columna
];

//
protected $fillable = [
    'titulo',
    'fecha',
    'contenido',
];
}
