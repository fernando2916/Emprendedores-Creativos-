<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class EstadisticasUsuarios extends Component
{
    public $total = 0 ;
    public $verificados = 0 ;
    public $pendientes = 0 ;
    public $procentajeVerificados = 0 ;

    public function mount()
    {
        $this->actualizarDatos();
    }

    public function actualizarDatos()
    {
        $this->total = User::count();
        $this->verificados = User::where('is_verified', 'Verificado')->count();
        $this->pendientes = User::where('is_verified', 'Pendiente')->count();

        $this->procentajeVerificados = $this->total > 0
            ? round(($this->verificados / $this->total) * 100)
            : 0;
    }

    public function render()
    {
        return view('livewire.estadisticas-usuarios');
    }
}