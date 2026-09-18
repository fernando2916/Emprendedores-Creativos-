<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vacante;

class CandidatosController extends Controller
{
    //
    public function index(Vacante $vacante)
    {
        return view('admin.vacantes.candidatos.index', [
            'vacante' => $vacante,
        ]);
    }
}
