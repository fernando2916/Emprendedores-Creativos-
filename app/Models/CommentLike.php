<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    protected $fillable = [
        'post_comentario_id',
        'user_id',
    ];

    public function comment()
    {
        return $this->belongsTo(PostComentario::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
