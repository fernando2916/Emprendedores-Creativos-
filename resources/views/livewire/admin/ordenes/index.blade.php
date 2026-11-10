<div class="mx-auto max-w-7xl">

    {{-- ENCABEZADO --}}
    <div class="mb-7">

        <h1 class="text-2xl font-bold">
            Gestión de pedidos
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Consulta y administra los pedidos realizados en la tienda.
        </p>

    </div>

    {{-- FILTROS --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-light-200 p-5 dark:border-gray-700 dark:bg-cont-300">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

            {{-- BUSCADOR --}}
            <div class="relative xl:col-span-2">

                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                <input
                    type="search"
                    wire:model.live.debounce.400ms="busqueda"
                    placeholder="Número, cliente o correo..."
                    class="w-full rounded-lg border border-gray-300 bg-cont-200 py-3 pl-11 pr-4 text-sm focus:border-btn-400 focus:outline-none focus:ring-2 focus:ring-btn-400/30 dark:border-gray-700 dark:bg-cont-400"
                >

            </div>

            {{-- ESTADO --}}
            <select
                wire:model.live="estado"
                class="rounded-lg border border-gray-300 bg-cont-200 px-4 py-3 text-sm focus:border-btn-400 focus:outline-none dark:border-gray-700 dark:bg-cont-400"
            >
                <option value="todos">Todos los estados</option>
                <option value="pendiente">Pendientes</option>
                <option value="procesando">En proceso</option>
                <option value="en_preparacion">En preparación</option>
                <option value="enviado">Enviados</option>
                <option value="entregado">Entregados</option>
                <option value="completado">Completados</option>
                <option value="cancelado">Cancelados</option>
                <option value="listo_para_recoger">
                    Listo para recoger
                </option>
            </select>

            {{-- ESTADO DE PAGO --}}
            <select
                wire:model.live="estadoPago"
                class="rounded-lg border border-gray-300 bg-cont-200 px-4 py-3 text-sm focus:border-btn-400 focus:outline-none dark:border-gray-700 dark:bg-cont-400"
            >
                <option value="todos">Todos los pagos</option>
                <option value="pendiente">Pago pendiente</option>
                <option value="pagado">Pagados</option>
                <option value="cancelado">Pago cancelado</option>
            </select>

        </div>

        <div class="mt-4 flex flex-wrap items-center justify-between gap-3">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $pedidos->total() }}
                {{ $pedidos->total() === 1 ? 'pedido encontrado' : 'pedidos encontrados' }}
            </p>

            <div class="flex items-center gap-2 text-sm">

                <label for="porPagina" class="text-gray-500 dark:text-gray-400">
                    Mostrar
                </label>

                <select
                    id="porPagina"
                    wire:model.live="porPagina"
                    class="rounded-md border border-gray-300 bg-cont-200 px-2 py-1.5 dark:border-gray-700 dark:bg-cont-400"
                >
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>

            </div>

        </div>

    </div>

    {{-- TABLA --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-cont-200 shadow-sm dark:border-gray-700 dark:bg-cont-400">

        <div class="overflow-x-auto">

            <table class="w-full min-w-237.5 text-left text-sm">

                <thead class="bg-light-200 text-xs uppercase text-gray-600 dark:bg-cont-300 dark:text-gray-300">

                    <tr>
                        <th class="px-5 py-4">Pedido</th>
                        <th class="px-5 py-4">Cliente</th>
                        <th class="px-5 py-4">Fecha</th>
                        <th class="px-5 py-4">Artículos</th>
                        <th class="px-5 py-4">Total</th>
                        <th class="px-5 py-4">Estado</th>
                        <th class="px-5 py-4">Pago</th>
                        <th class="px-5 py-4 text-center">Acciones</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse ($pedidos as $orden)

                        @php
                            $estados = [
                                'pendiente' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                'procesando' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                'en_preparacion' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                                'enviado' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                'entregado' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'completado' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                'listo_para_recoger' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                            ];

                            $pagos = [
                                'pendiente' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                'pagado' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                            ];
                        @endphp

                        <tr class="transition hover:bg-light-200/60 dark:hover:bg-cont-300/60">

                            <td class="px-5 py-4">

                                <p class="font-semibold">
                                    {{ $orden->numero }}
                                </p>

                                @if ($orden->cupon_codigo)
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fa-solid fa-ticket mr-1"></i>
                                        {{ $orden->cupon_codigo }}
                                    </p>
                                @endif

                            </td>

                            <td class="px-5 py-4">

                                <p class="font-medium">
                                    {{ $orden->usuario?->nombre_completo ?? 'Cliente no disponible' }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $orden->usuario?->email }}
                                </p>

                            </td>

                            <td class="px-5 py-4 whitespace-nowrap">
                                {{ $orden->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $orden->items_count }}
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap font-bold">
                                ${{ number_format($orden->total, 2) }}
                                {{ $orden->moneda }}
                            </td>

                            <td class="px-5 py-4">

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $estados[$orden->estado] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst(str_replace('_', ' ', $orden->estado)) }}
                                </span>

                            </td>

                            <td class="px-5 py-4">

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $pagos[$orden->estado_pago] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($orden->estado_pago) }}
                                </span>

                            </td>

                            <td class="px-5 py-4 text-center">

                                <a
                                    href="{{ route('orden.show', $orden->id) }}"
                                    wire:navigate
                                    title="Ver pedido"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-light-200 text-link-100 transition hover:bg-btn-200 hover:text-white dark:bg-cont-300"
                                >
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-5 py-14 text-center">

                                <i class="fa-solid fa-box-open mb-3 text-4xl text-gray-400"></i>

                                <p class="font-semibold">
                                    No se encontraron pedidos
                                </p>

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Prueba con otro término o cambia los filtros.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($pedidos->hasPages())
            <div class="border-t border-gray-200 p-4 dark:border-gray-700">
                {{ $pedidos->links() }}
            </div>
        @endif

    </div>

</div>