<?php

namespace App\Livewire;

use App\Models\Boletin as ModelsBoletin;
use Livewire\Component;

class Boletin extends Component
{
    public $email;

    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.max' => 'El correo no debe exceder los 255 caracteres.',
        ];
    }

    public function save()
    {

        $boletin = $this->validate();

        ModelsBoletin::create($boletin);

        $this->reset(['email']);
        $this->dispatch('alertSuscripcion');
    }

    public function render()
    {
        return view('livewire.boletin');
    }
}
