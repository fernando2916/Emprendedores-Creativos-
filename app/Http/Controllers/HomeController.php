<?php

namespace App\Http\Controllers;

use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::all();

        return view('home', [
            'banners' => $banners,
        ]);
    }
}
