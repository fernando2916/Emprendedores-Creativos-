<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionDiseño extends Model
{
    //
    protected $fillable = [
        'nombre',
        'email',
        'detalles',
        'numero_telefonico',
        'plan_desing_id',
    ];

    public function plan()
    {
        return $this->belongsTo(PlanDesing::class, 'plan_desing_id');
    }
}
