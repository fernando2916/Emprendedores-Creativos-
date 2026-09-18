<?php

namespace App\Livewire;

use App\Models\Vacante;
use Livewire\Component;

class Vacantes extends Component
{
    public $vacantes;

    public $vacanteSeleccionada;

    public function mount()
    {
        $this->vacantes = Vacante::latest()->get();
        $this->vacanteSeleccionada = $this->vacantes->first();
    }

    public function seleccionarVacante($id)
    {
        $this->vacanteSeleccionada = Vacante::find($id);
    }

    public function render()
    {
        return view('livewire.vacantes');
    }
}
