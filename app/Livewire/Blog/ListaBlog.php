<?php

namespace App\Livewire\Blog;

use App\Models\Blog;
use App\Models\CategoriaPost;
use Livewire\Component;
use Livewire\WithPagination;


class ListaBlog extends Component
{
    use WithPagination;

    public string $busqueda = '';
    
    public string $categoria = '';

    public function updatedBusqueda()
    {
        $this->resetPage();
    }

    public function updatedCategoria()
    {
        $this->resetPage();
    }

    public function render()
    {
    $blogs = Blog::query()
            ->where('estado', 'Publicado')
            ->when($this->busqueda, function ($query) {
                $query->where(function ($q) {
                    $q->where('titulo', 'like', '%' . $this->busqueda . '%')
                      ->orWhere('contenido', 'like', '%' . $this->busqueda . '%');
                });
            })

            ->when($this->categoria, function ($query) {
            $query->where('categoria_posts_id', $this->categoria);
            })
            
            ->latest()
            ->paginate(6);

            $categorias = CategoriaPost::orderBy('nombre')->get();
            
        return view('livewire.blog.lista-blog', [
            'blogs' => $blogs,
            'categorias' => $categorias,
        ]);
    }
}