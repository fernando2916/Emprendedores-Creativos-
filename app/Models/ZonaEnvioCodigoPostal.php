<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZonaEnvioCodigoPostal extends Model
{
    //
    protected $table = 'zona_envio_codigos_postales';

    protected $fillable = [
        'zona_envio_id',
        'codigo_postal',
    ];

    public function zona(): BelongsTo
    {
        return $this->belongsTo(
            ZonaEnvio::class,
            'zona_envio_id'
        );
    }
}