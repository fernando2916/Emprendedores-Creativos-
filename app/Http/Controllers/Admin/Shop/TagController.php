<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $etiquetas = Tag::withCount('productos')->orderBy('id', 'asc')->paginate(10);

        return view('admin.shop.etiquetas.index', compact('etiquetas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.shop.etiquetas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $datos = $request->validate([
            'nombre' => 'required|string|max:255|unique:tags,nombre'
        ], [
            'nombre.required' => 'El nombre de la etiqueta es requerido.',
            'nombre.unique' => 'El nombre de la etiqueta ya existe.'
        ]);

        $datos['slug'] = Str::slug($datos['nombre']);

        $etiqueta = Tag::create($datos);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Etiqueta creada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.etiqueta.edit', $etiqueta);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $etiqueta)
    {
        //
        return view('admin.shop.etiquetas.edit', compact('etiqueta'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $etiqueta)
    {
        //
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:tags,nombre,' . $etiqueta->id,
            ],
        ]);

        $datos['slug'] = Str::slug($datos['nombre']);

        $etiqueta->update($datos);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Etiqueta Editada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.etiqueta.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $etiqueta)
    {
        //
        $etiqueta->delete();

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Etiqueta Eliminada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.etiqueta.index');
    }
}