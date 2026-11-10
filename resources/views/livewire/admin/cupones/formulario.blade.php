<div class="mx-auto max-w-5xl space-y-6 p-4">

    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $cuponId ? 'Editar cupón' : 'Crear cupón' }}
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Configura el código, el beneficio y las condiciones de uso.
            </p>
        </div>

        <a
            href="{{ route('cupon.index') }}"
            wire:navigate
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>
    </div>

    <form
        wire:submit="guardar"
        class="space-y-6 rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-7"
    >

        {{-- INFORMACIÓN GENERAL --}}
        <section class="space-y-4">

            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold text-gray-900 dark:border-gray-700 dark:text-white">
                Información del cupón
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>
                    <label for="nombre" class="mb-2 block text-sm font-medium">
                        Nombre de la promoción *
                    </label>

                    <input
                        id="nombre"
                        type="text"
                        wire:model="nombre"
                        maxlength="150"
                        required
                        placeholder="Ej. Descuento de bienvenida"
                        class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="codigo" class="mb-2 block text-sm font-medium">
                        Código promocional *
                    </label>

                    <input
                        id="codigo"
                        type="text"
                        wire:model="codigo"
                        maxlength="60"
                        required
                        spellcheck="false"
                        placeholder="BIENVENIDO10"
                        class="w-full rounded-lg border border-gray-300 bg-white p-2.5 font-mono text-sm uppercase text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('codigo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500">
                        Se guardará en mayúsculas. Puedes utilizar letras, números, guiones y guiones bajos.
                    </p>
                </div>

            </div>

            <div>
                <label for="descripcion" class="mb-2 block text-sm font-medium">
                    Descripción
                </label>

                <textarea
                    id="descripcion"
                    wire:model="descripcion"
                    rows="3"
                    placeholder="Describe las condiciones de la promoción..."
                    class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                ></textarea>

                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </section>

        {{-- BENEFICIO --}}
        <section class="space-y-4">

            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold text-gray-900 dark:border-gray-700 dark:text-white">
                Beneficio del cupón
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>
                    <label for="tipo" class="mb-2 block text-sm font-medium">
                        Tipo de descuento *
                    </label>

                    <select
                        id="tipo"
                        wire:model.live="tipo"
                        class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                        <option value="porcentaje">Porcentaje (%)</option>
                        <option value="importe_fijo">Importe fijo (MXN)</option>
                    </select>

                    @error('tipo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="valor" class="mb-2 block text-sm font-medium">
                        {{ $tipo === 'porcentaje' ? 'Porcentaje de descuento *' : 'Importe a descontar *' }}
                    </label>

                    <input
                        id="valor"
                        type="number"
                        wire:model="valor"
                        min="0.01"
                        step="0.01"
                        @if ($tipo === 'porcentaje') max="100" @endif
                        required
                        placeholder="{{ $tipo === 'porcentaje' ? '10' : '100.00' }}"
                        class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('valor')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div>
                <label for="monto_minimo_compra" class="mb-2 block text-sm font-medium">
                    Compra mínima para usar el cupón (MXN)
                </label>

                <input
                    id="monto_minimo_compra"
                    type="number"
                    wire:model="monto_minimo_compra"
                    min="0"
                    step="0.01"
                    placeholder="Ej. 500.00"
                    class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                >

                @error('monto_minimo_compra')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Si lo dejas vacío, no habrá una compra mínima. La validación se realizará sobre los artículos elegibles para el cupón, antes de aplicarlo y sin incluir el envío.
                </p>
            </div>

        </section>

        {{-- ALCANCE --}}
        <section class="space-y-4">

            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold text-gray-900 dark:text-white">
                Aplicación del cupón
            </h2>

            <div>
                <label for="alcance" class="mb-2 block text-sm font-medium">
                    ¿Dónde se puede aplicar? *
                </label>

                <select
                    id="alcance"
                    wire:model.live="alcance"
                    class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                >
                    <option value="tienda">Toda la tienda</option>
                    <option value="categoria">Categorías específicas</option>
                    <option value="articulo">Artículos específicos</option>
                </select>

                @error('alcance')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if ($alcance === 'categoria')

                <div class="space-y-3 rounded-lg border border-gray-200 p-4 dark:border-gray-700">

                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white">
                            Categorías elegibles
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Selecciona una o varias categorías para limitar el cupón.
                        </p>
                    </div>

                    <input
                        type="search"
                        wire:model.live.debounce.300ms="busquedaCategoria"
                        placeholder="Buscar categoría..."
                        class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    <div class="max-h-64 space-y-2 overflow-y-auto rounded-lg bg-gray-50 p-3 dark:bg-gray-900">

                        @forelse ($categorias as $categoria)

                            <label
                                wire:key="cupon-categoria-{{ $categoria->id }}"
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

            @if ($alcance === 'articulo')

                <div class="space-y-3 rounded-lg border border-gray-200 p-4 dark:border-gray-700">

                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white">
                            Artículos elegibles
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Por ahora puedes seleccionar productos físicos activos. En una siguiente etapa incorporaremos los recursos descargables y los cursos a esta misma selección.
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
                                wire:key="cupon-producto-{{ $producto->id }}"
                                class="flex cursor-pointer items-center gap-3 rounded-md p-2 hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                                <input
                                    type="checkbox"
                                    wire:model="productosSeleccionados"
                                    value="{{ $producto->id }}"
                                    class="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                >

                                <span class="text-sm text-gray-800 dark:text-gray-200">
                                    {{ $producto->nombre }}
                                </span>
                            </label>

                        @empty

                            <p class="p-3 text-sm text-gray-500">
                                No se encontraron productos activos.
                            </p>

                        @endforelse

                    </div>

                    <p class="text-xs text-gray-500">
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

            @if ($alcance === 'tienda')

                <div class="rounded-lg bg-purple-50 p-4 text-sm text-purple-900 dark:bg-purple-950/30 dark:text-purple-200">
                    <i class="fa-solid fa-store mr-1"></i>
                    El cupón podrá evaluarse para los artículos elegibles de toda la tienda, incluidos los tipos que incorporemos en el futuro.
                </div>

            @endif

        </section>

        {{-- LÍMITES --}}
        <section class="space-y-4">

            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold text-gray-900 dark:border-gray-700 dark:text-white">
                Límites de uso
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>
                    <label for="max_usos_global" class="mb-2 block text-sm font-medium">
                        Máximo de usos globales
                    </label>

                    <input
                        id="max_usos_global"
                        type="number"
                        wire:model="max_usos_global"
                        min="1"
                        step="1"
                        placeholder="Sin límite"
                        class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('max_usos_global')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500">
                        Máximo de veces que podrá utilizarse el cupón en toda la tienda.
                    </p>
                </div>

                <div>
                    <label for="max_usos_por_usuario" class="mb-2 block text-sm font-medium">
                        Máximo de usos por usuario
                    </label>

                    <input
                        id="max_usos_por_usuario"
                        type="number"
                        wire:model="max_usos_por_usuario"
                        min="1"
                        step="1"
                        placeholder="Sin límite"
                        class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('max_usos_por_usuario')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500">
                        Máximo de compras por usuario en las que podrá consumirse.
                    </p>
                </div>

            </div>

        </section>

        {{-- VIGENCIA --}}
        <section class="space-y-4">

            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold text-gray-900 dark:border-gray-700 dark:text-white">
                Vigencia del cupón
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>
                    <label for="fecha_inicio" class="mb-2 block text-sm font-medium">
                        Fecha de inicio
                    </label>

                    <input
                        id="fecha_inicio"
                        type="datetime-local"
                        wire:model="fecha_inicio"
                        class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('fecha_inicio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500">
                        Déjala vacía para permitir su inicio inmediato.
                    </p>
                </div>

                <div>
                    <label for="fecha_fin" class="mb-2 block text-sm font-medium">
                        Fecha de vencimiento
                    </label>

                    <input
                        id="fecha_fin"
                        type="datetime-local"
                        wire:model="fecha_fin"
                        class="w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('fecha_fin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500">
                        Déjala vacía si el cupón no tendrá vencimiento.
                    </p>
                </div>

            </div>

        </section>

        {{-- ESTADO --}}
        <section class="space-y-3">

            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold text-gray-900 dark:border-gray-700 dark:text-white">
                Estado
            </h2>

            <label class="flex cursor-pointer items-start gap-3 rounded-lg bg-gray-50 p-4 dark:bg-gray-900">

                <input
                    type="checkbox"
                    wire:model="estado"
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                >

                <span>
                    <span class="block text-sm font-medium text-gray-900 dark:text-white">
                        Cupón activado
                    </span>

                    <span class="mt-1 block text-xs text-gray-500 dark:text-gray-400">
                        Solo los cupones activados y dentro de su vigencia podrán utilizarse.
                    </span>
                </span>

            </label>

        </section>

        {{-- ACCIONES --}}
        <div class="flex flex-col-reverse justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-700 sm:flex-row">

            <a
                href="{{ route('cupon.index') }}"
                wire:navigate
                class="rounded-lg border border-gray-300 px-5 py-2.5 text-center text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700"
            >
                Cancelar
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="guardar"
                class="rounded-lg bg-purple-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-purple-800 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="guardar">
                    {{ $cuponId ? 'Guardar cambios' : 'Crear cupón' }}
                </span>

                <span wire:loading wire:target="guardar">
                    Guardando...
                </span>
            </button>

        </div>

    </form>

</div>