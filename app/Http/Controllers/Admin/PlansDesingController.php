<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanDesing;
use Illuminate\Http\Request;

class PlansDesingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $planes = PlanDesing::all();

        return view('admin.desing.index', compact('planes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.desing.create');
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

        $plane = PlanDesing::create($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Plan creado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.plans.edit', compact('plane'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanDesing $planDesing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanDesing $plane)
    {
        //
        return view('admin.desing.edit', compact('plane'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlanDesing $plane)
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

        $plane->update($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Plan actualizado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.plans.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanDesing $plane)
    {
        //
        $plane->delete();

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Plan Eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.plans.index');
    }
}
