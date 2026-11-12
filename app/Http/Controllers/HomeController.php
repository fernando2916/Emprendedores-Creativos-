<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Producto;

class HomeController extends Controller
{
    public function index()
    {
    
        $ultimosPost = Blog::latest()->take(3)->get();

        $productos = Producto::with([
        'images',
        'categoria',
        'subCategoria',
        'tags',
        'variantes',
        'reseñasPublicadas:id,producto_id,calificacion',
    ])
        ->where('estado', true)
        ->latest()
        ->take(3)
        ->get();


        return view('home', [
            'ultimosPost' => $ultimosPost,
            'productos' => $productos,
        ]);
    }
}