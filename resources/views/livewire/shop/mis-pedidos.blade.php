<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

    {{-- ENCABEZADO --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold">
            Mis compras
        </h1>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
            Consulta tus compras, revisa sus detalles y conoce su estado.
        </p>

    </div>

    {{-- BÚSQUEDA Y FILTROS --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row">

        <div class="relative flex-1">

            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

            <input
                type="search"
                wire:model.live.debounce.400ms="busqueda"
                placeholder="Buscar por número de pedido..."
                class="w-full rounded-md border border-gray-300 bg-cont-200 py-3 pl-11 pr-4 text-sm focus:border-link-500 focus:outline-none focus:ring-2 focus:ring-link-500/30 dark:border-gray-700 dark:bg-cont-400"
            >

        </div>

        <div class="sm:w-64">

            <select
                wire:model.live="estado"
                class="w-full rounded-md border border-gray-300 bg-cont-200 px-4 py-3 text-sm focus:border-link-500 focus:outline-none focus:ring-2 focus:ring-link-500/30 dark:border-gray-700 dark:bg-cont-400 "
            >
                <option value="todos">
                    Todos los pedidos
                </option>

                <option value="pendiente">
                    Pendientes
                </option>

                <option value="procesando">
                    En proceso
                </option>

                <option value="en_preparacion">
                    En preparación
                </option>

                <option value="enviado">
                    Enviados
                </option>

                <option value="entregado">
                    Entregados
                </option>

                <option value="completado">
                    Completados
                </option>

                <option value="cancelado">
                    Cancelados
                </option>

                <option value="listo_para_recoger">
                    Listos para recoger
                </option>
            </select>

        </div>

    </div>

    {{-- RESULTADOS --}}
    <div class="space-y-4">

        @forelse ($pedidos as $orden)

            @php

                $estadoLabels = [
                    'pendiente' => 'Pendiente',
                    'procesando' => 'En proceso',
                    'en_preparacion' => 'En preparación',
                    'enviado' => 'Enviado',
                    'entregado' => 'Entregado',
                    'completado' => 'Completado',
                    'cancelado' => 'Cancelado',
                    'listo_para_recoger' => 'Listo para recoger',
                ];

                $estadoClases = [
                    'pendiente' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                    'procesando' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                    'en_preparacion' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                    'enviado' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                    'entregado' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                    'completado' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                    'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                    'listo_para_recoger' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                ];

            @endphp

            <article
                wire:key="pedido-{{ $orden->id }}"
                class="overflow-hidden rounded-md border border-gray-200 bg-cont-200 dark:border-gray-700 dark:bg-cont-400"
            >

                {{-- CABECERA DEL PEDIDO --}}
                <div class="flex flex-col justify-between gap-4 border-b border-gray-200 p-5 dark:border-gray-700 sm:flex-row sm:items-center">

                    <div class="space-y-2">

                        <div class="flex flex-wrap items-center gap-3">

                            <h2 class="font-bold">
                                {{ $orden->numero }}
                            </h2>

                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $estadoClases[$orden->estado] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200' }}">
                                {{ $estadoLabels[$orden->estado] ?? ucfirst(str_replace('_', ' ', $orden->estado)) }}
                            </span>

                        </div>

                        <p class="text-sm text-slate-800 dark:text-slate-400 font-semibold">
                            <i class="fa-regular fa-calendar mr-1"></i>
                            {{ $orden->created_at?->format('d/m/Y') }}
                        </p>

                    </div>

                    <div class="sm:text-right">

                        <p class="text-xs text-slate-800 dark:text-slate-400 font-semibold">
                            Total del pedido
                        </p>

                        <p class="text-xl font-bold text-link-100">
                            ${{ number_format($orden->total, 2) }}
                            {{ $orden->moneda }}
                        </p>

                    </div>

                </div>

                {{-- INFORMACIÓN --}}
                <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-3">

                    <div>

                        <p class="text-xs text-slate-800 dark:text-slate-400 font-semibold">
                            Artículos
                        </p>

                        <p class="mt-1 font-medium">
                            {{ $orden->items_count }}
                            {{ $orden->items_count === 1 ? 'artículo' : 'artículos' }}
                        </p>

                    </div>

                    <div>

                        <p class="text-xs text-slate-800 dark:text-slate-400 font-semibold">
                            Entrega
                        </p>

                        <p class="mt-1 font-medium">
                            @if ($orden->tipo_entrega === 'recoger_tienda')
                                <i class="fa-solid fa-store mr-1 text-link-100"></i>
                                Recoger en tienda
                            @else
                                <i class="fa-solid fa-truck mr-1 text-link-100"></i>
                                Envío a domicilio
                            @endif
                        </p>

                    </div>

                    <div>

                        <p class="text-xs text-slate-800 dark:text-slate-400 font-semibold">
                            Estado del pago
                        </p>

                        <p class="mt-1 font-medium">
                            {{ ucfirst(str_replace('_', ' ', $orden->estado_pago)) }}
                        </p>

                    </div>

                </div>

                {{-- ACCIONES --}}
                <div class="flex flex-col justify-between gap-3 border-t border-gray-200 bg-light-200 p-4 dark:border-gray-700 dark:bg-cont-300 sm:flex-row sm:items-center">

                    @if ($orden->cupon_codigo)
                        <p class="text-xs">
                            <i class="fa-solid fa-ticket mr-1"></i>
                            Cupón utilizado: {{ $orden->cupon_codigo }}
                        </p>
                    @else
                        <span></span>
                    @endif

                    <a
                        href="{{ route('pedido.confirmacion', ['orden' => $orden->id]) }}"
                        wire:navigate
                        class="inline-flex items-center justify-center gap-2 rounded-md bg-btn-200 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600"
                    >
                        Ver detalles
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

            </article>

        @empty

            <div class="rounded-xl border border-dashed border-gray-300 bg-cont-200 px-5 py-14 text-center dark:border-gray-700 dark:bg-cont-400">

                <div class="mb-4 text-5xl text-gray-400">
                    <i class="fa-solid fa-box-open"></i>
                </div>

                <h2 class="text-xl font-bold">
                    No encontramos pedidos
                </h2>

                <p class="mt-2 text-sm text-slate-800 dark:text-slate-400 font-semibold">
                    @if ($busqueda !== '' || $estado !== 'todos')
                        No hay pedidos que coincidan con tu búsqueda o filtro.
                    @else
                        Todavía no has realizado ninguna compra.
                    @endif
                </p>

                @if ($busqueda !== '' || $estado !== 'todos')

                    <button
                        type="button"
                        wire:click="$set('busqueda', ''); $set('estado', 'todos')"
                        class="mt-5 font-semibold text-link-100 hover:underline"
                    >
                        Limpiar filtros
                    </button>

                @else

                    <a
                        href="{{ route('tienda.index') }}"
                        wire:navigate
                        class="mt-5 inline-flex items-center gap-2 rounded-lg bg-btn-200 px-5 py-3 font-semibold text-white hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600"
                    >
                        <i class="fa-solid fa-store"></i>
                        Explorar tienda
                    </a>

                @endif

            </div>

        @endforelse

    </div>

    {{-- PAGINACIÓN --}}
    @if ($pedidos->hasPages())

        <div class="mt-8">
            {{ $pedidos->links() }}
        </div>

    @endif

</div>