<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ConfirmPasswordController extends Controller
{
    public function index(User $user)
    {
        return view('Auth.ConfirmPassword', [
            'user' => $user
        ]);
    }

    public function store(PasswordRequest $request, User $user)
    {
        $data = $request->validated();

        $user->password = bcrypt($data['password']);
        $user->save();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Contraseña actualizada',
            'text' => 'Tu contraseña ha sido actualizada correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('login');
    }
}
