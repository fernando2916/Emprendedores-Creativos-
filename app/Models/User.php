<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre_completo',
        'username',
        'email',
        'password',
        'email_verified_at',
        'verification_id',
        'verification_code',
        'verification_code_expires_at',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function postComentario()
    {
        return $this->hasMany(PostComentario::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'users_id');
    }

    // Accessor para obtener la foto o una por defecto
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? Storage::url($this->avatar)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->nombre_completo);
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductoReview::class);
    }

    public function productoPreguntas(): HasMany
    {
        return $this->hasMany(ProductoPregunta::class, 'user_id');
    }

    public function productoRespuestas(): HasMany
    {
        return $this->hasMany(ProductoRespuesta::class, 'user_id');
    }

    public function listaDeseos(): BelongsToMany 
    {
        return $this->belongsToMany(
            Producto::class,
            'lista_deseos',
            'user_id',
            'producto_id',
        )->withTimestamps();
    }

    public function carrito(): HasOne
    {
        return $this->hasOne(Carrito::class, 'user_id');
    }

    public function direcciones(): HasMany
    {
        return $this->hasMany(Direccion::class, 'user_id');
    }

    public function cuponUsos(): HasMany
    {
        return $this->hasMany(CuponUso::class, 'user_id');
    }
    
    public function ordenes(): HasMany
    {
        return $this->hasMany(Orden::class);
    }

    public function productosPropios(): HasMany
    {
        return $this->hasMany(Producto::class, 'user_id');
    }

}