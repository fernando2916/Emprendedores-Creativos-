<div class="mx-auto max-w-7xl space-y-6 p-4">

    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Cupones de descuento
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Administra códigos promocionales, vigencia y límites de uso.
            </p>
        </div>

        <a
            href="{{ route('cupon.create') }}"
            wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-md bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 px-4 py-2.5 text-sm font-medium text-white dark:hover:bg-btn-600"
        >
            <i class="fa-solid fa-plus"></i>
            Crear cupón
        </a>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-cont-200 shadow-sm dark:border-gray-700 dark:bg-cont-100">

        <div class="flex flex-col gap-3 p-4 md:flex-row">

            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>

                <input
                    type="search"
                    wire:model.live.debounce.300ms="busqueda"
                    placeholder="Buscar por nombre o código..."
                    class="border-link-100 focus:shadow-link-200 w-full rounded-md border bg-transparent p-2 outline-none placeholder:text-white focus:shadow-md dark:placeholder:text-gray-400 pl-11"
                >
            </div>

            <select
                wire:model.live="filtroEstado"
                class="border-link-100 focus:shadow-link-200 rounded-md border bg-transparent p-2 outline-none placeholder:text-white focus:shadow-md dark:placeholder:text-gray-400 pl-11"
            >
                <option value="todos">Todos los cupones</option>
                <option value="activos">Activados</option>
                <option value="inactivos">Desactivados</option>
            </select>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm  ">

                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-5 py-3">Cupón</th>
                        <th class="px-5 py-3">Beneficio</th>
                        <th class="px-5 py-3">Alcance</th>
                        <th class="px-5 py-3">Vigencia</th>
                        <th class="px-5 py-3">Estado</th>
                        <th class="px-5 py-3">Usos</th>
                        <th class="px-5 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($cupones as $cupon)

                        @php
                            $estadoVigencia = $cupon->estadoVigencia();

                            $clasesEstado = match ($estadoVigencia) {
                                'Vigente' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                'Programado' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                'Vencido' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                            };
                        @endphp

                        <tr
                            wire:key="cupon-{{ $cupon->id }}"
                            class="border-b border-gray-200 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700/40"
                        >

                            <td class="px-5 py-4">
                                <div class="font-semibold ">
                                    {{ $cupon->nombre }}
                                </div>

                                <span class="mt-1 inline-block rounded bg-purple-100 px-2 py-1 font-mono text-xs font-bold text-purple-800 dark:bg-purple-900/40 dark:text-purple-300">
                                    {{ $cupon->codigo }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                @if ($cupon->tipo === 'porcentaje')
                                    {{ number_format((float) $cupon->valor, 2) }}%
                                @else
                                    ${{ number_format((float) $cupon->valor, 2) }} MXN
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                @switch($cupon->alcance)
                                    @case('tienda')
                                        Toda la tienda
                                        @break

                                    @case('categoria')
                                        Categorías
                                        @break

                                    @case('articulo')
                                        Artículos específicos
                                        @break

                                    @default
                                        {{ $cupon->alcance }}
                                @endswitch

                                @if ($cupon->alcance !== 'tienda')
                                    <span class="text-xs text-gray-500">
                                        ({{ $cupon->objetivos_count }})
                                    </span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                <div>
                                    Inicio:
                                    {{ $cupon->fecha_inicio?->format('d/m/Y H:i') ?? 'Inmediato' }}
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    Fin:
                                    {{ $cupon->fecha_fin?->format('d/m/Y H:i') ?? 'Sin vencimiento' }}
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $clasesEstado }}">
                                    {{ $estadoVigencia }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                {{ $cupon->usos_count }}
                                @if ($cupon->max_usos_global !== null)
                                    / {{ $cupon->max_usos_global }}
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    @can('cupon edit')
                                        <a
                                            href="{{ route('cupon.edit', $cupon->id) }}"
                                            wire:navigate
                                            title="Editar cupón"
                                            class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer"
                                        >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    @endcan
                                    @can('cupon desactivar')
                                        <button
                                            type="button"
                                            title="{{ $cupon->estado ? 'Desactivar cupón' : 'Activar cupón' }}"
                                            x-on:click='
                                                Swal.fire({
                                                    title: "{{ $cupon->estado ? '¿Desactivar cupón?' : '¿Activar cupón?' }}",
                                                    text: "{{ $cupon->estado ? 'El código dejará de aceptarse en nuevas aplicaciones.' : 'El código podrá utilizarse si cumple sus condiciones.' }}",
                                                    icon: "question",
                                                    background: "#120024",
                                                    color: "#ffffff",
                                                    showCancelButton: true,
                                                    confirmButtonColor: "{{ $cupon->estado ? '#dc2626' : '#16a34a' }}",
                                                    cancelButtonColor: "#4b5563",
                                                    confirmButtonText: "{{ $cupon->estado ? 'Sí, desactivar' : 'Sí, activar' }}",
                                                    cancelButtonText: "Cancelar",
                                                    reverseButtons: true,
                                                    focusCancel: true
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $wire.cambiarEstado({{ $cupon->id }});
                                                    }
                                                })
                                            '
                                            class="text-btn-400 hover:text-btn-600 cursor-pointer text-2xl"
                                        >
                                            <i class="fa-solid {{ $cupon->estado ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    @endcan
                                    @can('cupon delete')
                                        <button
                                            type="button"
                                            title="Eliminar cupón"
                                            x-on:click='
                                                Swal.fire({
                                                    title: "¿Eliminar cupón?",
                                                    text: "No podrás recuperar este código después de eliminarlo.",
                                                    icon: "warning",
                                                    background: "#120024",
                                                    color: "#ffffff",
                                                    showCancelButton: true,
                                                    confirmButtonColor: "#dc2626",
                                                    cancelButtonColor: "#4b5563",
                                                    confirmButtonText: "Sí, eliminar",
                                                    cancelButtonText: "Cancelar",
                                                    reverseButtons: true,
                                                    focusCancel: true
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $wire.eliminar({{ $cupon->id }});
                                                    }
                                                })
                                            '
                                            class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <i class="fa-solid fa-ticket mb-3 text-3xl text-gray-400"></i>

                                <p class="font-medium text-gray-700 dark:text-gray-200">
                                    No se encontraron cupones.
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Crea un cupón para comenzar a administrar tus promociones.
                                </p>
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

        @if ($cupones->hasPages())
            <div class="border-t border-gray-200 p-4 dark:border-gray-700">
                {{ $cupones->links() }}
            </div>
        @endif

    </div>
</div>
