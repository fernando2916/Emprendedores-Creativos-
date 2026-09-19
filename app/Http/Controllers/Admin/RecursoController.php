<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $recursos = Recurso::orderBy('id', 'asc')->paginate(10);

        return view('admin.recursos.index', compact('recursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.recursos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos = $request->validate([
            'nombre' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png',
            'categoria' => 'required|string',
            'formato' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'nullable',
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png,psd,eps,ai',
        ], [
            'nombre' => 'El nombre es requerido.',
            'imagen' => 'La imagen es requerida.',
            'categoria' => 'La categoria es requerida.',
            'formato' => 'El formato es requerido.',
            'descripcion' => 'La descrición es requerida.',
            'precio' => '',
            'archivo' => 'El archivo es requerido.',
        ]);

        if ($request->hasFile('imagen')) {

            $datos['imagen'] = Storage::put('recursos/imagenes', $request->imagen);
        }

        if ($request->hasFile('archivo')) {

            $datos['archivo'] = Storage::put('recursos/archivos', $request->archivo);
        }

        if (empty($datos['precio'])) {
            $datos['precio'] = 'Gratis';
        }

        $recurso = Recurso::create($datos);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Recurso Creado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.recursos.edit', compact('recurso'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Recurso $recurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recurso $recurso)
    {
        //
        return view('admin.recursos.edit', compact('recurso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recurso $recurso)
    {
        //
        $datos = $request->validate([
            'nombre' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png',
            'categoria' => 'required|string',
            'formato' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'nullable',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png,psd,eps,ai',
        ], [
            'nombre' => 'El nombre es requerido.',
            'imagen' => 'La imagen es requerida.',
            'categoria' => 'La categoria es requerida.',
            'formato' => 'El formato es requerido.',
            'descripcion' => 'La descrición es requerida.',
            'precio' => '',
            'archivo' => 'El archivo es requerido.',
        ]);

        if ($request->hasFile('imagen')) {

            $datos['imagen'] = Storage::put('recursos/imagenes', $request->imagen);
        }

        if ($request->hasFile('archivo')) {

            $datos['archivo'] = Storage::put('recursos/archivos', $request->archivo);
        }

        if (empty($datos['precio'])) {
            $datos['precio'] = 'Gratis';
        }

        $recurso->update($datos);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Recurso Actualizado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.recursos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recurso $recurso)
    {
        //
        $recurso->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Recurso eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.recursos.index');
    }
}
