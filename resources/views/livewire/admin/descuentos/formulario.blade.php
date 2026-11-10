<div class="mx-auto max-w-5xl space-y-6 p-4">

    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold ">
                {{ $descuento ? 'Editar descuento' : 'Crear descuento' }}
            </h1>

            <p class="mt-1 text-sm ">
                Configura el tipo, el alcance y la vigencia de la promoción.
            </p>
        </div>

        <a href="{{ route('descuento.index') }}"
           wire:navigate
           class="inline-flex items-center gap-2 rounded-md border border-link-300 px-4 py-2 text-sm font-medium  dark:border-link-600 ">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>
    </div>

    <form wire:submit="guardar"
          class="space-y-6 rounded-lg border border-gray-200 bg-cont-200 p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-7">

        {{-- Información general --}}
        <section class="space-y-4">
            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold  dark:border-gray-700 ">
                Información general
            </h2>

            <div>
                <label for="nombre" class="mb-2 block text-sm font-medium ">
                    Nombre de la promoción
                </label>

                <input
                    id="nombre"
                    type="text"
                    wire:model="nombre"
                    maxlength="150"
                    placeholder="Ej. Promoción de temporada"
                    class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                >

                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descripcion" class="mb-2 block text-sm font-medium ">
                    Descripción
                </label>

                <textarea
                    id="descripcion"
                    wire:model="descripcion"
                    rows="3"
                    placeholder="Describe brevemente la promoción..."
                    class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                ></textarea>

                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </section>

        {{-- Tipo y valor --}}
        <section class="space-y-4">
            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold  dark:border-gray-700 ">
                Tipo de descuento
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="tipo" class="mb-2 block text-sm font-medium ">
                        Tipo
                    </label>

                    <select
                        id="tipo"
                        wire:model.live="tipo"
                        class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >
                        <option value="porcentaje">Porcentaje (%)</option>
                        <option value="importe_fijo">Importe fijo a descontar ($)</option>
                        <option value="precio_fijo">Precio final fijo ($)</option>
                    </select>

                    @error('tipo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="valor" class="mb-2 block text-sm font-medium ">
                        {{ $tipo === 'porcentaje' ? 'Porcentaje' : ($tipo === 'importe_fijo' ? 'Importe a descontar' : 'Precio final') }}
                    </label>

                    <input
                        id="valor"
                        type="number"
                        wire:model="valor"
                        min="0.01"
                        step="0.01"
                        @if ($tipo === 'porcentaje') max="100" @endif
                        placeholder="{{ $tipo === 'porcentaje' ? '15' : '100.00' }}"
                        class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('valor')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs ">
                        @if ($tipo === 'porcentaje')
                            Ingresa un porcentaje mayor que 0 y hasta 100.
                        @elseif ($tipo === 'importe_fijo')
                            Esta cantidad se restará al precio original.
                        @else
                            Este será el precio final, siempre que no supere el precio original.
                        @endif
                    </p>
                </div>
            </div>
        </section>

        {{-- Alcance --}}
        <section class="space-y-4">
            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold  dark:border-gray-700 ">
                Aplicación de la promoción
            </h2>

            <div>
                <label for="alcance" class="mb-2 block text-sm font-medium ">
                    ¿A qué se aplicará?
                </label>

                <select
                    id="alcance"
                    wire:model.live="alcance"
                    class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                >
                    <option value="tienda">Toda la tienda</option>
                    <option value="categoria">Categorías específicas</option>
                    <option value="producto">Productos específicos</option>
                </select>

                @error('alcance')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if ($alcance === 'categoria')
                <div class="space-y-3 rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                    <div>
                        <h3 class="font-medium ">
                            Selecciona las categorías
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            La promoción se aplicará a los productos que pertenezcan a las categorías seleccionadas.
                        </p>
                    </div>

                    <input
                        type="search"
                        wire:model.live.debounce.300ms="busquedaCategoria"
                        placeholder="Buscar categoría..."
                        class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    <div class="max-h-64 space-y-2 overflow-y-auto rounded-lg bg-gray-50 p-3 dark:bg-gray-900">
                        @forelse ($categorias as $categoria)
                            <label
                                wire:key="categoria-descuento-{{ $categoria->id }}"
                                class="flex cursor-pointer items-center gap-3 rounded-md p-2 hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                                <input
                                    type="checkbox"
                                    wire:model="categoriasSeleccionadas"
                                    value="{{ $categoria->id }}"
                                    class="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                >

                                <span class="text-sm text-gray-800 dark:text-gray-200">
                                    {{ $categoria->nombre }}
                                </span>
                            </label>
                        @empty
                            <p class="p-3 text-sm text-gray-500">
                                No se encontraron categorías.
                            </p>
                        @endforelse
                    </div>

                    <p class="text-xs text-gray-500">
                        Seleccionadas: {{ count($categoriasSeleccionadas) }}
                    </p>

                    @error('categoriasSeleccionadas')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @error('categoriasSeleccionadas.*')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            @if ($alcance === 'producto')
                <div class="space-y-3 rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white">
                            Selecciona los productos
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Solo se muestran los productos que están activos en el catálogo.
                        </p>
                    </div>

                    <input
                        type="search"
                        wire:model.live.debounce.300ms="busquedaProducto"
                        placeholder="Buscar producto..."
                        class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    <div class="max-h-64 space-y-2 overflow-y-auto rounded-lg bg-gray-50 p-3 dark:bg-gray-900">
                        @forelse ($productos as $producto)
                            <label
                                wire:key="producto-descuento-{{ $producto->id }}"
                                class="flex cursor-pointer items-center gap-3 rounded-md p-2 hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                                <input
                                    type="checkbox"
                                    wire:model="productosSeleccionados"
                                    value="{{ $producto->id }}"
                                    class="h-4 w-4 rounded border-gray-300 text-btn-600 focus:ring-btn-600"
                                >

                                <span class="text-sm ">
                                    {{ $producto->nombre }}
                                </span>
                            </label>
                        @empty
                            <p class="p-3 text-sm ">
                                No se encontraron productos activos.
                            </p>
                        @endforelse
                    </div>

                    <p class="text-xs ">
                        Seleccionados: {{ count($productosSeleccionados) }}
                    </p>

                    @error('productosSeleccionados')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @error('productosSeleccionados.*')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif
        </section>

        {{-- Fechas y estado --}}
        <section class="space-y-4">
            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold  dark:border-gray-700 ">
                Vigencia
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="fecha_inicio" class="mb-2 block text-sm font-medium ">
                        Fecha de inicio (opcional)
                    </label>

                    <input
                        id="fecha_inicio"
                        type="datetime-local"
                        wire:model="fecha_inicio"
                        class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('fecha_inicio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs ">
                        Si no indicas una fecha, podrá comenzar inmediatamente.
                    </p>
                </div>

                <div>
                    <label for="fecha_fin" class="mb-2 block text-sm font-medium ">
                        Fecha de finalización
                    </label>

                    <input
                        id="fecha_fin"
                        type="datetime-local"
                        wire:model="fecha_fin"
                        required
                        class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('fecha_fin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <label class="flex cursor-pointer items-start gap-3 rounded-lg bg-cont-100 p-4 dark:bg-gray-900">
                <input
                    type="checkbox"
                    wire:model="estado"
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-btn-600 focus:ring-btn-600"
                >

                <span>
                    <span class="block text-sm font-medium ">
                        Descuento activado
                    </span>

                    <span class="mt-1 block text-xs ">
                        Si lo desactivas, la promoción no se aplicará aunque esté dentro de sus fechas.
                    </span>
                </span>
            </label>
        </section>

        <div class="flex flex-col-reverse justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-700 sm:flex-row">
            <a
                href="{{ route('descuento.index') }}"
                wire:navigate
                class="rounded-md border border-gray-300 px-5 py-2.5 text-center text-sm font-medium text-gray-700 hover:bg-gray-100 cursor-pointer dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700"
            >
                Cancelar
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="guardar"
                class="rounded-md bg-btn-200 px-5 py-2.5 text-sm font-medium text-white hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-all disabled:cursor-not-allowed disabled:opacity-60 cursor-pointer"
            >
                <span wire:loading.remove wire:target="guardar">
                    {{ $descuento ? 'Guardar cambios' : 'Crear descuento' }}
                </span>

                <span wire:loading wire:target="guardar">
                    Guardando...
                </span>
            </button>
        </div>
    </form>
</div>
