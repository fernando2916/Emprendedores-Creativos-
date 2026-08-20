<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('Auth.Login');
    }

    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if(!Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('message', 'Credenciales incorrectas');
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Sesión Iniciada Correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('home');
    }
}
