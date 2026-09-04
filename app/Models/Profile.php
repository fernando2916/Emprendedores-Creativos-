<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class Profile extends Model
{
    protected $fillable = [
        'avatar',
        'headline',
        'biografia',
        'locacion',
        'facebook_user',
        'instagram_user',
        'whatsapp_user',
        'twitter_user',
        'tiktok_user',
        'youtube_user',
        'users_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? Storage::url($this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->user->nombre_completo ?? 'User');
    }
}
