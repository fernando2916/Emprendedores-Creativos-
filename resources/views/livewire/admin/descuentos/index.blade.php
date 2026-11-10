<div class="mx-auto max-w-7xl space-y-6 p-4">

    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold ">
                Descuentos
            </h1>

            <p class="mt-1 text-sm ">
                Administra las promociones de tu tienda.
            </p>
        </div>

        <a href="{{ route('descuento.create') }}"
           wire:navigate
           class="inline-flex items-center justify-center gap-2 rounded-md bg-btn-200 px-4 py-2.5 text-sm font-medium text-white hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-all">
            <i class="fa-solid fa-plus"></i>
            Crear descuento
        </a>
    </div>

    <div class="relative overflow-hidden rounded-lg border border-gray-200 bg-cont-200 shadow-sm dark:border-gray-700 dark:bg-cont-100">

        <div class="flex flex-col gap-3 p-4 md:flex-row">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>

                <input
                    type="search"
                    wire:model.live.debounce.300ms="busqueda"
                    placeholder="Buscar descuento por nombre..."
                    class="border-link-100 focus:shadow-link-200 w-full rounded-md border bg-transparent p-2 outline-none placeholder:text-white focus:shadow-md dark:placeholder:text-gray-400 pl-11"
                >
            </div>

            <select
                wire:model.live="filtroEstado"
                class="pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
            >
                <option value="todos">Todos los descuentos</option>
                <option value="activos">Activados</option>
                <option value="inactivos">Desactivados</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm ">
                <thead class="bg-cont-300 text-xs uppercase  dark:bg-gray-700 ">
                    <tr>
                        <th class="px-5 py-3">Descuento</th>
                        <th class="px-5 py-3">Tipo y valor</th>
                        <th class="px-5 py-3">Aplicación</th>
                        <th class="px-5 py-3">Vigencia</th>
                        <th class="px-5 py-3">Estado</th>
                        <th class="px-5 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($descuentos as $descuento)
                        @php
                            $tipoLabel = match ($descuento->tipo) {
                                'porcentaje' => 'Porcentaje',
                                'importe_fijo' => 'Importe fijo',
                                'precio_fijo' => 'Precio final fijo',
                                default => $descuento->tipo,
                            };

                            $alcanceLabel = match ($descuento->alcance) {
                                'tienda' => 'Toda la tienda',
                                'categoria' => 'Categorías (' . $descuento->categorias_count . ')',
                                'producto' => 'Productos (' . $descuento->productos_count . ')',
                                default => $descuento->alcance,
                            };

                            $estadoVigencia = $descuento->estadoVigencia();

                            $estadoClases = match ($estadoVigencia) {
                                'Vigente' => 'bg-green-100 dark:bg-green-900 ',
                                'Programado' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                'Vencido' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                            };
                        @endphp

                        <tr wire:key="descuento-{{ $descuento->id }}"
                            class="border-b border-gray-200 ">

                            <td class="px-5 py-4">
                                <div class="font-semibold ">
                                    {{ $descuento->nombre }}
                                </div>

                                <div class="mt-1 max-w-xs truncate text-xs ">
                                    {{ $descuento->descripcion ?: 'Sin descripción' }}
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <div>{{ $tipoLabel }}</div>

                                <div class="mt-1 font-semibold ">
                                    @if ($descuento->tipo === 'porcentaje')
                                        {{ number_format((float) $descuento->valor, 2) }}%
                                    @elseif ($descuento->tipo === 'importe_fijo')
                                        ${{ number_format((float) $descuento->valor, 2) }} menos
                                    @else
                                        Precio: ${{ number_format((float) $descuento->valor, 2) }}
                                    @endif
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                {{ $alcanceLabel }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                <div>
                                    Inicio:
                                    {{ $descuento->fecha_inicio?->format('d/m/Y H:i') ?? 'Inmediato' }}
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    Fin: {{ $descuento->fecha_fin?->format('d/m/Y H:i') ?? '—' }}
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $estadoClases }}">
                                    {{ $estadoVigencia }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    @can('descuento edit')                                        
                                        <a
                                            href="{{ route('descuento.edit', $descuento) }}"
                                            wire:navigate
                                            title="Editar descuento"
                                            class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer"
                                        >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    @endcan
                                    @can('descuento desactivar')
                                        <button 
                                            type="button"  
                                            title="{{ $descuento->estado ? 'Desactivar descuento' : 'Activar descuento' }}" 
                                            x-on:click=' 
                                                Swal.fire({ 
                                                title: "{{ $descuento->estado ? '¿Desactivar descuento?' : '¿Activar descuento?' }}", 
                                                text: "{{ $descuento->estado ? 'La promoción dejará de aplicarse en la tienda.' : 'La promoción podrá aplicarse cuando esté dentro de su vigencia.' }}", 
                                                icon: "{{ $descuento->estado ? 'warning' : 'question' }}", background: "#120024", 
                                                color: "#ffffff", 
                                                showCancelButton: true, 
                                                confirmButtonColor: "{{ $descuento->estado ? '#dc2626' : '#16a34a' }}", 
                                                cancelButtonColor: "#4b5563", 
                                                confirmButtonText: "{{ $descuento->estado ? 'Sí, desactivar' : 'Sí, activar' }}", 
                                                cancelButtonText: "Cancelar", 
                                                reverseButtons: true, focusCancel: true }).then((result) => { if (result.isConfirmed) { $wire.cambiarEstado({{ $descuento->id }}); } }) ' 
                                                class="text-btn-400 hover:text-btn-600 cursor-pointer text-2xl" > <i class="fa-solid {{ $descuento->estado ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i> </button>
                                    @endcan
                                    @can('descuento delete')
                                        <button 
                                            type="button" 
                                            title="Eliminar descuento" 
                                            x-on:click.prevent="
                                                    Swal.fire({
                                                        title: '¿Eliminar descuento?',
                                                        text: 'Esta acción no se puede deshacer. El descuento será eliminado permanentemente.',
                                                        icon: 'warning',
                                                        background: '#120024',
                                                        color: '#ffffff',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#dc2626',
                                                        cancelButtonColor: '#4b5563',
                                                        confirmButtonText: 'Sí, eliminar',
                                                        cancelButtonText: 'Cancelar',
                                                        reverseButtons: true,
                                                        focusCancel: true
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            $wire.eliminar({{ (int) $descuento->id }});
                                                        }
                                                    })
                                                    "
                                                class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer" > 
                                                    <i class="fa-solid fa-trash"></i> 
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <i class="fa-solid fa-tags mb-3 text-3xl "></i>

                                <p class="font-medium ">
                                    No se encontraron descuentos.
                                </p>

                                <p class="mt-1 text-sm ">
                                    Prueba con otra búsqueda o registra una nueva promoción.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($descuentos->hasPages())
            <div class="border-t border-gray-200 p-4 dark:border-gray-700">
                {{ $descuentos->links() }}
            </div>
        @endif
    </div>
</div>
