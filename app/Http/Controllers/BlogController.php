<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        // Solo posts publicados
        $blogs = Blog::where('estado', 'Publicado')
            ->latest()
            ->skip(4)
            ->paginate(6);

        // Post más reciente (publicado)
        $postReciente = Blog::where('estado', 'Publicado')
            ->latest()
            ->first();

        // Últimos 3 excluyendo el más reciente
        $ultimosPosts = collect(); // vacío por si no hay posts

        if ($postReciente) {
            $ultimosPosts = Blog::where('estado', 'Publicado')
                ->where('id', '!=', $postReciente->id)
                ->latest()
                ->take(3)
                ->get();
        }

        return view('plataforma.blog.index', compact('blogs', 'postReciente', 'ultimosPosts'));
    }

    public function show(Blog $blog)
    {
        return view('plataforma.blog.show', compact('blog'));
    }
}
