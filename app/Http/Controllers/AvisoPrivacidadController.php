<?php

namespace App\Http\Controllers;

class AvisoPrivacidadController extends Controller
{
    //
    public function index()
    {
        return view('plataforma.privacidad.aviso.index');
    }

    public function resumen()
    {
        return view('plataforma.privacidad.index');
    }
}
