<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewCodeController extends Controller
{
     public function index(User $user) 
    {
        // Check if the user is already verified
        if ($user->is_verified === 'Verificado') {
            return redirect()->route('login')->with('message', 'Tu cuenta ya está verificada.');
        }

        // Show the view for requesting a new verification code
        return view('Auth.NewCodeVerification', ['user' => $user]);
    }

    public function store(User $user) 
    {
        // Generate a new verification code and expiration time
        $user->verification_code = rand(100000, 999999);
        $user->verification_code_expires_at = now()->addMinutes(15);
        $user->save();

        Mail::to($user->email)->send(new VerificationCode($user));
        
        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Nuevo código enviado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        // Redirect to the verification page with the user
        return redirect()->route('verify', ['user' => $user]);
    }
}
