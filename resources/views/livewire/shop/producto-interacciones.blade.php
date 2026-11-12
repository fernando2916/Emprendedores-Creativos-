<div class="mt-12 space-y-12">

    {{-- ================================================= --}}
    {{-- RESEÑAS --}}
    {{-- ================================================= --}}

    <section id="resenas" class="border-t border-gray-200 dark:border-gray-700 pt-10">

        <div class="mb-8">
            <h2 class="text-2xl font-bold">
                Reseñas de clientes
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Conoce las opiniones y experiencias de nuestra comunidad.
            </p>
        </div>

        {{-- RESUMEN --}}
                {{-- RESUMEN DE CALIFICACIONES --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">

            {{-- PROMEDIO GENERAL --}}
            <div class="rounded-xl bg-light-200 dark:bg-cont-300 p-6 flex flex-col justify-center">

                <div class="flex items-center gap-5">

                    <div class="text-5xl font-bold tracking-tight">
                        {{ number_format($promedio, 1) }}
                    </div>

                    <div class="space-y-1">

                        <div class="flex items-center gap-1 text-yellow-400 text-lg">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($promedio >= $i)
                                    <i class="fa-solid fa-star"></i>
                                @elseif ($promedio >= ($i - 0.5))
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                @else
                                    <i class="fa-regular fa-star"></i>
                                @endif
                            @endfor
                        </div>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Basado en {{ $totalResenas }}
                            {{ $totalResenas === 1 ? 'reseña' : 'reseñas' }}
                        </p>

                    </div>

                </div>

                @if ($totalResenas > 0)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-5">
                        Calificación promedio de los clientes que han compartido
                        su experiencia con este producto.
                    </p>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-5">
                        Este producto todavía no tiene calificaciones.
                        ¡Sé el primero en compartir tu experiencia!
                    </p>
                @endif

            </div>

            {{-- DISTRIBUCIÓN DE ESTRELLAS --}}
            <div class="rounded-xl bg-light-200 dark:bg-cont-300 p-6">

                <h3 class="font-semibold mb-5">
                    Distribución de calificaciones
                </h3>

                <div class="space-y-4">

                    @foreach ($distribucion as $estrellas => $datos)

                        <div class="flex items-center gap-3 text-sm">

                            <span class="w-12 shrink-0 font-medium">
                                {{ $estrellas }}
                                <i class="fa-solid fa-star text-yellow-400"></i>
                            </span>

                            <div class="flex-1 h-2.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">

                                <div
                                    class="h-full bg-yellow-400 rounded-full transition-all duration-500"
                                    style="width: {{ $datos['porcentaje'] }}%"
                                ></div>

                            </div>

                            <span class="w-8 text-right text-gray-500 dark:text-gray-400 tabular-nums">
                                {{ $datos['cantidad'] }}
                            </span>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

        {{-- FORMULARIO DE RESEÑA --}}
        @auth

            @if (!$requiereCompraVerificada || $ordenVerificada)

                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-10">

                    <h3 class="font-bold text-lg mb-4">
                        {{ $miResena ? 'Actualiza tu reseña' : 'Comparte tu experiencia' }}
                    </h3>

                    <form wire:submit="guardarResena" class="space-y-4">

                        <div>

                            <label class="block text-sm font-medium mb-2">
                                Tu calificación
                            </label>

                            <div class="flex items-center gap-2">

                                @for ($i = 1; $i <= 5; $i++)

                                    <button
                                        type="button"
                                        wire:click="$set('calificacion', {{ $i }})"
                                        class="text-2xl transition hover:scale-110
                                            {{ $calificacion >= $i
                                                ? 'text-yellow-400'
                                                : 'text-gray-300 dark:text-gray-600' }}"
                                        aria-label="Calificar con {{ $i }} estrellas"
                                    >
                                        <i class="fa-solid fa-star"></i>
                                    </button>

                                @endfor

                                <span class="text-sm text-gray-500 ml-2">
                                    {{ $calificacion }} de 5
                                </span>

                            </div>

                            @error('calificacion')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                        </div>

                        <div>

                            <label for="comentario-resena" class="block text-sm font-medium mb-2">
                                Comentario (opcional)
                            </label>

                            <textarea
                                id="comentario-resena"
                                wire:model="comentario"
                                rows="4"
                                maxlength="3000"
                                placeholder="Cuéntanos qué te pareció el producto..."
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                                    bg-white dark:bg-cont-300 p-3
                                    focus:ring-2 focus:ring-link-100"
                            ></textarea>

                            @error('comentario')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                        </div>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="guardarResena"
                            class="px-5 py-3 rounded-md bg-btn-400 text-white cursor-pointer
                                font-semibold hover:opacity-90 disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="guardarResena">
                                {{ $miResena ? 'Actualizar reseña' : 'Publicar reseña' }}
                            </span>

                            <span wire:loading wire:target="guardarResena">
                                Guardando...
                            </span>
                        </button>

                    </form>

                </div>

            @else

                <div class="rounded-xl bg-light-200 dark:bg-cont-300 p-5 mb-10">

                    <div class="flex items-start gap-3">

                        <i class="fa-solid fa-circle-info text-link-100 text-xl mt-1"></i>

                        <div>
                            <h3 class="font-semibold">
                                ¿Quieres dejar una reseña?
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Primero debes comprar este producto y recibir tu pedido.
                                Después podrás compartir tu experiencia.
                            </p>
                        </div>

                    </div>

                </div>

            @endif

        @else

            <div class="rounded-xl bg-light-200 dark:bg-cont-300 p-5 mb-10">

                <p class="text-sm">
                    <a href="{{ route('login') }}" class="font-semibold text-link-100 hover:underline">
                        Inicia sesión
                    </a>
                    para publicar una reseña.
                </p>

            </div>

        @endauth

        {{-- LISTADO DE RESEÑAS --}}
        <div class="space-y-6">

            @forelse ($resenas as $resena)

                @php
                    $votosSi = $resena->valoraciones->where('util', true)->count();
                    $votosNo = $resena->valoraciones->where('util', false)->count();

                    $miValoracion = Auth::check()
                        ? $resena->valoraciones->firstWhere('user_id', Auth::id())
                        : null;
                @endphp

                <article
                    wire:key="producto-resena-{{ $resena->id }}"
                    class="rounded-xl bg-light-200 dark:bg-cont-300 p-5"
                >

                    {{-- AUTOR --}}
                    <div class="flex items-start justify-between gap-3 flex-wrap">

                        <x-shop.usuario-producto :usuario="$resena->user" />

                        <div class="flex flex-col items-end gap-1">

                            <span class="text-xs text-gray-500">
                                {{ $resena->created_at?->diffForHumans() }}
                            </span>

                            @if ($resena->orden_id)
                                <span class="text-xs text-green-600 dark:text-green-400">
                                    <i class="fa-solid fa-circle-check mr-1"></i>
                                    Compra verificada
                                </span>
                            @endif

                        </div>

                    </div>

                    {{-- ESTRELLAS --}}
                    <div class="flex text-yellow-400 text-sm mt-4">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $resena->calificacion >= $i
                                ? 'fa-solid fa-star'
                                : 'fa-regular fa-star' }}"></i>
                        @endfor
                    </div>

                    {{-- COMENTARIO --}}
                    @if ($resena->comentario)

                        <p class="mt-3 text-sm leading-relaxed whitespace-pre-line">
                            {{ $resena->comentario }}
                        </p>

                    @endif

                    {{-- VALORACIÓN DE LA RESEÑA --}}
                    <div class="mt-4 flex flex-wrap items-center gap-3 text-xs">

                        <span class="text-gray-300">
                            ¿Te resultó útil esta reseña?
                        </span>

                        @auth

                            <button
                                type="button"
                                wire:click="valorar('resena', {{ $resena->id }}, true)"
                                class="cursor-pointer {{ $miValoracion && $miValoracion->util
                                    ? 'text-green-600 font-bold'
                                    : 'text-gray-300 hover:text-green-600' }}"
                            >
                                <i class="fa-solid fa-thumbs-up"></i>
                                Sí ({{ $votosSi }})
                            </button>

                            <button
                                type="button"
                                wire:click="valorar('resena', {{ $resena->id }}, false)"
                                class="cursor-pointer {{ $miValoracion && !$miValoracion->util
                                    ? 'text-red-500 font-bold'
                                    : 'text-gray-300 hover:text-red-500' }}"
                            >
                                <i class="fa-solid fa-thumbs-down"></i>
                                No ({{ $votosNo }})
                            </button>

                        @else

                            <span class="text-green-600">
                                Sí ({{ $votosSi }})
                            </span>

                            <span class="text-red-500">
                                No ({{ $votosNo }})
                            </span>

                            <a href="{{ route('login') }}" class="text-link-100 hover:underline">
                                Inicia sesión para valorar
                            </a>

                        @endauth

                    </div>

                    {{-- RESPUESTAS --}}
                    @foreach ($resena->respuestas as $respuesta)

                        <x-shop.respuesta-producto
                            :respuesta="$respuesta"
                            :tipo-respuesta="$tipoRespuesta"
                            :id-respuesta="$idRespuesta"
                        />

                    @endforeach

                    {{-- RESPONDER COMO EQUIPO --}}
                    @if ($puedeResponder)

                        <div class="mt-5">

                            @if ($tipoRespuesta === 'resena' && $idRespuesta === $resena->id)

                                <form wire:submit="guardarRespuesta" class="space-y-3">

                                    <textarea
                                        wire:model="contenidoRespuesta"
                                        rows="3"
                                        maxlength="2000"
                                        placeholder="Escribe una respuesta..."
                                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                                            bg-white dark:bg-cont-200 p-3 text-sm"
                                    ></textarea>

                                    @error('contenidoRespuesta')
                                        <p class="text-sm text-red-500">{{ $message }}</p>
                                    @enderror

                                    <div class="flex gap-2">

                                        <button
                                            type="submit"
                                            class="px-4 py-2 rounded-md bg-btn-400 text-white text-sm cursor-pointer"
                                        >
                                            Publicar respuesta
                                        </button>

                                        <button
                                            type="button"
                                            wire:click="cancelarRespuesta"
                                            class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-700 text-sm cursor-pointer"
                                        >
                                            Cancelar
                                        </button>

                                    </div>

                                </form>

                            @else

                                <button
                                    type="button"
                                    wire:click="responderA('resena', {{ $resena->id }})"
                                    class="text-sm font-semibold text-link-100 hover:underline cursor-pointer"
                                >
                                    <i class="fa-solid fa-reply mr-1"></i>
                                    Responder reseña
                                </button>

                            @endif

                        </div>

                    @endif

                </article>

            @empty

                <div class="text-center py-10 text-gray-500">
                    <i class="fa-regular fa-star text-4xl mb-3"></i>
                    <p>Este producto todavía no tiene reseñas.</p>
                </div>

            @endforelse

        </div>

    </section>


    {{-- ================================================= --}}
    {{-- PREGUNTAS --}}
    {{-- ================================================= --}}

    <section id="preguntas" class="border-t border-gray-200 dark:border-gray-700 pt-10">

        <div class="mb-8">

            <h2 class="text-2xl font-bold">
                Preguntas sobre este producto
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Consulta las dudas de otros clientes o envíanos tu pregunta.
            </p>

        </div>

        {{-- FORMULARIO --}}
        @auth

            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-8">

                <form wire:submit="guardarPregunta" class="space-y-4">

                    <label for="pregunta-producto" class="block font-semibold">
                        Escribe tu pregunta
                    </label>

                    <textarea
                        id="pregunta-producto"
                        wire:model="pregunta"
                        rows="3"
                        maxlength="2000"
                        placeholder="Ej. ¿Qué material tiene este producto?"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                            bg-white dark:bg-cont-300 p-3"
                    ></textarea>

                    @error('pregunta')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="guardarPregunta"
                        class="px-5 py-3 rounded-md bg-btn-400 hover:bg-btn-600 transition text-white cursor-pointer
                            font-semibold disabled:opacity-50"
                    >
                        Publicar pregunta
                    </button>

                </form>

            </div>

        @else

            <div class="rounded-xl bg-light-200 dark:bg-cont-300 p-5 mb-8">

                <a href="{{ route('login') }}" class="font-semibold text-link-100 hover:underline">
                    Inicia sesión
                </a>

                para realizar una pregunta sobre este producto.

            </div>

        @endauth

        {{-- LISTADO --}}
        <div class="space-y-6">

            @forelse ($preguntas as $preguntaItem)

                @php
                    $votosSi = $preguntaItem->valoraciones->where('util', true)->count();
                    $votosNo = $preguntaItem->valoraciones->where('util', false)->count();

                    $miValoracion = Auth::check()
                        ? $preguntaItem->valoraciones->firstWhere('user_id', Auth::id())
                        : null;
                @endphp

                <article
                    wire:key="producto-pregunta-{{ $preguntaItem->id }}"
                    class="rounded-xl bg-light-200 dark:bg-cont-300 p-5"
                    >

                    {{-- AUTOR --}}
                    <div class="flex items-start justify-between gap-3 flex-wrap">

                        <x-shop.usuario-producto :usuario="$preguntaItem->user" />

                        <span class="text-xs text-gray-200">
                            {{ $preguntaItem->created_at?->diffForHumans() }}
                        </span>

                    </div>

                    {{-- PREGUNTA --}}
                    <div class="flex items-center gap-2 p-3">

                        <i class="fa-regular fa-circle-question text-link-100 "></i>

                        <p class="text-base">
                            {{ $preguntaItem->contenido }}
                        </p>

                    </div>

                    {{-- VALORACIÓN --}}
                    <div class="mt-4 flex flex-wrap items-center gap-3 text-xs">

                        <span class="text-gray-300">
                            ¿Te resultó útil esta pregunta?
                        </span>

                        @auth

                            <button
                                type="button"
                                wire:click="valorar('pregunta', {{ $preguntaItem->id }}, true)"
                                class=" cursor-pointer {{ $miValoracion && $miValoracion->util
                                    ? 'text-green-600 font-bold'
                                    : 'text-gray-300 hover:text-green-600' }}"
                            >
                                <i class="fa-solid fa-thumbs-up"></i>
                                Sí ({{ $votosSi }})
                            </button>

                            <button
                                type="button"
                                wire:click="valorar('pregunta', {{ $preguntaItem->id }}, false)"
                                class=" cursor-pointer {{ $miValoracion && !$miValoracion->util
                                    ? 'text-red-500 font-bold'
                                    : 'text-gray-300 hover:text-red-500' }}"
                            >
                                <i class="fa-solid fa-thumbs-down"></i>
                                No ({{ $votosNo }})
                            </button>

                        @else

                            <span class="text-green-600">
                                Sí ({{ $votosSi }})
                            </span>

                            <span class="text-red-500">
                                No ({{ $votosNo }})
                            </span>

                            <a href="{{ route('login') }}" class="text-link-100 hover:underline">
                                Inicia sesión para valorar
                            </a>

                        @endauth

                    </div>

                    {{-- RESPUESTAS --}}
                    @foreach ($preguntaItem->respuestas as $respuesta)

                        <x-shop.respuesta-producto
                            :respuesta="$respuesta"
                            :tipo-respuesta="$tipoRespuesta"
                            :id-respuesta="$idRespuesta"
                        />

                    @endforeach

                    {{-- RESPONDER COMO EQUIPO --}}
                    @if ($puedeResponder)

                        <div class="mt-5">

                            @if ($tipoRespuesta === 'pregunta' && $idRespuesta === $preguntaItem->id)

                                <form wire:submit="guardarRespuesta" class="space-y-3">

                                    <textarea
                                        wire:model="contenidoRespuesta"
                                        rows="3"
                                        maxlength="2000"
                                        placeholder="Escribe una respuesta..."
                                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                                            bg-white dark:bg-cont-200 p-3 text-sm"
                                    ></textarea>

                                    @error('contenidoRespuesta')
                                        <p class="text-sm text-red-500">{{ $message }}</p>
                                    @enderror

                                    <div class="flex gap-2">

                                        <button
                                            type="submit"
                                            class="px-4 py-2 rounded-md bg-btn-400 text-white text-sm"
                                        >
                                            Publicar respuesta
                                        </button>

                                        <button
                                            type="button"
                                            wire:click="cancelarRespuesta"
                                            class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-700 text-sm"
                                        >
                                            Cancelar
                                        </button>

                                    </div>

                                </form>

                            @else

                                <button
                                    type="button"
                                    wire:click="responderA('pregunta', {{ $preguntaItem->id }})"
                                    class="text-sm font-semibold text-link-100 hover:underline"
                                >
                                    <i class="fa-solid fa-reply mr-1"></i>
                                    Responder pregunta
                                </button>

                            @endif

                        </div>

                    @endif

                </article>

            @empty

                <div class="text-center py-10 text-gray-300">
                    <i class="fa-regular fa-comments text-4xl mb-3"></i>
                    <p>Todavía no hay preguntas sobre este producto.</p>
                </div>

            @endforelse

        </div>

    </section>

</div>