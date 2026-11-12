<div
    class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8"
    wire:poll.15s="sincronizarContador"
>

    {{-- ENCABEZADO --}}
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

        <div>

            <h1 class="text-3xl font-bold">
                Mis notificaciones
            </h1>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Mantente al tanto de las novedades.
            </p>

        </div>

        @if ($cantidadSinLeer > 0)

            <button
                type="button"
                wire:click="marcarTodasComoLeidas"
                wire:loading.attr="disabled"
                wire:target="marcarTodasComoLeidas"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold transition hover:bg-light-200 disabled:opacity-50 dark:border-gray-700 dark:hover:bg-cont-300"
            >
                <i class="fa-solid fa-check-double"></i>
                Marcar todas como leídas
            </button>

        @endif

    </div>

    {{-- CONTADOR --}}
    <div class="mb-5 flex items-center justify-between rounded-lg bg-light-200 p-4 dark:bg-cont-300">

        <span class="text-sm font-medium">
            Total sin leer
        </span>

        <span class="inline-flex h-8 min-w-8 items-center justify-center rounded-full bg-nav-500 px-2 text-sm font-bold text-white">
            {{ $cantidadSinLeer }}
        </span>

    </div>

    {{-- LISTADO --}}
    <div class="space-y-3">

        @forelse ($notificaciones as $notificacion)

            @php
                $datos = $notificacion->data;
                $sinLeer = is_null($notificacion->read_at);
            @endphp

            <article
                wire:key="notificacion-{{ $notificacion->id }}"
                class="overflow-hidden rounded-xl border transition
                {{ $sinLeer
                    ? 'border-link-100/40 bg-link-100/10 dark:border-nav-500/50 dark:bg-nav-700/60'
                    : 'border-gray-200 bg-cont-200 dark:border-gray-700 dark:bg-cont-400' }}"
                >

                <div class="flex items-start gap-4 p-5">

                    {{-- ICONO --}}
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full
                        {{ $sinLeer
                            ? 'bg-nav-500/20 text-link-100'
                            : 'bg-light-300 text-gray-500 dark:bg-cont-300 dark:text-gray-300' }}"
                    >
                        <i class="fa-solid {{ $datos['icono'] ?? 'fa-bell' }} text-lg"></i>
                    </span>

                    {{-- CONTENIDO ENLAZADO --}}
                    <a wire:navigate
                        href="{{ route('notificaciones.abrir', [
                            'notification' => $notificacion->id,
                        ]) }}"
                        class="min-w-0 flex-1 rounded-md transition hover:opacity-80"
                    >

                        <div class="flex flex-wrap items-center gap-2">

                            <h2 class="font-bold">
                                {{ $datos['titulo'] ?? 'Notificación' }}
                            </h2>

                            @if ($sinLeer)
                                <span class="rounded-full bg-nav-500/15 px-2.5 py-1 text-[11px] font-bold text-link-100">
                                    Sin leer
                                </span>
                            @else
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-[11px] font-medium text-gray-500 dark:bg-cont-300 dark:text-gray-400">
                                    Leída
                                </span>
                            @endif

                        </div>

                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                            {{ $datos['mensaje'] ?? '' }}
                        </p>

                        @if (!empty($datos['numero_orden']))
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Pedido: {{ $datos['numero_orden'] }}
                            </p>
                        @endif

                        <p class="mt-3 text-xs text-gray-400">
                            {{ $notificacion->created_at?->format('d/m/Y H:i') }}
                            ({{ $notificacion->created_at?->diffForHumans() }})
                        </p>

                        <span class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-link-100">
                            Ver detalles
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>

                    </a>

                    {{-- ACCIÓN PARA MARCAR COMO LEÍDA --}}
                    @if ($sinLeer)

                        <button
                            type="button"
                            wire:click="marcarComoLeida('{{ $notificacion->id }}')"
                            wire:loading.attr="disabled"
                            wire:target="marcarComoLeida"
                            title="Marcar como leída"
                            class="shrink-0 rounded-lg p-2 text-link-100 transition hover:bg-light-300 disabled:opacity-50 dark:hover:bg-cont-300"
                        >
                            <i class="fa-solid fa-check"></i>
                        </button>

                    @endif

                </div>

            </article>

        @empty

            <div class="rounded-xl border border-dashed border-gray-300 bg-cont-200 px-5 py-16 text-center dark:border-gray-700 dark:bg-cont-400">

                <i class="fa-regular fa-bell-slash mb-4 text-5xl text-gray-400"></i>

                <h2 class="text-xl font-bold">
                    No tienes notificaciones
                </h2>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Aquí aparecerán las novedades de tus pedidos,
                    preguntas, reseñas y otras actividades.
                </p>

                <a
                    href="{{ route('mis-pedidos.index') }}"
                    wire:navigate
                    class="mt-5 inline-flex items-center gap-2 font-semibold text-link-100 hover:underline"
                >
                    Consultar mis pedidos
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>

        @endforelse

    </div>

    {{-- PAGINACIÓN --}}
    @if ($notificaciones->hasPages())
        <div class="mt-7">
            {{ $notificaciones->links() }}
        </div>
    @endif

</div>
