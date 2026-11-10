<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $table = 'productos';
    //
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'brand_id',
        'license_id',
        'categoria_id',
        'sub_categoria_id',
        'estado',
        'destacado',
    ];

    protected $casts = [
        'destacado' => 'boolean',
        'estado' => 'boolean',
    ];

    public function atributos():BelongsToMany
    {
        return $this->belongsToMany(ProductoAttribute::class, 'producto_attribute_product', 'producto_id', 'producto_attribute_id');
    }
    
    public function brand():BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    
    public function license():BelongsTo
    {
        return $this->belongsTo(License::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function subCategoria(): BelongsTo
    {
        return $this->belongsTo(SubCategoria::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductoImage::class, 'producto_id')->orderBy('orden');
    }

    public function reseñas(): HasMany
    {
        return $this->hasMany(ProductoReview::class);
    }

    public function variantes(): HasMany
    {
        return $this->hasMany(ProductoVariante::class, 'producto_id');
    }

    public function usuariosListaDeseos(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'lista_deseos',
            'producto_id',
            'user_id',
        )->withTimestamps();    
    }

    public function descuentos(): BelongsToMany
    {
        return $this->belongsToMany(
            Descuento::class,
            'descuento_producto',
            'producto_id',
            'descuento_id'
        );
    }
    
}