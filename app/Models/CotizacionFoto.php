<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionFoto extends Model
{
    //
    protected $fillable = [
        'nombre',
        'email',
        'detalles',
        'numero_telefonico',
        'paquete_foto_id',
    ];

    public function paquete()
    {
        return $this->belongsTo(PaqueteFoto::class, 'paquete_foto_id');
    }
}
