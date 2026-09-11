<?php

namespace App\Livewire;

use App\Models\Blog;
use App\Models\PostComentario;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ComentarioPost extends Component
{
    public $blog;

    public $comentarios;

    public $contenido = '';

    public $contenidoRespuesta = '';

    public $respuestaActiva = null;

    public $respuestaPadre = null;

    protected $listeners = ['respuestaAgregada' => 'actualizarComentarios'];

    public function mount(Blog $blog)
    {
        $this->blog = $blog;
        $this->cargarComentarios();
    }

    public function cargarComentarios()
    {
        $this->comentarios = $this->blog->comentarioPost()
            ->with([
                'autor.profile',
                'likes',
                'replies.user.profile',
                'replies.likes',
            ])
            ->latest()
            ->get();

        // Cargar recursivamente las respuestas
        foreach ($this->comentarios as $comentario) {
            $this->cargarRespuestasRecursivas($comentario->replies);
        }
    }

    private function cargarRespuestasRecursivas($replies)
    {
        foreach ($replies as $reply) {

            $reply->load([
                'user.profile',
                'likes',
            ]);

            $hijas = $reply->replies()
                ->latest()
                ->get();

            $reply->setRelation('replies', $hijas);

            if ($hijas->isNotEmpty()) {
                $this->cargarRespuestasRecursivas($hijas);
            }
        }
    }

    public function comentar()
    {
        $this->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        $comentario = PostComentario::create([
            'blog_id' => $this->blog->id,
            'user_id' => Auth::id(),
            'contenido' => $this->contenido,
        ]);

        $this->comentarios->prepend($comentario);
        $this->contenido = '';

        $this->cargarComentarios();
        $this->dispatch('comentarioAgregado');
    }

    // Método para agregar respuestas
    public function responder($comentarioId)
    {
        $this->validate([
            'contenidoRespuesta' => 'required|string|max:1000',
        ]);

        Reply::create([
            'post_comentario_id' => $comentarioId,
            'user_id' => Auth::id(),
            'parent_id' => $this->respuestaPadre,
            'contenido' => $this->contenidoRespuesta,
        ]);

        $this->contenidoRespuesta = '';
        $this->respuestaActiva = null;
        $this->respuestaPadre = null;

        $this->cargarComentarios();

        $this->dispatch('comentarioAgregado');

    }

    public function responderComentario($comentarioId)
    {
        $this->respuestaActiva = 'comentario-'.$comentarioId;
        $this->respuestaPadre = null;
        $this->contenidoRespuesta = '';
    }

    public function responderReply($replyId)
    {
        $this->respuestaActiva = 'reply-'.$replyId;
        $this->respuestaPadre = $replyId;
        $this->contenidoRespuesta = '';
    }

    public function cancelarRespuesta()
    {
        $this->respuestaActiva = null;
        $this->respuestaPadre = null;
        $this->contenidoRespuesta = '';
    }

    // Actualizar los comentarios después de agregar una respuesta
    public function actualizarComentarios()
    {
        $this->cargarComentarios();
    }

    public function getTotalComentariosProperty()
    {
        return $this->comentarios->sum(function ($comentario) {
            return 1 + $this->contarRespuestas($comentario->replies);
        });
    }

    private function contarRespuestas($replies)
    {
        return $replies->sum(function ($reply) {
            return 1 + $this->contarRespuestas($reply->replies);
        });
    }

    public function likeRespuesta($replyId)
    {
        if (! Auth::check()) {
            return;
        }

        $userId = Auth::id();

        $reply = Reply::findOrFail($replyId);

        $like = $reply->likes()->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
        } else {
            $reply->likes()->create([
                'user_id' => $userId,
            ]);
        }

        $this->cargarComentarios();
    }

    public function likeComment($comentarioId)
    {
        $userId = Auth::id();

        $comentario = PostComentario::findOrFail($comentarioId);

        $like = $comentario->likes()->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
        } else {
            $comentario->likes()->create([
                'user_id' => $userId,
            ]);
        }

        $this->cargarComentarios();
    }

    public function render()
    {
        return view('livewire.comentario-post');
    }
}
