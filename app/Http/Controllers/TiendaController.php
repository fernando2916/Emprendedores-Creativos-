<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Producto;

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

    public function show(Producto $producto)
    {
        $producto->load([
            'images',
            'brand',
            'license',
            'categoria',
            'tags',
            'subCategoria',
            'atributos',
            'variantes.valores.attribute',
        ]);
        return view('plataforma.shop.show', compact('producto'));
    }

    public function carrito()
    {
        return view('plataforma.shop.carrito.index');
    }
}