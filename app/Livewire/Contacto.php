<?php

namespace App\Livewire;

use App\Models\Contacto as ModelsContacto;
use App\Models\PrivacyNotice;
use Livewire\Component;

class Contacto extends Component
{
    public $name;

    public $email;

    public $company;

    public $phone;

    public $messaje;

    public $privacy;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'required|string|max:50',
            'phone' => 'required|string',
            'messaje' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.max' => 'El correo no debe exceder los 255 caracteres.',
            'phone.required' => 'El número telefónico es obligatorio.',
            'phone.max' => 'El número telefónico no debe exceder los 20 caracteres.',
            'company.required' => 'La empresa o negocio es requerido.',
            'messaje.required' => 'Debes dejar todos los detalles.',
        ];
    }

    public function save()
    {
        $contacto = $this->validate();

        ModelsContacto::create($contacto);

        $this->reset(['name', 'email', 'phone', 'company', 'messaje']);
        $this->dispatch('alertContacto');
    }

    public function mount()
    {
        $this->privacy = PrivacyNotice::first();
    }

    public function render()
    {
        return view('livewire.contacto');
    }
}
