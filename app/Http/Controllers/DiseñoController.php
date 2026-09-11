<?php

namespace App\Http\Controllers;

use App\Models\OpinionDesign;
use App\Models\PlanDesing;
use App\Models\Proyect;

class DiseñoController extends Controller
{
    //

    public function index()
    {
        $planes = PlanDesing::all();

        $proyects = Proyect::all();

        $opiniones = OpinionDesign::all();

        return view('plataforma.diseno.index', compact('planes', 'proyects', 'opiniones'));
    }

    public function show(Proyect $proyect)
    {
        return view('plataforma.diseno.show', compact('proyect'));
    }
}
