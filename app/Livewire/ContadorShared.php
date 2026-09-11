<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;

class ContadorShared extends Component
{
    public Blog $blog;

    public int $totalCompartidas = 0;

    protected $listeners = ['postCompartido' => 'actualizarContador'];

    public function mount(Blog $blog)
    {
        $this->blog = $blog;
        $this->actualizarContador();
    }

    public function actualizarContador()
    {
        $this->totalCompartidas = $this->blog->fresh()->share_count;
    }

    public function render()
    {
        return view('livewire.contador-shared');
    }
}
