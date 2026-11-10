<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orden extends Model
{
    protected $table = 'ordenes';
    
    protected $fillable = [
    'numero',
    'user_id',
    'cupon_id',
    'cupon_codigo',
    'estado',
    'estado_pago',
    'metodo_pago',
    'referencia_pago',
    'fecha_pago',
    'fecha_expiracion',
    'tipo_entrega',
    'direccion_entrega',
    'zona_envio',
    'subtotal_original',
    'descuento_promociones',
    'descuento_cupon',
    'subtotal',
    'costo_envio',
    'total',
    'moneda',
    'notas',
    'paqueteria',
    'numero_guia',
    'url_rastreo',
    'fecha_envio',
    'fecha_entrega',
    'notas_admin',
    ];

    protected function casts(): array
    {
    return [
        'fecha_pago' => 'datetime',
        'fecha_expiracion' => 'datetime',
        'direccion_entrega' => 'array',
        'subtotal_original' => 'decimal:2',
        'descuento_promociones' => 'decimal:2',
        'descuento_cupon' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'costo_envio' => 'decimal:2',
        'total' => 'decimal:2',
        'fecha_envio' => 'datetime',
        'fecha_entrega' => 'datetime',
    ];
    }

    public function usuario(): BelongsTo
    {
    return $this->belongsTo(User::class, 'user_id');
    }

    public function cupon(): BelongsTo
    {
    return $this->belongsTo(Cupon::class);
    }

    public function items(): HasMany
    {
    return $this->hasMany(OrdenItem::class);
    }
}