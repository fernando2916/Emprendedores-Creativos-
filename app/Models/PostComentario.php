<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComentario extends Model
{
    //
    protected $fillable = [
        'contenido',
        'blog_id',
        'user_id',
    ];

    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'post_comentario_id')
            ->whereNull('parent_id')
            ->latest();
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    public function isLikedBy($userId)
    {
        return $this->likes->contains('user_id', $userId);
    }
}
