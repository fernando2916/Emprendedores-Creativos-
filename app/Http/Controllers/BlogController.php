<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {

        return view('plataforma.blog.index');
    }

    public function show(Blog $blog)
    {
        return view('plataforma.blog.show', compact('blog'));
    }
}