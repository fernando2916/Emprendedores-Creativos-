<?php

namespace App\Livewire;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikePost extends Component
{
    public $blog;

    public $isLiked = false;

    public $likes = 0;

    public function mount(Blog $blog)
    {
        $this->blog = $blog;

        $this->isLiked = $this->blog->checkLike(Auth::user());
        $this->likes = $this->blog->likes->count();
    }

    public function like()
    {
        $user = Auth::user();

        if ($this->blog->checkLike($user)) {
            $this->blog->likes()->where('user_id', $user->id)->delete();
            $this->isLiked = false;
            $this->likes--;
        } else {
            $this->blog->likes()->create([
                'user_id' => $user->id,
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
