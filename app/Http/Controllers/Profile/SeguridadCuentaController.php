<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password as PasswordRules;

class SeguridadCuentaController extends Controller
{
    public function index(User $user)
    {
        return view('plataforma.profile.seguridad-cuenta', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => [
                'required',
                'confirmed',
                PasswordRules::min(8)->letters()->symbols()->numbers(),
            ],
        ], [
            'current_password.required' => 'Debes ingresar tu contraseña actual.',
            'password' => 'La contraseña debe de contener al menos 8 caracteres, un símbolo, un número y debe estar confirmada.',
            'password.confirmed' => 'Las contraseñas no son iguales',
            'password.required' => 'Debes ingresar una nueva contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = $request->user();

        // Verificar la contraseña actual
        if (! password_verify($request->current_password, $user->password)) {
            return back()
                ->withErrors([
                    'current_password' => 'La contraseña actual es incorrecta.',
                ])
                ->withInput();
        }

        // Guardar la nueva contraseña
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Contraseña actualizada',
            'text' => 'Tu contraseña ha sido actualizada correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('cuenta.edit', [
            'user' => $user->username,
        ]);
    }
}
