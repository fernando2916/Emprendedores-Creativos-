<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre_completo' => ['required', 'string', 'min:4', 'max:25'],
            'username' => ['required', 'unique:users', 'min:3', 'max:20'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required', 
                'confirmed', 
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ],
        ];
    }

    public function messages()
    {
        return [
            'nombre_completo' => 'El nombre es obligatorio',
            'username.required' => 'El nombre de usuario es obligatorio',
            'username.unique' => 'El nombre de usuario ya existe, utiliza otro',
            'username.min' => 'El nombre de usuario debe tener al menos 3 caracteres',
            'email.required' => 'El correo es obligatorio',
            'email.email' => 'El correo no es válido',
            'email.unique' => 'El correo ya esta registrado, utiliza otro',
            'password' => 'La contraseña debe de contener al menos 8 caracteres, un símbolo, un número y tiene que estar confirmada.',
            'password.confirmed' => 'Las contraseñas no son iguales'
        ];
    }
}
