<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        $ultimosPost = Blog::latest()->take(3)->get();

        return view('home', [
            'banners' => $banners,
            'ultimosPost' => $ultimosPost,
        ]);
    }
}
