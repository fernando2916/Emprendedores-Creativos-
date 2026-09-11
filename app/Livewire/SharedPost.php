<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;

class SharedPost extends Component
{
    public Blog $blog;

    public function incrementShare()
    {
        $this->blog->incrementShareCount();
        $this->blog->refresh();
        $this->dispatch('postCompartido');
    }

    public function render()
    {
        return view('livewire.shared-post');
    }
}
