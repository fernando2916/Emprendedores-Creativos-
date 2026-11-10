<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ZonaEnvio extends Model
{
    //
    protected $table = 'zonas_envio';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tarifa',
        'monto_minimo_envio_gratis',
        'activa',
    ];

    protected $casts = [
        'tarifa' => 'decimal:2',
        'monto_minimo_envio_gratis' => 'decimal:2',
        'activa' => 'boolean',
    ];

    public function codigosPostales(): HasMany
    {
        return $this->hasMany(
            ZonaEnvioCodigoPostal::class,
            'zona_envio_id'
        );
    }
}