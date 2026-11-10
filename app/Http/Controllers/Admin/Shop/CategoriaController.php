<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $categorias = Categoria::orderBy('id', 'asc')->paginate(10);
        return view('admin.shop.categoria.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.shop.categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $categoria = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'estado' => 'required|boolean',
        ], [
            'nombre.required' => 'El nombre de la categoria es requerido.',
            'nombre.unique' => 'El nombre de la categoria ya existe.',
            'estado.required' => 'El estado es requerido.',
        ]);
        
        $categoria['slug'] = Str::slug($categoria['nombre']);

        $categoria = Categoria::create($categoria);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Categoria creada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.categoria.edit', $categoria);

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
        return view('admin.shop.categoria.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        //
        $datos = $request->validate([
        'nombre' => 'required|string|max:255|unique:categorias,nombre',
        'estado' => 'required|boolean',
    ], [
        'nombre.required' => 'El nombre de la categoria es requerido.',
        'nombre.unique' => 'El nombre de la categoria ya existe.',
        'estado.required' => 'El estado es requerido.',
    ]);
    
    $datos['slug'] = Str::slug($datos['nombre']);

    $categoria->update($datos);

    // mensaje flash
    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Categoria editada correctamente',
        'background' => '#120024',
        'color' => '#ffffff',
    ]);

    return redirect()->route('admin.categoria.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
        $categoria->delete();

        // mensaje flash
    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Categoria eliminada correctamente',
        'background' => '#120024',
        'color' => '#ffffff',
    ]);

    return redirect()->route('admin.categoria.index');

    }
}