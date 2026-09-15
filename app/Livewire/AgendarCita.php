<?php

namespace App\Livewire;

use App\Models\CotizacionFoto;
use App\Models\PaqueteFoto;
use Livewire\Component;

class AgendarCita extends Component
{
public $nombre;
public $email;
public $detalles;
public $numero_telefonico;
public $paquete_foto_id;

public $modalAbierto = false;

public $paquetes = [];

public function mount()
{
    $this->paquetes = PaqueteFoto::all();
}

public function rules()
{
    return [
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'numero_telefonico' => 'required|string|max:20',
        'detalles' => 'required|string',
        'paquete_foto_id' => 'required|exists:paquete_fotos,id',
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
    'paquete_foto_id.required' => 'Debes seleccionar un paquete.',
    'paquete_foto_id.exists' => 'El paquete seleccionado no es válido.',
];
}

public function guardar()
{
    $this->validate();
    
    CotizacionFoto::create([
        'nombre' => $this->nombre,
        'email' => $this->email,
        'numero_telefonico' => $this->numero_telefonico,
        'detalles' => $this->detalles,
        'paquete_foto_id' => $this->paquete_foto_id,
    ]);

    $this->reset(['nombre', 'email', 'numero_telefonico', 'detalles', 'paquete_foto_id', 'modalAbierto']);
    $this->dispatch('cotizacionGuardada');
    $this->dispatch('alertCotizacion');

}
    public function render()
    {
        return view('livewire.agendar-cita');
    }
}
