<div
    class="relative group"
    wire:poll.15s="sincronizarContador"
>

    {{-- BOTÓN DE CAMPANA --}}
    <button
        type="button"
        class="relative hover:cursor-pointer"
        aria-label="Notificaciones"

    >

        <i class="fa-solid fa-bell text-lg"></i>

        {{-- CONTADOR --}}
        <span
            x-show="$store.indicadores.notificaciones > 0"
            x-cloak
            x-text="$store.indicadores.notificaciones > 99 ? '99+' : $store.indicadores.notificaciones"
            class="absolute -top-3 -inset-e-3
            inline-flex min-w-5 h-5 px-1
            rounded-full bg-nav-500
            items-center justify-center
            text-xs font-semibold"
        ></span>

    </button>

    {{-- DESPLEGABLE --}}
    <div
    class="absolute right-0 top-full z-70 hidden w-87.5 max-w-[calc(100vw-2rem)] pt-3 group-hover:block group-focus-within:block"
    >

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-cont-200 shadow-xl dark:border-gray-700 dark:bg-nav-800">
            {{-- ENCABEZADO --}}
            <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3 dark:border-gray-700">

                <div>
                    <h3 class="font-bold">
                        Notificaciones
                    </h3>

                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Tienes
                        {{ $cantidadSinLeer }}
                        sin leer
                    </p>
                </div>

                @if ($cantidadSinLeer > 0)
                    <button
                        type="button"
                        wire:click="marcarTodasComoLeidas"
                        wire:loading.attr="disabled"
                        class="text-xs font-semibold text-link-100 hover:underline disabled:opacity-50"
                    >
                        Marcar todas como leídas
                    </button>
                @endif

            </div>

            {{-- NOTIFICACIONES --}}
            <div class="max-h-97.5 overflow-y-auto">

                @forelse ($notificaciones as $notificacion)
            
                    @php
                        $datos = $notificacion->data;
                        $sinLeer = is_null($notificacion->read_at);
                    @endphp
            
                    <article
                        wire:key="menu-notificacion-{{ $notificacion->id }}"
                        class="border-b border-gray-200 transition dark:border-gray-700
                            {{ $sinLeer
                                ? 'bg-link-100/10 dark:bg-nav-700'
                                : 'bg-cont-200 dark:bg-nav-800' }}"
                    >
            
                        {{-- TARJETA ENLAZADA --}}
                        <a wire:navigate
                            href="{{ route('notificaciones.abrir', [
                                'notification' => $notificacion->id,
                            ]) }}"
                            class="flex items-start gap-3 p-4 transition hover:bg-light-200 dark:hover:bg-nav-700"
                        >
            
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full
                                {{ $sinLeer
                                    ? 'bg-nav-500/20 text-link-100'
                                    : 'bg-light-300 text-gray-500 dark:bg-nav-600 dark:text-gray-300' }}"
                            >
                                <i class="fa-solid {{ $datos['icono'] ?? 'fa-bell' }}"></i>
                            </span>
            
                            <span class="min-w-0 flex-1">
            
                                <span class="flex items-center justify-between gap-2">
            
                                    <span class="truncate text-sm font-semibold">
                                        {{ $datos['titulo'] ?? 'Notificación' }}
                                    </span>
            
                                    @if ($sinLeer)
                                        <span class="h-2 w-2 shrink-0 rounded-full bg-nav-500"></span>
                                    @endif
            
                                </span>
            
                                <span class="mt-1 block text-xs text-gray-500 dark:text-gray-400">
                                    {{ $datos['mensaje'] ?? '' }}
                                </span>
            
                                @if (!empty($datos['numero_orden']))
                                    <span class="mt-1 block text-xs text-gray-500 dark:text-gray-400">
                                        Pedido: {{ $datos['numero_orden'] }}
                                    </span>
                                @endif
            
                                <span class="mt-2 block text-[11px] text-gray-400">
                                    {{ $notificacion->created_at?->diffForHumans() }}
                                </span>
            
                                <span class="mt-2 block text-xs font-semibold text-link-100">
                                    Ver detalles
                                    <i class="fa-solid fa-arrow-right ml-1"></i>
                                </span>
            
                            </span>
            
                        </a>
            
                        {{-- ACCIÓN INDEPENDIENTE --}}
                        @if ($sinLeer)
            
                            <div class="px-4 pb-3 pl-18">
            
                                <button
                                    type="button"
                                    wire:click="marcarComoLeida('{{ $notificacion->id }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="marcarComoLeida"
                                    class="text-xs font-semibold text-link-100 hover:underline disabled:opacity-50"
                                >
                                    <i class="fa-solid fa-check mr-1"></i>
                                    Marcar como leída
                                </button>
            
                            </div>
            
                        @else
            
                            <div class="px-4 pb-3 pl-18 text-xs text-gray-400">
                                <i class="fa-solid fa-check mr-1"></i>
                                Leída
                            </div>
            
                        @endif
            
                    </article>
            
                @empty
            
                    <div class="px-5 py-10 text-center">
            
                        <i class="fa-regular fa-bell-slash mb-3 text-3xl text-gray-400"></i>
            
                        <p class="text-sm font-semibold">
                            No tienes notificaciones
                        </p>
            
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Aquí aparecerán las novedades de tus pedidos.
                        </p>
            
                    </div>
            
                @endforelse
            
            </div>

            {{-- PIE --}}
            <a
                href="{{ route('notificaciones.index') }}"
                wire:navigate
                @click="abierto = false"
                class="flex items-center justify-center gap-2 border-t border-gray-200 bg-light-200 px-4 py-3 text-sm font-semibold text-link-100 transition hover:bg-light-300 dark:border-gray-700 dark:bg-nav-900 dark:hover:bg-nav-700"
            >
                Ver todas las notificaciones
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>

</div>
