<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaqueteFoto;
use Illuminate\Http\Request;

class PaqueteFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $paquetes = PaqueteFoto::all();
        return view('admin.foto.paquetes.index', compact('paquetes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.foto.paquetes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|string',
            'contenido' => 'required|string',
        ], [
            'titulo.required' => 'El titulo es requerido.',
            'descripcion.required' => 'La descripcion es requerida.',
            'precio.required' => 'El precio es requerido.',
            'contenido.required' => 'El contenido es requerido.',
        ]);
        
        $paquete = PaqueteFoto::create($data);

         // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Paquete creado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.paquete.edit', compact('paquete'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PaqueteFoto $paqueteFoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaqueteFoto $paquete)
    {
        //
        return view('admin.foto.paquetes.edit', compact('paquete'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaqueteFoto $paquete)
    {
        //
        $data = $request->validate([
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|string',
            'contenido' => 'required|string',
        ], [
            'titulo.required' => 'El titulo es requerido.',
            'descripcion.required' => 'La descripcion es requerida.',
            'precio.required' => 'El precio es requerido.',
            'contenido.required' => 'El contenido es requerido.',
        ]);
        
        $paquete->update($data);

         // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Paquete actualizado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.paquete.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaqueteFoto $paquete)
    {
        //
        $paquete->delete();

        return redirect()->route('admin.paquete.index');
    }
}
