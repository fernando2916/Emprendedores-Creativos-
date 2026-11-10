<div>
    {{-- RESULTADOS --}}
    <div class="flex items-center justify-between mb-5">

        <div>
            <h1 class="text-xl sm:text-2xl font-bold ">
                Productos
            </h1>

            <p class="text-sm  mt-1">
                Encuentra el producto que estás buscando
            </p>
        </div>

        <span class="text-sm font-semibold">
            {{ $productos->total() }} productos
        </span>

    </div>

    {{-- ========================================================= --}}
        {{-- HEADER / BUSCADOR --}}
        {{-- ========================================================= --}}

        <div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 mb-10">

                <div class="flex items-end gap-4 lg:flex-row lg:justify-between">

                    {{-- Buscador --}}
                    <div class="w-full lg:max-w-3xl">

                        <div class="relative">

                            <input 
                                type="text" 
                                wire:model.live.debounce.400ms="busqueda" 
                                placeholder="¿Qué estás buscando?"
                                class="
                            border-link-100 focus:shadow-link-200 w-full rounded-md border bg-transparent p-2 outline-none placeholder:text-white focus:shadow-md dark:placeholder:text-gray-400 pl-11
                            ">

                            <i
                                class="fa-solid fa-magnifying-glass
                            absolute left-4 top-1/2
                            -translate-y-1/2
                            text-white 
                            dark:text-gray-400">
                            </i>

                        </div>

                    </div>


                    {{-- Ordenamiento + contador --}}
                    <div class=" gap-3">

                        <label class="hidden sm:block text-sm text-gray-500 dark:text-gray-300">
                            Filtrar por
                        </label>

                        <select wire:model.live="orden"
                            class="
                            h-11
                            px-4
                            rounded-md
                            border
                            border-link-100
                            dark:border-link-600
                            bg-link-800
                            
                            dark:text-white
                            outline-none
                            focus:ring-2
                            cursor-pointer
                            focus:ring-link-500
                        ">
                            <option value="caracteristicas">
                                Todos los productos
                            </option>

                            <option value="precio-menor">
                                Precio: menor a mayor
                            </option>

                            <option value="precio-mayor">
                                Precio: mayor a menor
                            </option>

                            <option value="nombre">
                                Nombre
                            </option>
                        </select>

                    </div>

                    <div>
                        @if (
                            !empty($categoriasSeleccionadas)  ||
                            !empty($subcategoriasSeleccionadas)  ||
                            !empty($marcasSeleccionadas)  ||
                            !empty($licenciaSeleccionadas)  ||
                            !empty($etiquetasSeleccionadas)  ||
                            trim($busqueda) !== ''
                            )
                            <button
                                type="button"
                                wire:click="limpiarFiltros"
                                class="w-full mx-auto justify-center flex items-center gap-3
                                p-3
                                rounded-md
                                bg-btn-200
                                hover:bg-btn-400
                                dark:bg-btn-400
                                cursor-pointer
                                dark:hover:bg-btn-600
                                text-white
                                font-semibold"
                                >
                                <i class="fa-solid fa-filter-circle-xmark text-xl"></i>
                                <span class="hidden xl:block">
                                    Limpiar filtros
                                </span>
                            </button>
                        @endif
                    </div>

                </div>


                {{-- Botón filtros móvil/tablet --}}
                <div class="mt-4 lg:hidden">

                    <button type="button" @click="filtrosAbiertos = true"
                        class="
                        w-full
                        h-11
                        flex
                        items-center
                        justify-center
                        gap-2
                        rounded-md
                        bg-btn-200 hover:bg-btn-400
                        dark:bg-btn-400
                        dark:hover:bg-btn-600
                        text-white
                        font-medium
                        cursor-pointer
                        transition
                    ">
                        <i class="fa-solid fa-filter"></i>
                        Filtros
                    </button>

                </div>

            </div>

        </div>

        
                {{-- ================================================= --}}
                {{-- SIDEBAR DESKTOP --}}
                {{-- ================================================= --}}
            <div class="">
                {{-- FILTROS ACTIVOS --}}
                @if (
                    !empty($categoriasSeleccionadas) ||
                    !empty($subcategoriasSeleccionadas) ||
                    !empty($marcasSeleccionadas) ||
                    !empty($licenciaSeleccionadas) ||
                    !empty($etiquetasSeleccionadas) 
                    
                    )

                    <div class="mb-6">

                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold mr-1">
                                Filtros activos:
                            </span>

                            {{-- CATEGORÍAS --}}
                            @foreach ($categorias as $categoria)

                                @if (in_array($categoria->id, $categoriasSeleccionadas))

                                    <button
                                        type="button"
                                        wire:click="quitarCategoria({{ $categoria->id }})"
                                        class="inline-flex items-center gap-2
                                            px-3 py-1.5 rounded-full
                                            text-xs font-medium
                                            bg-categoria-300
                                             transition"
                                    >
                                        {{ $categoria->nombre }}

                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                @endif

                            @endforeach


                            {{-- SUBCATEGORÍAS --}}
                            @foreach ($subcategorias as $subcategoria)

                                @if (in_array($subcategoria->id, $subcategoriasSeleccionadas))

                                    <button
                                        type="button"
                                        wire:click="quitarSubcategoria({{ $subcategoria->id }})"
                                        class="inline-flex items-center gap-2
                                            px-3 py-1.5 rounded-full
                                            text-xs font-medium
                                            bg-categoria-300
                                            transition"
                                    >
                                        {{ $subcategoria->nombre }}

                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                @endif

                            @endforeach


                            {{-- MARCAS --}}
                            @foreach ($marcas as $marca)

                                @if (in_array($marca->id, $marcasSeleccionadas))

                                    <button
                                        type="button"
                                        wire:click="quitarMarca({{ $marca->id }})"
                                        class="inline-flex items-center gap-2
                                            px-3 py-1.5 rounded-full
                                            text-xs font-medium
                                            bg-categoria-300
                                            transition"
                                    >
                                        {{ $marca->nombre }}

                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                @endif

                            @endforeach

                            {{-- LICENCIAS --}}
                            @foreach ($licencias as $licencia)

                                @if (in_array($licencia->id, $licenciaSeleccionadas))

                                    <button
                                        type="button"
                                        wire:click="quitarLicencia({{ $licencia->id }})"
                                        class="inline-flex items-center gap-2
                                            px-3 py-1.5 rounded-full
                                            text-xs font-medium
                                            bg-categoria-300
                                            transition"
                                    >
                                        {{ $licencia->nombre }}

                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                @endif

                            @endforeach


                            {{-- ETIQUETAS --}}
                            @foreach ($etiquetas as $etiqueta)

                                @if (in_array($etiqueta->id, $etiquetasSeleccionadas))

                                    <button
                                        type="button"
                                        wire:click="quitarEtiqueta({{ $etiqueta->id }})"
                                        class="inline-flex items-center gap-2
                                            px-3 py-1.5 rounded-full
                                            text-xs font-medium
                                            bg-nav-600 dark:bg-cont-500
                                            hover:opacity-80 transition"
                                    >
                                        {{ $etiqueta->nombre }}

                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                @endif

                            @endforeach

                        </div>

                    </div>

                @endif
            </div>

        <div class="flex gap-6">
                <aside class="hidden lg:block w-60 shrink-0">
                    <div class=" sticky top-18 bg-cont-200 dark:bg-cont-300 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden "
                        x-data="{ 
                            categoria: true, 
                            subcategoria: true, 
                            etiquetas: true, 
                            licencia: true, 
                            marca: true, 
                            precio: true 
                            }">

                        {{-- Categoria --}}

                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <button type="button" @click="categoria = !categoria"
                                class=" w-full px-4 py-3 flex items-center justify-between bg-light-100 dark:bg-nav-900 transition ">
                                <h3 class="text-sm font-bold uppercase text-link-100"> Categorias </h3> <i
                                    class=" fa-solid fa-chevron-up text-xs  transition-transform duration-300 "
                                    :class="{ 'rotate-180': !categoria }"></i>
                            </button>
                            <div x-show="categoria" x-collapse>
                                <div class="p-4 space-y-3">  
                                    @foreach ($categorias as $categoria)
                                    <label
                                    wire:key="categoria-{{ $categoria->id }}"
                                    class="flex items-center justify-between gap-3 cursor-pointer"
                                >
                                    <div class="flex items-center gap-3">
                                
                                        <input
                                            type="checkbox"
                                            value="{{ $categoria->id }}"
                                            wire:model.live="categoriasSeleccionadas"
                                            class="rounded-md border-gray-300
                                                   text-btn-600 focus:ring-btn-600"
                                        >
                                
                                        <span class="text-sm">
                                            {{ $categoria->nombre }}
                                        </span>
                                
                                    </div>
                                
                                    <span class="text-xs ">
                                        {{ $categoria->productos_count }}
                                    </span>
                                </label>
                                @endforeach
                                </div>
                            </div>
                        </div> 
                        {{-- Sub categoria --}}

                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <button type="button" @click="subcategoria = !subcategoria"
                                class=" w-full px-4 py-3 flex items-center justify-between bg-light-100 dark:bg-nav-900 transition ">
                                <h3 class="text-sm font-bold uppercase text-link-100"> Sub Categorias</h3> <i
                                    class=" fa-solid fa-chevron-up text-xs  transition-transform duration-300 "
                                    :class="{ 'rotate-180': !subcategoria }"></i>
                            </button>
                            <div x-show="subcategoria" x-collapse>
                                <div class="p-4 space-y-3">  
                                    @forelse ($subcategorias as $subcategoria)

                                        <label
                                            wire:key="subcategoria-{{ $subcategoria->id }}"
                                            class="flex items-center justify-between gap-3 cursor-pointer"
                                        >

                                            <div class="flex items-center gap-3">

                                                <input
                                                    type="checkbox"
                                                    value="{{ $subcategoria->id }}"
                                                    wire:model.live="subcategoriasSeleccionadas"
                                                    class="rounded-md border-gray-300
                                                        text-btn-600 focus:ring-btn-600"
                                                >

                                                <span class="text-sm">
                                                    {{ $subcategoria->nombre }}
                                                </span>

                                            </div>

                                            <span class="text-xs ">
                                                {{ $subcategoria->productos_count }}
                                            </span>

                                        </label>
                                        @empty

                                        <span class="text-xs text-gray-300">
                                            Selecciona una categoria para ver sus sub categorias
                                        </span> 
                    
                                    @endforelse
                                </div>
                            </div>
                        </div> 
                        
                         {{-- MARCA --}} 
                        <div
                            class="border-b border-gray-200 dark:border-gray-700"> <button type="button"
                                @click="marca = !marca"
                                class="  w-full px-4 py-3 flex items-center justify-between bg-light-100 dark:bg-nav-900 transition ">
                                <h3 class="text-sm font-bold uppercase text-link-100"> Marca </h3> <i
                                    class=" fa-solid fa-chevron-up text-xs transition-transform duration-300 "
                                    :class="{ 'rotate-180': !marca }"></i>
                            </button>
                            <div x-show="marca" x-collapse>
                                <div class="p-4 space-y-3 overflow-y-auto">
                                    @foreach ($marcas as $marca)
                                    <label
                                        wire:key="marca-{{ $marca->id }}"
                                        class="flex items-center justify-between gap-3 cursor-pointer"
                                    >

                                        <div class="flex items-center gap-3">

                                            <input
                                                type="checkbox"
                                                value="{{ $marca->id }}"
                                                wire:model.live="marcasSeleccionadas"
                                                class="rounded-md border-gray-300
                                                    text-btn-600 focus:ring-btn-600"
                                            >

                                            <span class="text-sm">
                                                {{ $marca->nombre }}
                                            </span>

                                        </div>

                                        <span class="text-xs ">
                                            {{ $marca->products_count }}
                                        </span>

                                    </label>
                                @endforeach
                                </div>
                            </div>
                        </div> 
                         {{-- Licencia --}} 
                        <div
                            class="border-b border-gray-200 dark:border-gray-700"> <button type="button"
                                @click="licencia = !licencia"
                                class="  w-full px-4 py-3 flex items-center justify-between bg-light-100 dark:bg-nav-900 transition ">
                                <h3 class="text-sm font-bold uppercase text-link-100"> Licencias </h3> <i
                                    class=" fa-solid fa-chevron-up text-xs transition-transform duration-300 "
                                    :class="{ 'rotate-180': !licencia }"></i>
                            </button>
                            <div x-show="licencia" x-collapse>
                                <div class="p-4 space-y-3 overflow-y-auto">
                                    @foreach ($licencias as $licencia)
                                    <label
                                        wire:key="licencia-{{ $licencia->id }}"
                                        class="flex items-center justify-between gap-3 cursor-pointer"
                                    >

                                        <div class="flex items-center gap-3">

                                            <input
                                                type="checkbox"
                                                value="{{ $licencia->id }}"
                                                wire:model.live="licenciaSeleccionadas"
                                                class="rounded-md border-gray-300
                                                    text-btn-600 focus:ring-btn-600"
                                            >

                                            <span class="text-sm">
                                                {{ $licencia->nombre }}
                                            </span>

                                        </div>

                                        <span class="text-xs ">
                                            {{ $licencia->products_count }}
                                        </span>

                                    </label>
                                @endforeach
                                </div>
                            </div>
                        </div> 

                        {{-- ETIQUETAS --}} 
                        <div
                            class="border-b border-gray-200 dark:border-gray-700"> <button type="button"
                                @click="etiquetas = !etiquetas"
                                class="  w-full px-4 py-3 flex items-center justify-between bg-light-100 dark:bg-nav-900 transition ">
                                <h3 class="text-sm font-bold uppercase text-link-100"> Etiquetas </h3> <i
                                    class=" fa-solid fa-chevron-up text-xs transition-transform duration-300 "
                                    :class="{ 'rotate-180': !etiquetas }"></i>
                            </button>
                            <div x-show="etiquetas" x-collapse>
                                <div class="p-4 space-y-3 overflow-y-auto">
                                    @foreach ($etiquetas as $etiqueta)
                                    <label
                                    wire:key="etiqueta-{{ $etiqueta->id }}"
                                    class="flex items-center justify-between gap-3 cursor-pointer"
                                >
                            
                                    <div class="flex items-center gap-3">
                            
                                        <input
                                            type="checkbox"
                                            value="{{ $etiqueta->id }}"
                                            wire:model.live="etiquetasSeleccionadas"
                                            class="rounded-md border-gray-300
                                                   text-btn-600 focus:ring-btn-600"
                                        >
                            
                                        <span class="text-sm">
                                            {{ $etiqueta->nombre }}
                                        </span>
                            
                                    </div>
                            
                                    <span class="text-xs ">
                                        {{ $etiqueta->productos_count }}
                                    </span>
                            
                                </label>
                                @endforeach
                                </div>
                            </div>
                        </div> 
                                               
                    </div>
                </aside>

                

                {{-- GRID --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 mx-auto">

                    @forelse ($productos as $producto)

                    <x-ui.product-card :producto="$producto"/>

                    @empty

                        <div class="col-span-full py-16 text-center">

                            <i class="fa-solid fa-box-open text-5xl text-gray-400 mb-4"></i>

                            <h2 class="text-xl font-semibold">
                                No encontramos productos
                            </h2>

                            <p class=" mt-2">
                                Intenta modificar tu búsqueda o filtros.
                            </p>

                        </div>

                    @endforelse

                </div>
        </div>


    {{-- PAGINACIÓN --}}
    <div class="mt-8">
        {{ $productos->links() }}
    </div>

    {{-- ========================================================= --}}
    {{-- DRAWER MOBILE / TABLET --}}
    {{-- ========================================================= --}}

    <div x-show="filtrosAbiertos" x-cloak class="fixed inset-0 z-50 lg:hidden">

        {{-- Overlay --}}
<div class="absolute inset-0 bg-black/50" @click="filtrosAbiertos = false" x-transition.opacity></div>

        {{-- Drawer --}}
        <aside
            class="
            absolute
            left-0
            top-0
            h-full
            w-[85%]
            max-w-sm
            bg-cont-200
            dark:bg-nav-900
            shadow-2xl
            overflow-y-auto
        "
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

            {{-- Header drawer --}}
            <div
                class="
                sticky
                top-0
                z-10
                flex
                items-center
                justify-between
                px-5
                py-4
                border-b
                border-gray-200
                dark:border-link-700
                bg-light-200
                dark:bg-nav-700
            ">

                <h2 class="text-lg font-bold ">
                    Filtros
                </h2>

                <button type="button" @click="filtrosAbiertos = false"
                    class="
                    w-9
                    h-9
                    rounded-md
                    bg-btn-200
                    dark:bg-btn-400
                    hover:bg-btn-400
                    dark:hover:bg-btn-600
                    flex
                    transition-colors
                    items-center
                    justify-center
                    cursor-pointer                        
                ">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>


            {{-- Contenido filtros --}}
            <div class="p-5 space-y-6">

                @if (
                    !empty($categoriasSeleccionadas)  ||
                    !empty($subcategoriasSeleccionadas)  ||
                    !empty($marcasSeleccionadas)  ||
                    !empty($licenciaSeleccionadas)  ||
                    !empty($etiquetasSeleccionadas)  ||
                    trim($busqueda) !== ''
                    )
                    <button
                        type="button"
                        wire:click="limpiarFiltros"
                        class="w-full
                        py-3
                        rounded-md
                        bg-btn-200
                        hover:bg-btn-400
                        dark:bg-btn-400
                        cursor-pointer
                        dark:hover:bg-btn-600
                        text-white
                        font-semibold"
                    >
                        <i class="fa-solid fa-filter-circle-xmark mr-2"></i>
                        Limpiar filtros
                    </button>
                @endif

                {{-- CATEGORIAS --}}
                <div>

                    <h3 class="font-bold text-link-100 uppercase text-sm mb-4">
                        Categorias
                    </h3>

                    <div class="space-y-3">

                        @foreach ($categorias as $categoria)
                            <label class="flex items-center gap-3">

                                <input 
                                    type="checkbox"
                                    value="{{ $categoria->id }}"
                                    wire:model.live="categoriasSeleccionadas" 
                                    class="rounded-md text-btn-600 focus:ring-btn-600">

                                <span class="text-sm">
                                    {{ $categoria->nombre }}
                                </span>

                            </label>
                        @endforeach

                    </div>

                </div>

                {{-- SUB CATEGORIAS --}}
                <div>

                    <h3 class="font-bold text-link-100 uppercase text-sm mb-4">
                        Sub Categorias
                    </h3>
                    

                    <div class="space-y-3">

                        @forelse ($subcategorias as $subcategoria)
                            <label class="flex items-center gap-3 cursor-pointer">

                                <input 
                                    type="checkbox"
                                    value="{{ $subcategoria->id }}"
                                    wire:model.live="subcategoriasSeleccionadas" 
                                    class="rounded-md text-btn-600 focus:ring-btn-600">

                                <span class="text-sm">
                                    {{ $subcategoria->nombre }}
                                </span>

                            </label>
                        @empty
                        <span class="text-xs text-gray-300">
                            Selecciona una categoria para ver sus sub categorias
                        </span>    
                        @endforelse

                    </div>

                </div>
                
                {{-- Marca --}}
                <div>

                    <h3 class="font-bold text-link-100  uppercase text-sm mb-4">
                        Marca
                    </h3>

                    <div class="space-y-3">

                        @foreach ($marcas as $marca)
                            <label class="flex items-center gap-3 cursor-pointer">

                                <input 
                                    type="checkbox"
                                    value="{{ $marca->id }}"
                                    wire:model.live="marcasSeleccionadas" 
                                    class="rounded-md text-btn-600 focus:ring-btn-600">

                                <span class="text-sm ">
                                    {{ $marca->nombre }}
                                </span>

                            </label>
                        @endforeach

                    </div>

                </div>

                {{-- LICENCIAS --}}
                <div>

                    <h3 class="font-bold text-link-100  uppercase text-sm mb-4">
                        Licencias
                    </h3>

                    <div class="space-y-3">

                        @foreach ($licencias as $licencia)
                            <label class="flex items-center gap-3 cursor-pointer">

                                <input 
                                    type="checkbox"
                                    value="{{ $licencia->id }}"
                                    wire:model.live="licenciaSeleccionadas" 
                                    class="rounded-md text-btn-600 focus:ring-btn-600">

                                <span class="text-sm ">
                                    {{ $licencia->nombre }}
                                </span>

                            </label>
                        @endforeach

                    </div>

                </div>
                {{-- ETIQUETAS --}}
                <div>

                    <h3 class="font-bold text-link-100  uppercase text-sm mb-4">
                        Etiquetas
                    </h3>

                    <div class="space-y-3">

                        @foreach ($etiquetas as $etiqueta)
                            <label class="flex items-center gap-3 cursor-pointer">

                                <input 
                                    type="checkbox"
                                    value="{{ $etiqueta->id }}"
                                    wire:model.live="etiquetasSeleccionadas" 
                                    class="rounded-md text-btn-600 focus:ring-btn-600">

                                <span class="text-sm ">
                                    {{ $etiqueta->nombre }}
                                </span>

                            </label>
                        @endforeach

                    </div>

                </div>

        </aside>

    </div>
</div>
