<?php

namespace App\Livewire;

use App\Models\Glosario;
use Livewire\Component;

class GlosarioHome extends Component
{
    public $titulo;

    protected $listeners = ['terminosBusqueda' => 'buscar'];

    public function buscar($titulo)
    {
        $this->titulo = $titulo;

    }

    public function render()
    {
        $glosarios = Glosario::when($this->titulo, function ($query) {
            $query->where('titulo', 'LIKE', '%'.$this->titulo.'%');
        })->orderBy('titulo', 'asc')->get();

        return view('livewire.glosario-home', [
            'glosarios' => $glosarios,
        ]);
    }
}
