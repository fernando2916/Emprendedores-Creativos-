<div class="flex items-center gap-2">
    <button 
        wire:click="like" 
        class="focus:outline-none cursor-pointer transition-colors duration-200"
        @if(!Auth::check()) disabled @endif
        title="@if(Auth::check()) Me gusta @else Inicia sesión para dar like @endif"
    >
        @if($isLiked)
            <i class="fa-solid fa-thumbs-up text-3xl text-link-100"></i>
        @else
            <i class="fa-solid fa-thumbs-up text-3xl "></i>
        @endif
    </button>
    <span>
        {{ $likes }} 
    </span>
</div>