<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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
            'email.email' => 'El correo debe ser válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Rate Limiters
        |--------------------------------------------------------------------------
        */
        $email = Str::lower($request->email);
    
        // Límite por correo + IP
        $loginKey = 'login:' . $email . '|' . $request->ip();
    
        $maxAttempts = 4;
        $decaySeconds = 1800;
    
        /*
        |--------------------------------------------------------------------------
        | Comprobar límite por email + IP
        |--------------------------------------------------------------------------
        */
    
        if (RateLimiter::tooManyAttempts($loginKey, $maxAttempts)) {
    
            $seconds = RateLimiter::availableIn($loginKey);
    
            return back()
                ->withInput($request->only('email', 'remember'))
                ->with('login_locked', true)
                ->with('login_seconds', $seconds)
                ->with(
                    'message',
                    "Demasiados intentos fallidos. Intenta nuevamente en {$seconds} segundos."
                );
        }
    
        /*
        |--------------------------------------------------------------------------
        | Intentar iniciar sesión
        |--------------------------------------------------------------------------
        */
    
        if (!Auth::attempt([
            'email' => $email,
            'password' => $request->password,
        ], $request->boolean('remember'))) {
    
            // Registrar intento en ambos limitadores
            RateLimiter::hit($loginKey, $decaySeconds);
    
            $attempts = RateLimiter::attempts($loginKey);
    
            $remaining = max(0, $maxAttempts - $attempts);
    
            /*
            |--------------------------------------------------------------------------
            | Se alcanzó el límite
            |--------------------------------------------------------------------------
            */
    
            if ($attempts >= $maxAttempts) {
    
                $seconds = RateLimiter::availableIn($loginKey);
    
                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->with('login_locked', true)
                    ->with('login_seconds', $seconds)
                    ->with(
                        'message',
                        "Has superado el número máximo de intentos. Intenta nuevamente en 30 minutos."
                    );
            }
    
            /*
            |--------------------------------------------------------------------------
            | Intento fallido pero todavía puede intentar
            |--------------------------------------------------------------------------
            */
    
            return back()
                ->withInput($request->only('email', 'remember'))
                ->with(
                    'message',
                    "Credenciales incorrectas. Te quedan {$remaining} intentos."
                );
        }
    
        /*
        |--------------------------------------------------------------------------
        | Login correcto
        |--------------------------------------------------------------------------
        */
    
        RateLimiter::clear($loginKey);
    
        $request->session()->regenerate();
    
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Sesión Iniciada Correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);
    

        return redirect()->route('home');
    }
}
