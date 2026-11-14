<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CheckoutIntento extends Model
{
    protected $table = 'checkout_intentos';

    protected $fillable = [
        'referencia_externa',
        'user_id',
        'cupon_id',
        'orden_id',
        'estado',
        'metodo_pago',
        'cupon_codigo',
        'mercadopago_order_id',
        'mercadopago_idempotency_key',
        'mercadopago_checkout_url',
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
        'fecha_expiracion',
        'fecha_pago',
        'fecha_liberacion',
        'respuesta_pasarela',
    ];

    protected function casts(): array
    {
        return [
            'direccion_entrega' => 'array',
            'respuesta_pasarela' => 'array',

            'subtotal_original' => 'decimal:2',
            'descuento_promociones' => 'decimal:2',
            'descuento_cupon' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'costo_envio' => 'decimal:2',
            'total' => 'decimal:2',

            'fecha_expiracion' => 'datetime',
            'fecha_pago' => 'datetime',
            'fecha_liberacion' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cupon(): BelongsTo
    {
        return $this->belongsTo(Cupon::class, 'cupon_id');
    }

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            CheckoutIntentoItem::class,
            'checkout_intento_id'
        );
    }

    public function cuponUso(): HasOne
    {
        return $this->hasOne(
            CuponUso::class,
            'checkout_intento_id'
        );
    }
}