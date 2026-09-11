<div class="ml-6 mt-3 border-l-2 border-gray-300 dark:border-gray-600 pl-4">

    {{-- Respuesta actual --}}
    <div class="bg-light-300 dark:bg-cont-300 p-4 rounded-md">

        {{-- Usuario --}}
        <div class="flex gap-3 items-center">

            <img
                src="{{ $reply->user->profile?->avatar
                    ? Storage::url($reply->user->profile->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->nombre_completo) }}"
                alt="Foto de {{ $reply->user->nombre_completo }}"
                class="w-10 h-10 rounded-full object-cover"
            >

            <div class="flex flex-col">

                <span class="text-sm font-semibold">
                    {{ $reply->user->nombre_completo }}
                </span>

                <span class="text-xs text-gray-400">
                    {{ $reply->created_at->diffForHumans() }}
                </span>

            </div>

        </div>


        {{-- Contenido --}}
        <p class="text-sm mt-3 ml-10">
            {{ $reply->contenido }}
        </p>


        {{-- Acciones --}}
        <div class="flex items-center gap-4 ml-10 mt-3">

            {{-- Like --}}
            <button
                @if(Auth::check())
                    wire:click="likeRespuesta({{ $reply->id }})"
                @else
                    onclick="alert('Debes iniciar sesión para dar like')"
                @endif
                class="flex items-center gap-1 text-sm cursor-pointer"
            >

                @if($reply->isLikedBy(Auth::id()))

                    <i class="fa-solid fa-thumbs-up text-link-100"></i>

                @else

                    <i class="fa-regular fa-thumbs-up"></i>

                @endif

                {{ $reply->likes->count() }}

            </button>


            {{-- Responder --}}
            @auth

                <button
                    wire:click="responderReply({{ $reply->id }})"
                    class="text-sm text-link-100 cursor-pointer"
                >
                    Responder
                </button>

            @endauth

        </div>


        {{-- Formulario para responder a esta respuesta --}}
        @auth

            @if($respuestaActiva === 'reply-' . $reply->id)

                <div class="ml-10 mt-3">

                    <textarea
                        wire:model="contenidoRespuesta"
                        rows="2"
                        class="w-full border rounded p-2 text-black dark:text-white dark:bg-gray-800"
                        placeholder="Escribe tu respuesta..."
                    ></textarea>

                    @error('contenidoRespuesta')
                        <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror

                    <div class="flex items-center gap-2 mt-2">

                        <button
                            wire:click="responder({{ $reply->post_comentario_id }})"
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

                </div>

            @endif

        @endauth

    </div>


    {{-- RESPUESTAS HIJAS --}}
    @if($reply->replies->count())

        <div class="mt-2">

            @foreach($reply->replies as $childReply)

                <x-reply :reply="$childReply"  :respuestaActiva="$respuestaActiva" />

            @endforeach

        </div>

    @endif

</div>