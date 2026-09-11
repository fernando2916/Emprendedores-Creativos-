<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CategoriaPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $blogs = Blog::orderBy('id', 'asc')->paginate(10);

        return view('admin.post.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = CategoriaPost::all();

        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png',
            'descripcion_corta' => 'required|string',
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'contenido' => 'required|string',
            'tiempo_de_lectura' => 'required|integer',
            'estado' => 'required',
            'categoria_posts_id' => 'required|exists:categoria_posts,id',
        ], [
            'titulo.required' => ' El titulo es requerido.',
            'slug.required' => ' El slug es requerido.',
            'descripcion_corta.required' => ' La descripción corta es requerida.',
            'contenido.required' => 'El contenido es requerido.',
            'estado.required' => 'El estado de la publicación es requerida.',
            'tiempo_de_lectura.required' => 'El tiempo es requerido.',
            'categoria_posts_id.required' => 'La categoria es requerida.',
        ]);

        // Asignar usuario actual
        $data['users_id'] = auth('web')->id();

        if ($request->hasFile('imagen')) {

            $data['imagen'] = Storage::put('posts', $request->imagen);
        }
        // $path = $request->file('imagen')->store('posts', 'public');

        //    dd($data);

        $blog = Blog::create($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post creado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.blogs.edit', compact('blog'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
        return view('admin.post.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
        $categories = CategoriaPost::all();

        return view('admin.post.edit', compact('blog', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png',
            'descripcion_corta' => 'required|string',
            'slug' => 'required|string|max:255|unique:blogs,slug,'.$blog->id,
            'contenido' => 'required|string',
            'tiempo_de_lectura' => 'required|integer',
            'estado' => 'required',
            'categoria_posts_id' => 'required|exists:categoria_posts,id',
        ], [
            'titulo.required' => ' El titulo es requerido.',
            'slug.required' => ' El slug es requerido.',
            'descripcion_corta.required' => ' La descripción corta es requerida.',
            'contenido.required' => 'El contenido es requerido.',
            'estado.required' => 'El estado de la publicación es requerida.',
            'tiempo_de_lectura.required' => 'El tiempo es requerido.',
            'categoria_posts_id.required' => 'La categoria es requerida.',
        ]);

        // Asignar usuario actual
        $data['users_id'] = auth('web')->id();

        if ($request->hasFile('imagen')) {

            if ($blog->imagen) {
                Storage::delete($blog->imagen);
            }

            $data['imagen'] = Storage::put('posts', $request->imagen);
        }
        // $path = $request->file('imagen')->store('posts', 'public');

        //    dd($data);

        $blog->update($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post actualizado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
        $blog->delete();

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post Eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.blogs.index');
    }
}
