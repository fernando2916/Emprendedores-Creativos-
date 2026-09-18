<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    //
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'curriculum',
        'vacante_id',
    ];

    public function vacante()
    {
        return $this->belongsTo(Vacante::class);
    }
}
