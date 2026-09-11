<?php

namespace App\Livewire;

use App\Models\CotizacionDiseño;
use App\Models\PlanDesing;
use Livewire\Component;

class FormularioCotizacion extends Component
{
    public $nombre;

    public $email;

    public $detalles;

    public $numero_telefonico;

    public $plan_desing_id;

    public $modalAbierto = false;

    public $planes = [];

    public function mount()
    {
        $this->planes = PlanDesing::all();
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'numero_telefonico' => 'required|string|max:20',
            'detalles' => 'required|string',
            'plan_desing_id' => 'required|exists:plan_desings,id',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.max' => 'El correo no debe exceder los 255 caracteres.',
            'numero_telefonico.required' => 'El número telefónico es obligatorio.',
            'numero_telefonico.max' => 'El número telefónico no debe exceder los 20 caracteres.',
            'detalles.required' => 'Por favor, proporciona detalles de tu solicitud.',
            'plan_desing_id.required' => 'Debes seleccionar un plan.',
            'plan_desing_id.exists' => 'El plan seleccionado no es válido.',
        ];
    }

    public function guardar()
    {
        $this->validate();

        CotizacionDiseño::create([
            'nombre' => $this->nombre,
            'email' => $this->email,
            'numero_telefonico' => $this->numero_telefonico,
            'detalles' => $this->detalles,
            'plan_desing_id' => $this->plan_desing_id,
        ]);

        $this->reset(['nombre', 'email', 'numero_telefonico', 'detalles', 'plan_desing_id', 'modalAbierto']);
        $this->dispatch('cotizacionGuardada');
        $this->dispatch('alertCotizacion');
    }

    public function render()
    {
        return view('livewire.formulario-cotizacion');
    }
}
