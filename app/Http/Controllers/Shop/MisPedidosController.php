<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MisPedidosController extends Controller
{
    public function show()
    {
        return view('plataforma.shop.misCompras.show');
    }
}