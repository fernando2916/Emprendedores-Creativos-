<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyNotice extends Model
{
    protected $fillable = [
        'nombre',
        'fecha',
        'contenido',
    ];
}
