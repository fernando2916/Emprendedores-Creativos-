<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaPost;
use Illuminate\Http\Request;

class CategoriaPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = CategoriaPost::orderBy('id', 'asc')->paginate(10);

        return view('admin.post.categorias.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.post.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|max:50|unique:categoria_posts',
        ], [
            'nombre.required' => 'El nombre de la categoria es obligatorio.',
            'nombre.unique' => 'El nombre de la categoria ya existe.',
        ]);

        $category = CategoriaPost::create([
            'nombre' => $request->nombre,
        ]);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Categoria creada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoriaPost $categoriaPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoriaPost $category)
    {
        //
        return view('admin.post.categorias.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoriaPost $category)
    {
        //
        $request->validate([
            'nombre' => 'required|max:50|unique:categoria_posts',
        ], [
            'nombre.required' => 'El nombre de la categoria es obligatorio.',
            'nombre.unique' => 'El nombre de la categoria ya existe.',
        ]);

        $category->update([
            'nombre' => $request->nombre,
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Categoria post actualizada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriaPost $category)
    {
        //
        $category->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Categoria post eliminada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.categories.index');
    }
}
