<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Auth.Register');
    }

    public function store(RegisterRequest $request)
    {
        $expiration = now()->addMinutes(15);
        $data = $request->validated();

        $data['username'] = Str::slug($data['username']);
        
        $user = User::create([
            'nombre_completo' => $data['nombre_completo'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verification_code' => random_int(100000, 999999),
            'verification_code_expires_at' => $expiration,
            'verification_id' => Str::uuid(),
        ]);

        Mail::to($user->email)->send(new VerificationMail($user));

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Registro exitoso',
            'text' => 'Se ha enviado un correo con el código para verificar tu cuenta. Revisa tu bandeja de entrada o carpeta de spam.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);


        return redirect()->route('verify', [
            'user' => $user,
        ]);
    }

}
