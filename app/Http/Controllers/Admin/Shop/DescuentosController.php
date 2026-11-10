<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DescuentosController extends Controller
{
    //
    public function index()
    {
        return view('admin.shop.descuentos.index');
    }
    public function create()
    {
        return view('admin.shop.descuentos.create');
    }
}