<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class MetodosPagoController extends Controller
{
    public function index(User $user)
    {

        return view('plataforma.profile.metodos-pago', compact('user'));
    }
}
