<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    'mercadopago_order_id',
    'mercadopago_idempotency_key',
    'mercadopago_checkout_url',
    'decision_stock',
    'fecha_notificacion_stock',
    'fecha_limite_decision_stock',
    'fecha_decision_stock',
    'estado_reembolso',
    'mercadopago_refund_id',
    'fecha_reembolso',
    'motivo_reembolso',
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
        'fecha_notificacion_stock' => 'datetime',
        'fecha_limite_decision_stock' => 'datetime',
        'fecha_decision_stock' => 'datetime',
        'fecha_reembolso' => 'datetime',
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

    public function checkoutIntento(): HasOne
    {
        return $this->hasOne(
            CheckoutIntento::class,
            'orden_id'
        );
    }

    public function esperasStock(): HasMany
    {
        return $this->hasMany(
            OrdenStockEspera::class,
            'orden_id'
        );
    }
}