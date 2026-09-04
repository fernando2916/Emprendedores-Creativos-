<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class SuscripcionesController extends Controller
{
    public function index(User $user)
    {

        return view('plataforma.profile.suscripciones', compact('user'));
    }
}
