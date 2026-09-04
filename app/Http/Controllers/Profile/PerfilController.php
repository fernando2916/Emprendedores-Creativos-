<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PerfilController extends Controller
{
    public function index(User $user)
    {
        return view('plataforma.profile.perfil', compact('user'));
    }

    public function update(ProfileRequest $request, User $user)
    {
        abort_unless(Auth::id() === $user->id, 403);

        $data = $request->validated();
        $data['username'] = Str::slug($data['username']);

        $user->update([
            'nombre_completo' => $data['nombre_completo'],
            'username' => $data['username'],
        ]);

        $user->profile()->updateOrCreate(
            ['users_id' => $user->id],
            [
                'headline' => $data['headline'] ?? null,
                'biografia' => $data['biografia'] ?? null,
                'facebook_user' => $data['facebook_user'] ?? null,
                'instagram_user' => $data['instagram_user'] ?? null,
                'whatsapp_user' => $data['whatsapp_user'] ?? null,
                'twitter_user' => $data['twitter_user'] ?? null,
                'tiktok_user' => $data['tiktok_user'] ?? null,
                'youtube_user' => $data['youtube_user'] ?? null,
            ]
        );

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Perfil Actualizado',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('perfil.index', [
            'user' => $user->username,
        ]);
    }

    public function delete(User $user)
    {
        return view('plataforma.profile.cerrar-cuenta', compact('user'));
    }
}
