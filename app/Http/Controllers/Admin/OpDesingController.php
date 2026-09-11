<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpinionDesign;
use Illuminate\Http\Request;

class OpDesingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $opiniones = OpinionDesign::all();

        return view('admin.desing.opinion.index', compact('opiniones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.desing.opinion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'opinion' => 'required|string',
            'autor' => 'required|string',
            'red_social' => 'required|string',
        ], [
            'opinion.required' => 'La opinión es requerida.',
            'autor.required' => 'El autor es requerido.',
            'red_social.required' => 'La red social es requerida.',
        ]);

        $opinione = OpinionDesign::create($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Opinión Creada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.opinion.edit', compact('opinione'));
    }

    /**
     * Display the specified resource.
     */
    public function show(OpinionDesign $opinionDesign)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OpinionDesign $opinione)
    {
        //
        return view('admin.desing.opinion.edit', compact('opinione'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OpinionDesign $opinione)
    {
        //
        $data = $request->validate([
            'opinion' => 'required|string',
            'autor' => 'required|string',
            'red_social' => 'required|string',
        ], [
            'opinion.required' => 'La opinión es requerida.',
            'autor.required' => 'El autor es requerido.',
            'red_social.required' => 'La red social es requerida.',
        ]);

        $opinione->update($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Opinión Actualizada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.opinion.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OpinionDesign $opinione)
    {
        //
        $opinione->delete();

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Opinión Eliminada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.opinion.index');
    }
}
