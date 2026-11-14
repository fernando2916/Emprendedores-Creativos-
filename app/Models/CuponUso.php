<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CuponUso extends Model
{
    protected $table = 'cupon_usos';

    protected $fillable = [
        'cupon_id',
        'user_id',
        'orden_id',
        'checkout_intento_id',
        'estado',
        'usado_en',
    ];

    protected $casts = [
        'usado_en' => 'datetime',
    ];

    public function cupon(): BelongsTo
    {
        return $this->belongsTo(Cupon::class, 'cupon_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class);
    }

    public function checkoutIntento(): BelongsTo
    {
        return $this->belongsTo(
            CheckoutIntento::class,
            'checkout_intento_id'
        );
    }
}