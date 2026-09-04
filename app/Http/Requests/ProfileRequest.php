<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'nombre_completo' => ['required', 'string', 'min:4', 'max:25'],
            'username' => ['required', 'string', 'min:3', 'max:20', 'unique:users,username,'.$userId],
            'headline' => ['nullable', 'string', 'max:60'],
            'biografia' => ['nullable', 'string', 'max:255'],
            'facebook_user' => ['nullable', 'string', 'max:255'],
            'instagram_user' => ['nullable', 'string', 'max:255'],
            'whatsapp_user' => ['nullable', 'string', 'max:255'],
            'twitter_user' => ['nullable', 'string', 'max:255'],
            'tiktok_user' => ['nullable', 'string', 'max:255'],
            'youtube_user' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_completo.required' => 'El nombre es obligatorio.',
            'nombre_completo.min' => 'El nombre debe tener al menos 4 caracteres.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'El nombre de usuario ya existe, utiliza otro.',
            'headline.max' => 'El título profesional no puede exceder 60 caracteres.',
            'biografia.max' => 'La biografía no puede exceder 255 caracteres.',
        ];
    }
}
