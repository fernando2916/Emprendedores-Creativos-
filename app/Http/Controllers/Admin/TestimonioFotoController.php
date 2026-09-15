<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotoTestimony;
use Illuminate\Http\Request;

class TestimonioFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $testimonios = PhotoTestimony::all();

        return view('admin.foto.testimonio.index', compact('testimonios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.foto.testimonio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'testimonio' => 'required|string',
            'autor' => 'required|string',
            'red_social' => 'nullable|string',
        ], [
            'testimonio.required' => 'El testimonio es requerido.',
            'autor.required' => 'El autor es requerido.',
            'res_social.string' => 'La red debe ser un string.',
        ]);

        $testimonio = PhotoTestimony::create($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Testimonio Creado correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.testimonio.edit', compact('testimonio'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PhotoTestimony $photoTestimony)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhotoTestimony $testimonio)
    {
        //
        return view('admin.foto.testimonio.edit', compact('testimonio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhotoTestimony $testimonio)
    {
        //
        $data = $request->validate([
            'testimonio' => 'required|string',
            'autor' => 'required|string',
            'red_social' => 'nullable|string',
        ], [
            'testimonio.required' => 'El testimonio es requerido.',
            'autor.required' => 'El autor es requerido.',
            'res_social.string' => 'La red debe ser un string.',
        ]);

        $testimonio->update($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Testimonio actualizado correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.testimonio.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhotoTestimony $testimonio)
    {
        //
        $testimonio->delete();

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Testimonio Eliminado correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.testimonio.index');
    }
}
