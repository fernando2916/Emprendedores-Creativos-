<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $licencias = License::orderBy('id', 'asc')->paginate(10);

        return view('admin.shop.licencias.index', compact('licencias')); 
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.shop.licencias.create'); 

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
    ], [
        'nombre' => 'El nombre es requerido.',
        'imagen' => 'La imagen es requerida.',
    ]);

    if ($request->hasFile('imagen')) {

        $datos['imagen'] = Storage::put('tienda/licencias', $request->imagen);
    }

    $licencia = License::create($datos);

    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Licencia creada correctamente',
        'background' => '#120024',
        'color' => '#ffffff',
    ]);

    return redirect()->route('admin.licencia.edit', compact('licencia'));
    }

    /**
     * Display the specified resource.
     */
    public function show(License $license)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(License $licencia)
    {
        //
        return view('admin.shop.licencias.edit', compact('licencia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, License $licencia)
    {
        //
        $datos = $request->validate([
        'nombre' => 'required|string',
        'imagen' => 'nullable|image|mimes:jpeg,png',
    ], [
        'nombre' => 'El nombre es requerido.',
        'imagen' => 'La imagen es requerida.',
    ]);

    if ($request->hasFile('imagen')) {

        $datos['imagen'] = Storage::put('tienda/licencias', $request->imagen);
    }


    $licencia->update($datos);

    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Licencia actualizada correctamente',
        'background' => '#120024',
        'color' => '#ffffff',
    ]);

    return redirect()->route('admin.licencia.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(License $licencia)
    {
        //
        //
        $licencia->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Licencia eliminada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.licencia.index');
    }
}