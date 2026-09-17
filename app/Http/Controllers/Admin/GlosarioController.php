<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Glosario;
use Illuminate\Http\Request;

class GlosarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $glosarios = Glosario::latest()->paginate(10);

        return view('admin.glosario.index', compact('glosarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.glosario.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos = $request->validate([
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
        ], [
            'titulo' => 'El titulo es requerido.',
            'descripcion' => 'La descripción es requerida.',
        ]);

        $glosario = Glosario::create($datos);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Definición Creada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.glosario.edit', compact('glosario'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Glosario $glosario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Glosario $glosario)
    {
        //
        return view('admin.glosario.edit', compact('glosario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Glosario $glosario)
    {
        //
        $datos = $request->validate([
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
        ], [
            'titulo' => 'El titulo es requerido.',
            'descripcion' => 'La descripción es requerida.',
        ]);

        $glosario->update($datos);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Definición actualizada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.glosario.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Glosario $glosario)
    {
        //
        $glosario->delete();

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Definición Eliminada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.glosario.index');
    }
}
