<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;

class EstadisticasPost extends Component
{
public $total = 0 ;
public $publicado = 0 ;
public $borrador = 0 ;
public $procentajePublicados = 0 ;

 public function mount()
{
    $this->actualizarDatos();
}

 public function actualizarDatos()
{
    $this->total = Blog::count();
    $this->publicado = Blog::where('estado', 'Publicado')->count();
    $this->borrador = Blog::where('estado', 'Borrador')->count();

    $this->procentajePublicados = $this->total > 0
        ? round(($this->publicado / $this->total) * 100)
        : 0;
}
    public function render()
    {
        return view('livewire.estadisticas-post');
    }
}