<?php

namespace App\Http\Controllers;

use App\Models\Proyect;

class ProyectosController extends Controller
{
    //
    public function index()
    {
        $proyects = Proyect::latest()->paginate(3);

        return view('plataforma.proyectos.index', compact('proyects'));
    }
}
