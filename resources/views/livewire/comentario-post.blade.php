<div class="px-6 lg:col-span-7 col-span-full">
    <!-- Lista de comentarios -->
    <p class="text-md md:text-2xl font-semibold mb-5">Comentarios de los usuarios - {{ $blog->totalComentarios() }}</p>
     @auth
    <div class="col-span-full mb-3 lg:col-span-7">
        <textarea wire:model.defer="contenido" rows="5"
            class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 mt-2 w-full rounded-md border-2 bg-transparent p-2 outline-none placeholder:text-black focus:shadow-md dark:placeholder:text-gray-400"
            placeholder="Agrega un comentario..."></textarea>
        @error('contenido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <div class="mt-2">
            <button wire:click="comentar"
                class="bg-btn-200 dark:bg-btn-400 mt-2 rounded-md px-3 py-2 text-white transition-colors duration-150 cursor-pointer">Comentar</button>
        </div>
    </div>
    @else
    <p class="text-white mt-5 md:flex md:items-center gap-2">Recuerda 
        <a href="{{ route('login') }}" wire:navigate class="text-link-100">
        iniciar sesión
        </a> 
        para comentar este artículo.
    </p>
    @endauth
    <!-- Lista de comentarios -->
    <div class="bg-[#13233d] p-5 rounded-md">

    @foreach($comentarios ?? [] as $comentario)
    <div class="comentario mb-4">
        <!-- Contenido del comentario principal -->
        <div class="flex items-start gap-3">
            <div class="dark:bg-cont-100 mt-2 rounded-md bg-light-200 p-5 text-white w-full">
                <div class="flex gap-3">
                    <div class="text-sm font-semibold flex gap-2 items-center">
                        <img src="{{ $comentario->autor->profile?->avatar
                            ? Storage::url($comentario->autor->profile->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($comentario->autor->nombre_completo) }}"
                            alt="Foto de {{ $comentario->autor->nombre_completo }}" class="w-10 h-10 rounded-full object-cover">
                        {{ $comentario->autor->nombre_completo }}
                        <span class="text-xs text-gray-400 ml-2">{{ $comentario->created_at->diffForHumans()
                            }}</span>

                    </div>
                </div>
                <p class="text-sm mt-2 ml-10">{{ $comentario->contenido }}</p>
                <!-- Botón para mostrar textarea de respuesta -->
                <div class="flex items-center gap-3 text-lg">
                    <button @if(Auth::check()) wire:click="likeComment({{ $comentario->id }})" @else
                        onclick="alert('Debes iniciar sesión para dar like')" @endif
                        class="flex items-center gap-1 cursor-pointer mt-2 ml-10">
                        @if($comentario->isLikedBy(Auth::id()))
                        <i class="fa-solid fa-thumbs-up text-link-100"></i>
                        @else
                        <i class="fa-regular fa-thumbs-up"></i>
                        @endif
                        {{ $comentario->likes->count() }}
                    </button>
                    <div class="mt-2 flex items-center gap-2">
                        <i class="fa-solid fa-comment"></i>
                        {{$comentario->replies->count()}}
                    </div>

                </div>
                @auth
                <div class="mt-2">

                    @if($respuestaActiva === 'comentario-' . $comentario->id)

    <textarea
        wire:model="contenidoRespuesta"
        rows="2"
        class="w-full border rounded p-2 text-black dark:text-white dark:bg-gray-800 mt-2"
        placeholder="Escribe tu respuesta..."
    ></textarea>

    @error('contenidoRespuesta')
        <span class="text-red-500 text-sm">
            {{ $message }}
        </span>
    @enderror

    <div class="flex items-center gap-2 mt-2">

        <button
            wire:click="responder({{ $comentario->id }})"
            class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 text-white px-3 py-1 rounded text-sm cursor-pointer"
        >
            Responder
        </button>

        <button
            wire:click="cancelarRespuesta"
            class="text-sm text-gray-400 cursor-pointer"
        >
            Cancelar
        </button>

    </div>

@else

    <button
        wire:click="responderComentario({{ $comentario->id }})"
        class="text-sm text-link-100 mt-2 cursor-pointer"
    >
        Responder
    </button>

@endif
                </div>
                @endauth
            </div>
        </div>

        <!-- Lista de respuestas -->
        @foreach($comentario->replies ?? [] as $respuesta)
         <x-reply 
         :reply="$respuesta" :respuestaActiva="$respuestaActiva" />
        @endforeach
    </div>
    @endforeach
    </div>

   
</div>