<?php

namespace App\Http\Controllers;

use App\Models\Glosario;

class GlosarioController extends Controller
{
    //
    public function index()
    {
        $glosarios = Glosario::all();

        return view('plataforma.glosario.index', compact('glosarios'));
    }
}
