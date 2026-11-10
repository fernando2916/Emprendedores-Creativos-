<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subcategorias = SubCategoria::with('categoria')->orderBy('id', 'asc')->paginate(10);
        return view('admin.shop.subcategoria.index', compact('subcategorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categorias = Categoria::where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view(
            'admin.shop.subcategoria.create',
            compact('categorias')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $subcategoria = $request->validate([
        'categoria_id' => [
            'required',
            'exists:categorias,id',
        ],

        'nombre' => [
            'required',
            'string',
            'max:255',
        ],

        'estado' => [
            'required',
            'boolean',
        ],
    ]);

    $subcategoria['slug'] = Str::slug($subcategoria['nombre']);

    $existe = SubCategoria::where('categoria_id', $subcategoria['categoria_id'])
        ->where('slug', $subcategoria['slug'])
        ->exists();

    if ($existe) {
        return back()
            ->withInput()
            ->withErrors([
                'nombre' => 'Ya existe una subcategoría con ese nombre dentro de esta categoría.',
            ]);
    }
    $subcategoria = SubCategoria::create($subcategoria);
    // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'SubCategoria creada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.subcategoria.edit', $subcategoria);
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
    public function edit(SubCategoria $subcategoria)
    {
        //
        $categorias = Categoria::where('estado', true)
        ->orderBy('nombre')
        ->get();

    return view(
        'admin.shop.subcategoria.edit',
        compact('subcategoria', 'categorias')
    );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategoria $subcategoria)
    {
        //
        $datos = $request->validate([
        'categoria_id' => [
            'required',
            'exists:categorias,id',
        ],

        'nombre' => [
            'required',
            'string',
            'max:255',
        ],

        'estado' => [
            'required',
            'boolean',
        ],
    ]);

    $datos['slug'] = Str::slug($datos['nombre']);

    $existe = SubCategoria::where('categoria_id', $datos['categoria_id'])
        ->where('slug', $datos['slug'])
        ->where('id', '!=', $subcategoria->id)
        ->exists();

    if ($existe) {
        return back()
            ->withInput()
            ->withErrors([
                'nombre' => 'Ya existe una subcategoría con ese nombre dentro de esta categoría.',
            ]);
    }

    $subcategoria->update($datos);
    // mensaje flash
    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'SubCategoria Editada correctamente',
        'background' => '#120024',
        'color' => '#ffffff',
    ]);

    return redirect()->route('admin.subcategoria.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategoria $subcategoria)
    {
        //
        $subcategoria->delete();

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'SubCategoria Eliminada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.subcategoria.index');
    }
}