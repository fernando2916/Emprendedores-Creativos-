<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortafolioFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortafolioFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sesiones = PortafolioFoto::all();

        return view('admin.foto.portafolio.index', compact('sesiones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.foto.portafolio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'imagen_foto' => 'required|image|mimes:jpeg,jpg',
            'tipo' => 'required|string',
        ], [
            'imagen_foto.required' => 'La imagen es requerida.',
            'tipo.required' => 'El tipo es requerido.',
        ]);

        if ($request->hasFile('imagen_foto')) {

            $data['imagen_foto'] = Storage::put('portafolio', $request->imagen_foto);
        }

        $sesione = PortafolioFoto::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Sesion creada correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.sesion.edit', compact('sesione'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PortafolioFoto $portafolioFoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PortafolioFoto $sesione)
    {
        return view('admin.foto.portafolio.edit', compact('sesione'));        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PortafolioFoto $sesione)
    {
        $data = $request->validate([
            'imagen_foto' => 'required|image|mimes:jpeg,jpg',
            'tipo' => 'required|string',
        ], [
            'imagen_foto.required' => 'La imagen es requerida.',
            'tipo.required' => 'El tipo es requerido.',            
        ]);

         if ($request->hasFile('imagen_foto')) {

            if($sesione->imagen_foto) {
                Storage::delete($sesione->imagen_foto);
            }

            $data['imagen_foto'] = Storage::put('portafolio', $request->imagen_foto);
        }

        $sesione->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Sesion actualizada correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.sesion.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PortafolioFoto $sesione)
    {
        //
        $sesione->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Sesion Eliminada correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.sesion.index');
    }
}
