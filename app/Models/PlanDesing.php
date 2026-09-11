<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanDesing extends Model
{
    //
    protected $fillable = [
        'titulo',
        'descripcion',
        'precio',
        'contenido',
    ];

    public function cotizaciones()
    {
        return $this->hasMany(CotizacionDiseño::class);
    }
}
