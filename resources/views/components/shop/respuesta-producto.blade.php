@props([
    'respuesta',
    'nivel' => 0,
    'tipoRespuesta',
    'idRespuesta',
])

@php
    $votosSi = $respuesta->valoraciones
        ->where('util', true)
        ->count();

    $votosNo = $respuesta->valoraciones
        ->where('util', false)
        ->count();

    $miValoracion = Auth::check()
        ? $respuesta->valoraciones->firstWhere('user_id', Auth::id())
        : null;
@endphp

<div
    wire:key="respuesta-producto-{{ $respuesta->id }}"
    class="mt-4 {{ $nivel === 0
        ? 'ml-4 sm:ml-10 border-l-2 border-link-100/60 pl-4'
        : '' }}"
>

    <div class="rounded-xl bg-light-200 dark:bg-cont-300 p-4">

        {{-- AUTOR --}}
        <div class="flex items-center justify-between gap-3 flex-wrap">

            <x-shop.usuario-producto :usuario="$respuesta->user" />

            <span class="text-xs text-gray-200">
                {{ $respuesta->created_at?->diffForHumans() }}
            </span>

        </div>

        {{-- CONTENIDO --}}
        <p class="text-sm leading-relaxed whitespace-pre-line mt-3">
            {{ $respuesta->contenido }}
        </p>

        {{-- VALORACIÓN --}}
        <div class="mt-4 flex flex-wrap items-center gap-3 text-xs">

            <span class="text-gray-300">
                ¿Te resultó útil?
            </span>

            @auth

                <button
                    type="button"
                    wire:click="valorar('respuesta', {{ $respuesta->id }}, true)"
                    wire:loading.attr="disabled"
                    class="flex items-center gap-1 transition cursor-pointer
                        {{ $miValoracion && $miValoracion->util
                            ? 'text-green-600 font-bold'
                            : 'text-gray-300 hover:text-green-600' }}"
                >
                    <i class="fa-solid fa-thumbs-up"></i>
                    Sí ({{ $votosSi }})
                </button>

                <button
                    type="button"
                    wire:click="valorar('respuesta', {{ $respuesta->id }}, false)"
                    wire:loading.attr="disabled"
                    class="flex items-center gap-1 transition cursor-pointer
                        {{ $miValoracion && !$miValoracion->util
                            ? 'text-red-500 font-bold'
                            : 'text-gray-300 hover:text-red-500' }}"
                >
                    <i class="fa-solid fa-thumbs-down"></i>
                    No ({{ $votosNo }})
                </button>

            @else

                <span class="text-green-600">
                    <i class="fa-solid fa-thumbs-up"></i>
                    Sí ({{ $votosSi }})
                </span>

                <span class="text-red-500">
                    <i class="fa-solid fa-thumbs-down"></i>
                    No ({{ $votosNo }})
                </span>

                <a
                    href="{{ route('login') }}"
                    class="text-link-100 hover:underline"
                >
                    Inicia sesión para valorar
                </a>

            @endauth

        </div>

        {{-- RESPONDER --}}
        @auth

            <div class="mt-3">

                @if ($tipoRespuesta === 'respuesta' && $idRespuesta === $respuesta->id)

                    <form wire:submit="guardarRespuesta" class="space-y-3">

                        <textarea
                            wire:model="contenidoRespuesta"
                            rows="2"
                            maxlength="2000"
                            placeholder="Escribe tu respuesta..."
                            class="w-full rounded-lg border border-gray-300
                                dark:border-gray-600 bg-white
                                dark:bg-gray-800 p-3 text-sm"
                        ></textarea>

                        @error('contenidoRespuesta')
                            <p class="text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                        <div class="flex gap-2">

                            <button
                                type="submit"
                                class="px-3 py-2 rounded-md bg-btn-400
                                    text-white text-xs font-semibold cursor-pointer"
                            >
                                Responder
                            </button>

                            <button
                                type="button"
                                wire:click="cancelarRespuesta"
                                class="px-3 py-2 rounded-md bg-gray-200
                                    dark:bg-gray-700 text-xs cursor-pointer"
                            >
                                Cancelar
                            </button>

                        </div>

                    </form>

                @else

                    <button
                        type="button"
                        wire:click="responderA('respuesta', {{ $respuesta->id }})"
                        class="text-xs font-semibold text-link-100 hover:underline cursor-pointer"
                    >
                        <i class="fa-solid fa-reply mr-1"></i>
                        Responder
                    </button>

                @endif

            </div>

        @endauth

    </div>

    {{-- RESPUESTAS ANIDADAS --}}
    @foreach ($respuesta->replies as $hija)

        <x-shop.respuesta-producto
            :respuesta="$hija"
            :nivel="$nivel + 1"
            :tipo-respuesta="$tipoRespuesta"
            :id-respuesta="$idRespuesta"
        />

    @endforeach

</div>