<div class="mx-auto max-w-7xl space-y-6 p-4">

    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold ">
                Zonas de envío
            </h1>

            <p class="mt-1 text-sm ">
                Configura las tarifas, la cobertura postal y las promociones de envío gratis.
            </p>
        </div>

        <a
            href="{{ route('zona-envio.create') }}"
            wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-md bg-btn-200 px-4 py-2.5 text-sm font-medium text-white hover:bg-btn-400 transition-all dark:bg-btn-400 dark:hover:bg-btn-600"
        >
            <i class="fa-solid fa-plus"></i>
            Crear zona
        </a>
    </div>

    <div class="overflow-hidden rounded-md border border-gray-200 bg-cont-200 shadow-sm dark:border-gray-700 dark:bg-cont-100">

        <div class="flex flex-col gap-3 p-4 md:flex-row">

            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-5 -translate-y-1/2 "></i>

                <input
                    type="search"
                    wire:model.live.debounce.300ms="busqueda"
                    placeholder="Buscar por nombre o descripción..."
                    class="border-link-100 focus:shadow-link-200 w-full rounded-md border bg-transparent p-2 outline-none placeholder:text-white focus:shadow-md dark:placeholder:text-gray-400 pl-11"
                >
            </div>

            <select
                wire:model.live="filtroEstado"
                class="pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
            >
                <option value="todas">Todas las zonas</option>
                <option value="activas">Activas</option>
                <option value="inactivas">Inactivas</option>
            </select>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm ">

                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-5 py-3">Zona</th>
                        <th class="px-5 py-3">Tarifa</th>
                        <th class="px-5 py-3">Envío gratis desde</th>
                        <th class="px-5 py-3">Cobertura</th>
                        <th class="px-5 py-3">Estado</th>
                        <th class="px-5 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($zonas as $zona)

                        <tr
                            wire:key="zona-envio-{{ $zona->id }}"
                            class="border-b border-gray-200 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700/40"
                        >

                            <td class="px-5 py-4">
                                <div class="font-semibold text-gray-900 dark:text-white">
                                    {{ $zona->nombre }}
                                </div>

                                <div class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                    {{ $zona->descripcion ?: 'Sin descripción' }}
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 font-medium">
                                ${{ number_format((float) $zona->tarifa, 2) }} MXN
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                @if ($zona->monto_minimo_envio_gratis !== null)
                                    ${{ number_format((float) $zona->monto_minimo_envio_gratis, 2) }} MXN
                                @else
                                    <span class="text-gray-400">
                                        Sin promoción
                                    </span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                <span class="font-semibold">
                                    {{ $zona->codigos_postales_count }}
                                </span>
                                códigos postales
                            </td>

                            <td class="px-5 py-4">
                                @if ($zona->activa)
                                    <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Activa
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                        Inactiva
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    @can('zona edit')
                                    <a
                                        href="{{ route('zona-envio.edit', $zona->id) }}"
                                        wire:navigate
                                        title="Editar zona"
                                        class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @endcan
                                    @can('zona desactivar')
                                    <button
                                        type="button"
                                        title="{{ $zona->activa ? 'Desactivar zona' : 'Activar zona' }}"
                                        x-on:click='
                                            Swal.fire({
                                                title: "{{ $zona->activa ? '¿Desactivar zona?' : '¿Activar zona?' }}",
                                                text: "{{ $zona->activa ? 'Sus códigos postales dejarán de tener cobertura mediante esta zona.' : 'La zona volverá a ofrecer cobertura para sus códigos postales.' }}",
                                                icon: "question",
                                                background: "#120024",
                                                color: "#ffffff",
                                                showCancelButton: true,
                                                confirmButtonColor: "{{ $zona->activa ? '#dc2626' : '#16a34a' }}",
                                                cancelButtonColor: "#4b5563",
                                                confirmButtonText: "{{ $zona->activa ? 'Sí, desactivar' : 'Sí, activar' }}",
                                                cancelButtonText: "Cancelar",
                                                reverseButtons: true,
                                                focusCancel: true
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $wire.cambiarEstado({{ $zona->id }});
                                                }
                                            })
                                        '
                                        class="text-btn-400 hover:text-btn-600 cursor-pointer text-2xl"
                                        >
                                        <i class="fa-solid {{ $zona->activa ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    </button>
                                    @endcan

                                    @can('zona delete')
                                        <button
                                            type="button"
                                            title="Eliminar zona"
                                            x-on:click='
                                                Swal.fire({
                                                    title: "¿Eliminar zona?",
                                                    text: "La zona y sus códigos postales asociados serán eliminados.",
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
                                                        $wire.eliminar({{ $zona->id }});
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
                            <td colspan="6" class="px-5 py-12 text-center">
                                <i class="fa-solid fa-truck-fast mb-3 text-3xl "></i>

                                <p class="font-medium ">
                                    No se encontraron zonas de envío.
                                </p>

                                <p class="mt-1 text-sm ">
                                    Crea una zona para comenzar a configurar la cobertura de tu tienda.
                                </p>
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

        @if ($zonas->hasPages())
            <div class="border-t border-gray-200 p-4 dark:border-gray-700">
                {{ $zonas->links() }}
            </div>
        @endif

    </div>
</div>
