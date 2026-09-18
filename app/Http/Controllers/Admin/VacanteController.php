<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidato;
use App\Models\Vacante;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VacanteController extends Controller
{
    //
    public function index()
    {
        $vacantes = Vacante::orderBy('id', 'asc')->paginate(5);
        $candidatos = Candidato::all();

        return view('admin.vacantes.index', compact('vacantes', 'candidatos'));
    }

    public function create()
    {
        return view('admin.vacantes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'puesto' => 'required|string',
            'modalidad' => 'required|string',
            'horario' => 'required',
            'empresa' => 'required',
            'descripcion' => 'required',
            'salario' => 'required',
            'postulacion' => 'required|date_format:Y-m-d',
        ], [
            'puesto' => 'El puesto es requerido.',
            'modalidad' => 'La modalidad es requerida.',
            'horario' => 'El horario es requerido.',
            'empresa' => 'La empresa es requerida.',
            'descripcion' => 'La descripción es requerida.',
            'salario' => 'El salario es requerido.',
            'postulacion' => 'La postulación es requerida.',
        ]);

        $vacante = Vacante::create([
            'puesto' => $data['puesto'],
            'modalidad' => $data['modalidad'],
            'horario' => $data['horario'],
            'empresa' => $data['empresa'],
            'descripcion' => $data['descripcion'],
            'salario' => $data['salario'],
            'postulacion' => $data['postulacion'],
            'identificador' => Str::uuid(),
        ]);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Vacante creada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.vacante.edit', compact('vacante'));
    }

    public function show(Candidato $candidatos)
    {
        return view('admin.vacantes.candidatos.index', $candidatos);
    }

    public function edit(Vacante $vacante)
    {
        return view('admin.vacantes.edit', compact('vacante'));
    }

    public function update(Request $request, Vacante $vacante)
    {
        $data = $request->validate([
            'puesto' => 'required|string',
            'modalidad' => 'required|string',
            'horario' => 'required',
            'empresa' => 'required',
            'descripcion' => 'required',
            'salario' => 'required',
            'postulacion' => 'required',
        ], [
            'puesto' => 'El puesto es requerido.',
            'modalidad' => 'La modalidad es requerida.',
            'horario' => 'El horario es requerido',
            'empresa' => 'La empresa es requerida.',
            'descripcion' => 'La descripción es requerida.',
            'salario' => 'El salario es requerido.',
            'postulacion' => 'La postulación es requerida',
        ]);

        $vacante->update($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Vacante creada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.vacante.index');
    }

    public function destroy(Vacante $vacante)
    {
        $vacante->delete();

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Vacante eleminada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.vacante.index');
    }
}
