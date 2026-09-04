<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FotoPerfilController extends Controller
{
    public function index(User $user)
    {

        return view('plataforma.profile.fotografia', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        abort_unless(Auth::id() === $user->id, 403);
        $request->validate([
            'avatar' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($user->profile->avatar) {
            Storage::disk('public')->delete($user->profile->avatar);
        }

        $path = $request->file('avatar')->store('user/perfil', 'public');

        $user->profile->update([
            'avatar' => $path,
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Foto de Perfil Actualizada',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('foto.edit', [
            'user' => $user,
        ]);
    }
}
