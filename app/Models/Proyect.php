<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyect extends Model
{
    //
    protected $fillable = [
        'titulo',
        'slug',
        'image_principal',
        'image_second',
        'image_third',
        'image_fourth',
        'descripcion',
        'objetivo',
        'cliente',
        'categoria',
        'url',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}