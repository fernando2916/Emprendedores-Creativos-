<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    //
    protected $fillable = [
        'puesto',
        'modalidad',
        'horario',
        'empresa',
        'salario',
        'identificador',
        'postulacion',
        'descripcion',
    ];

    protected $casts = [
        'postulacion' => 'date', // o 'datetime' según sea el caso
    ];

    public function candidatos()
    {
        return $this->hasMany(Candidato::class)->orderBy('created_at', 'DESC');
    }
}
