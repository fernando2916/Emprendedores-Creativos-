<?php

namespace App\Http\Controllers;

use App\Models\Banner;

class TiendaController extends Controller
{
    //
    public function index()
    {
        $banners = Banner::all();
        return view('plataforma.shop.index', [
           'banners' => $banners, 
        ]);
    }
}