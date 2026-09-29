<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRules;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    //
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_completo' => 'required|string|min:4|max:25',
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|email|unique:users,email',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'password' => [
                'required',
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ],
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.min' => 'El nombre debe tener al menos 4 caracteres.',
            'nombre_completo.max' => 'El nombre no puede tener más de 25 caracteres.',

            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.max' => 'El nombre de usuario no debe tener más de 20 caracteres.',
            'username.unique' => 'Este nombre de usuario ya está en uso.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes proporcionar un correo válido.',
            'email.unique' => 'Este correo ya está registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.letters' => 'La contraseña debe incluir al menos una letra.',
            'password.symbols' => 'La contraseña debe incluir al menos un símbolo.',
            'password.numbers' => 'La contraseña debe incluir al menos un número.',
        ]);


        $data['username'] = Str::slug($data['username']);

        $user = User::create([
            'nombre_completo' => $data['nombre_completo'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verification_id' => Str::uuid(),
            'is_verified' => 'Verificado',
            'email_verified_at' => now()
        ]);

        if (isset($data['roles'])) {
            $user->roles()->attach($data['roles']);
        }

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario creado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'nombre_completo' => 'required|string|min:4|max:25',
            'username' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => [
                'nullable',
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ],
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.min' => 'El nombre debe tener al menos 4 caracteres.',
            'nombre_completo.max' => 'El nombre no puede tener más de 25 caracteres.',

            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.max' => 'El nombre de usuario no debe tener más de 20 caracteres.',
            'username.unique' => 'Este nombre de usuario ya está en uso.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes proporcionar un correo válido.',
            'email.unique' => 'Este correo ya está registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.letters' => 'La contraseña debe incluir al menos una letra.',
            'password.symbols' => 'La contraseña debe incluir al menos un símbolo.',
            'password.numbers' => 'La contraseña debe incluir al menos un número.',
        ]);

        $user->nombre_completo = $data['nombre_completo'];
        $user->username = $data['username'];
        $user->email = $data['email'];

        if (isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        $user->roles()->sync($request->input('roles', []));

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario Actualizado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario Eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.users.index');
    }
}