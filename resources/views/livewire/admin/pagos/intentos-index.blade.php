<div class="mx-auto max-w-7xl">

    {{-- ENCABEZADO --}}
    <div class="mb-7">
        <h1 class="text-2xl font-bold">
            Historial de pagos
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Consulta los intentos de compra y el estado de sus operaciones de pago.
        </p>
    </div>

    {{-- RESUMEN --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">

        @foreach ([
            ['label' => 'Total de intentos', 'value' => $resumen['total'], 'icon' => 'fa-receipt'],
            ['label' => 'Pendientes', 'value' => $resumen['pendientes'], 'icon' => 'fa-clock'],
            ['label' => 'Procesando', 'value' => $resumen['procesando'], 'icon' => 'fa-spinner'],
            ['label' => 'Aprobados', 'value' => $resumen['aprobados'], 'icon' => 'fa-circle-check'],
            ['label' => 'No completados', 'value' => $resumen['fallidos'], 'icon' => 'fa-circle-xmark'],
        ] as $tarjeta)

            <div class="rounded-xl border border-gray-200 bg-light-200 p-4 dark:border-gray-700 dark:bg-cont-300">

                <div class="flex items-center justify-between gap-3">

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $tarjeta['label'] }}
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums">
                            {{ number_format($tarjeta['value']) }}
                        </p>
                    </div>

                    <i class="fa-solid {{ $tarjeta['icon'] }} text-xl text-link-100"></i>

                </div>

            </div>

        @endforeach

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
                    placeholder="Referencia, ID de Mercado Pago, cliente o pedido..."
                    class="w-full rounded-lg border border-gray-300 bg-cont-200 py-3 pl-11 pr-4 text-sm focus:border-btn-400 focus:outline-none focus:ring-2 focus:ring-btn-400/30 dark:border-gray-700 dark:bg-cont-400"
                >

            </div>

            {{-- ESTADO --}}
            <select
                wire:model.live="estado"
                class="rounded-lg border border-gray-300 bg-cont-200 px-4 py-3 text-sm dark:border-gray-700 dark:bg-cont-400"
            >
                <option value="todos">Todos los estados</option>
                <option value="pendiente">Pendientes</option>
                <option value="procesando">Procesando</option>
                <option value="aprobado">Aprobados</option>
                <option value="rechazado">Rechazados</option>
                <option value="cancelado">Cancelados</option>
                <option value="expirado">Expirados</option>
            </select>

            {{-- MÉTODO DE PAGO --}}
            <select
                wire:model.live="metodoPago"
                class="rounded-lg border border-gray-300 bg-cont-200 px-4 py-3 text-sm dark:border-gray-700 dark:bg-cont-400"
            >
                <option value="todos">Todos los métodos</option>
                <option value="mercado_pago">Mercado Pago</option>
                <option value="efectivo">Efectivo</option>
                <option value="transferencia">Transferencia</option>
            </select>

        </div>

        <div class="mt-4 flex flex-wrap items-center justify-between gap-3">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $intentos->total() }}
                {{ $intentos->total() === 1 ? 'intento encontrado' : 'intentos encontrados' }}
            </p>

            <div class="flex items-center gap-2 text-sm">

                <label for="porPagina" class="text-gray-500 dark:text-gray-400">
                    Mostrar
                </label>

                <select
                    id="porPagina"
                    wire:model.live.number="porPagina"
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

            <table class="w-full min-w-[1100px] text-left text-sm">

                <thead class="bg-light-200 text-xs uppercase text-gray-600 dark:bg-cont-300 dark:text-gray-300">
                    <tr>
                        <th class="px-5 py-4">Referencia</th>
                        <th class="px-5 py-4">Cliente</th>
                        <th class="px-5 py-4">Fecha</th>
                        <th class="px-5 py-4">Método</th>
                        <th class="px-5 py-4">Total</th>
                        <th class="px-5 py-4">Estado</th>
                        <th class="px-5 py-4">Pedido</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse ($intentos as $intento)

                        @php
                            $estados = [
                                'pendiente' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                'procesando' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                'aprobado' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'rechazado' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                'cancelado' => 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                'expirado' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
                            ];
                        @endphp

                        <tr class="transition hover:bg-light-200/60 dark:hover:bg-cont-300/60">

                            <td class="px-5 py-4">
                                <p class="font-semibold">
                                    #{{ $intento->id }}
                                </p>

                                <p class="mt-1 max-w-[220px] truncate text-xs text-gray-500 dark:text-gray-400"
                                   title="{{ $intento->referencia_externa }}">
                                    {{ $intento->referencia_externa }}
                                </p>

                                @if ($intento->mercadopago_order_id)
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        MP: {{ $intento->mercadopago_order_id }}
                                    </p>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-medium">
                                    {{ $intento->usuario?->nombre_completo ?? 'Cliente no disponible' }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $intento->usuario?->email ?? 'Sin correo' }}
                                </p>
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap">
                                {{ $intento->created_at?->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-5 py-4">
                                @if ($intento->metodo_pago === 'mercado_pago')
                                    <span class="inline-flex items-center gap-2">
                                        <i class="fa-solid fa-credit-card text-link-100"></i>
                                        Mercado Pago
                                    </span>
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $intento->metodo_pago)) }}
                                @endif
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap font-semibold">
                                ${{ number_format((float) $intento->total, 2) }}
                                {{ $intento->moneda }}
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $estados[$intento->estado] ?? 'bg-gray-200 text-gray-700' }}">
                                    {{ ucfirst($intento->estado) }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                @if ($intento->orden)
                                    <a
                                        wire:navigate
                                        href="{{ route('orden.show', $intento->orden_id) }}"
                                        class="font-semibold text-link-100 hover:underline"
                                    >
                                        {{ $intento->orden->numero }}
                                    </a>
                                @else
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        Sin pedido
                                    </span>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">

                                <i class="fa-solid fa-receipt mb-3 text-3xl text-gray-400"></i>

                                <p class="font-semibold">
                                    No se encontraron intentos de pago.
                                </p>

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Prueba modificando los filtros de búsqueda.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($intentos->hasPages())
            <div class="border-t border-gray-200 p-4 dark:border-gray-700">
                {{ $intentos->links() }}
            </div>
        @endif

    </div>

</div>