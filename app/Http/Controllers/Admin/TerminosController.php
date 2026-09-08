<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Terminos;
use Illuminate\Http\Request;

class TerminosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $terminos = Terminos::orderBy('id', 'asc')->paginate(10);

        return view('admin.legales.terminos.index', compact('terminos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.legales.terminos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
        'titulo' => 'required|string|max:255',
        'fecha' => 'required|date',
        'contenido' => 'required|string',
    ], [
        'titulo.required' => 'El titulo es requerido',
        'fecha.required' => 'La fecha es requerida',
        'contenido.required' => 'El contenido es requerido',
    ]);

    $termsCond = Terminos::create($data);

    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Terminos y condiciones creado correctamente',
        'background' => '#120024',
        'color' => '#ffffff',
    ]);

    return redirect()->route('admin.terminos.index', compact('termsCond'));
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Terminos $terminos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Terminos $terminos)
    {
        //
        return view('admin.legales.terminos.edit', compact(
        'terminos'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Terminos $terminos)
    {
        //
        $data = $request->validate([
        'titulo' => 'required|string|max:255',
        'fecha' => 'required|date',
        'contenido' => 'required|string',
    ], [
        'titulo.required' => 'El titulo es requerido',
        'fecha.required' => 'La fecha es requerida',
        'contenido.required' => 'El contenido es requerido',
    ]);

    $terminos->update($data);

    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Terminos y condiciones actualizado correctamente',
        'background' => '#120024',
        'color' => '#ffffff',
    ]);

    return redirect()->route('admin.terminos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Terminos $terminos)
    {
        //
    }
}
