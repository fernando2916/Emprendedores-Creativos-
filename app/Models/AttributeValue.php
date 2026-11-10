<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeValue extends Model
{
    //
    protected $fillable = [
        'producto_attribute_id',
        'valor',
        'slug',
        'codigo',
    ];
    
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(ProductoAttribute::class, 'producto_attribute_id');
    }

    public function variantAttributes(): HasMany
    {
        return $this->hasMany(VarianteAttribute::class);
    }
}