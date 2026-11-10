<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Direccion;

class Carrito extends Model
{
    //
    protected $table ='carritos';

    protected $fillable = [
        'user_id',
        'direccion_id',
        'tipo_entrega',
        'cupon_id',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CarritoItem::class, 'carrito_id');
    }
    
    public function direccionEntrega(): BelongsTo
    {
        return $this->belongsTo(Direccion::class, 'direcicion_id');
    }

    public function cupon(): BelongsTo
    {
        return $this->belongsTo(Cupon::class, 'cupon_id');
    }
}