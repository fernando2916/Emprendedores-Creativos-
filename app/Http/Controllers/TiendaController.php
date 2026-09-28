<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;

class TiendaController extends Controller
{
    //
    public function index()
    {
        $banners = Banner::all();
        $marcas = Brand::latest()->get();
        return view('plataforma.shop.index', [
           'banners' => $banners, 
           'marcas' => $marcas, 
        ]);
    }
}