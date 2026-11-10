<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Direccion extends Model
{
    //

    protected $table = 'direcciones';

    protected $fillable = [
        'user_id',
        'alias',
        'destinatario',
        'telefono_contacto',
        'calle',
        'numero_exterior',
        'numero_interior',
        'codigo_postal',
        'colonia',
        'municipio',
        'estado',
        'pais',
        'referencias',
        'predeterminada',
    ];

    protected $casts = [
        'predeterminada' => 'boolean',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}