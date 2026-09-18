<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\Vacante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VacantesController extends Controller
{
    //
    public function index()
    {
        $vacantes = Vacante::latest()->paginate(5);

        return view('plataforma.vacantes.index', compact('vacantes'));
    }

    public function show(Vacante $vacante)
    {
        return view('plataforma.vacantes.show', compact('vacante'));
    }

    public function store(Request $request, Vacante $vacante)
    {
        $datos = $request->validate([
            // 'vacantes_id' => 'required|exists:vacantes,id',
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:10',
            'curriculum' => 'required|mimes:pdf',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'El correo electrónico debe ser válido.',
            'correo.max' => 'El correo no debe exceder los 255 caracteres.',
            'telefono.required' => 'El número telefónico es obligatorio.',
            'telefono.max' => 'El número telefónico no debe exceder los 20 caracteres.',
            'curriculum.required' => 'El CV es obligatorio.',
        ]);

        // dd($datos);

        if ($request->hasFile('curriculum')) {

            $datos['curriculum'] = Storage::put('candidatos', $request->curriculum);
        }

        $datos['vacante_id'] = $vacante->id;
        Candidato::create($datos);

        // mensaje flash
        return back()->with('swal', [
            'icon' => 'success',
            'title' => 'Solicitud envidada correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

    }
}
