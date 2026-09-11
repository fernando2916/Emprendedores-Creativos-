<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proyect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProyectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $proyectos = Proyect::orderBy('id', 'asc')->paginate(10);

        return view('admin.proyect.index', compact('proyectos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.proyect.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:proyects,slug',
            'descripcion' => 'required|string',
            'objetivo' => 'required|string',
            'cliente' => 'required|string',
            'image_principal' => 'nullable|image|mimes:jpeg,png,jpg',
            'image_second' => 'nullable|image|mimes:jpeg,png,jpg',
            'image_third' => 'nullable|image|mimes:jpeg,png,jpg',
            'image_fourth' => 'nullable|image|mimes:jpeg,png,jpg',
        ], [
            'titulo.required' => ' El titulo es requerido.',
            'descripcion.required' => 'La descripcion es requerida.',
            'objetivo.required' => 'El obejtivo es requerido.',
            'cliente.required' => 'La marca es requerida.',
        ]);

        if ($request->hasFile('image_principal')) {

            $data['image_principal'] = Storage::put('proyecto', $request->image_principal);
        }
        if ($request->hasFile('image_second')) {

            $data['image_second'] = Storage::put('proyecto', $request->image_second);
        }
        if ($request->hasFile('image_third')) {

            $data['image_third'] = Storage::put('proyecto', $request->image_third);
        }
        if ($request->hasFile('image_fourth')) {

            $data['image_fourth'] = Storage::put('proyecto', $request->image_fourth);
        }

        $proyecto = Proyect::create($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Proyecto creado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.proyecto.edit', compact('proyecto'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyect $proyect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyect $proyecto)
    {
        //
        return view('admin.proyect.edit', compact('proyecto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyect $proyecto)
    {
        //
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:proyects,slug,'.$proyecto->id,
            'descripcion' => 'required|string',
            'objetivo' => 'required|string',
            'cliente' => 'required|string',
            'image_principal' => 'nullable|image|mimes:jpeg,png,jpg',
            'image_second' => 'nullable|image|mimes:jpeg,png,jpg',
            'image_third' => 'nullable|image|mimes:jpeg,png,jpg',
            'image_fourth' => 'nullable|image|mimes:jpeg,png,jpg',
        ], [
            'titulo.required' => ' El titulo es requerido.',
            'descripcion.required' => 'La descripcion es requerida.',
            'objetivo.required' => 'El obejtivo es requerido.',
            'cliente.required' => 'La marca es requerida.',
        ]);

        if ($request->hasFile('image_principal')) {
            if ($proyecto->image_principal) {
                Storage::delete($proyecto->image_principal);
            }

            $data['image_principal'] = Storage::put('proyecto', $request->image_principal);
        }
        if ($request->hasFile('image_second')) {
            if ($proyecto->image_second) {
                Storage::delete($proyecto->image_second);
            }

            $data['image_second'] = Storage::put('proyecto', $request->image_second);
        }
        if ($request->hasFile('image_third')) {
            if ($proyecto->image_third) {
                Storage::delete($proyecto->image_third);
            }

            $data['image_third'] = Storage::put('proyecto', $request->image_third);
        }
        if ($request->hasFile('image_fourth')) {
            if ($proyecto->image_fourth) {
                Storage::delete($proyecto->image_fourth);
            }

            $data['image_fourth'] = Storage::put('proyecto', $request->image_fourth);
        }

        $proyecto->update($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Proyecto actualizado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.proyecto.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyect $proyect)
    {
        //
        $proyect->delete();
        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Proyecto eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.proyecto.index');
    }
}
