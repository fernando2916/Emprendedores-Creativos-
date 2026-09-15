<?php

namespace App\Http\Controllers;

use App\Models\PaqueteFoto;
use App\Models\PhotoTestimony;
use App\Models\PortafolioFoto;

class FotoController extends Controller
{
    //
    public function index()
    {
        $testimonios = PhotoTestimony::all();
        $sesiones = PortafolioFoto::all();
        $paquetes = PaqueteFoto::all();

        return view('plataforma.foto.index', compact('testimonios', 'sesiones', 'paquetes'));
    }
}
