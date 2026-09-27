@extends('components.layouts.principal')

@section('titulo')
    Tienda |
@endsection

@section('contenido')
    {{-- Contador promocion --}}
    {{-- Banner Slider --}}
    @if ($banners->isNotEmpty())
        @include('plataforma.home.carousel', $banners)
    @else
        <div
            class="w-full bg-light-300 dark:to-[#100042] bg-radial dark:from-[#610942] mx-auto px-5 sm:px-10 lg:px-12 pt-28 pb-12 sm:py-24 min-h-svh lg:min-h-screen">

            <div class="relative max-w-350 mx-auto px-5 sm:px-10 lg:px-12 w-full pt-32 pb-12 sm:py-24">
                <div class="grid lg:grid-cols-2 gap-12 xl:gap-16 items-center">
                    <div class="max-w-2xl mx-auto text-center lg:mx-0 lg:text-start">
                        <h1
                            class="text-4xl sm:text-6xl lg:text-7xl font-black leading-[1.05] mb-5 sm:mb-6 tracking-tight visible">
                            <span class="text-dark-100/90 block">
                                Emprendedores
                            </span>
                            <span class="gradient-text block mt-1 blue-glow">
                                Creativos &copy;
                            </span>
                        </h1>
                        <div class="flex items-center justify-center gap-6 mb-5 sm:mb-6 lg:justify-start visible">
                            <div class="hidden lg:block h-px w-12 bg-link-500"></div>
                            <span class="text-xl sm:text-2xl font-display font-semibold text-dark-200 tracking-tight">
                                Transformando tus ideas en soluciones creativas.
                            </span>
                        </div>

                        <p
                            class="text-base sm:text-lg text-dark-400 max-w-xl mx-auto mb-7 sm:mb-8 leading-relaxed lg:mx-0 visible">
                            Una identidad visual correctamente desarrollada, llamara la
                            atención de tus clientes y lograra que se acuerden de ti a
                            futuro, eso se logra trabajando de la mano con profesionales.
                        </p>
                        <div
                            class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap sm:justify-center sm:gap-4 lg:justify-start visible">
                            <a href="{{ route('proyectos.index') }}" wire:navigate>
                                <button
                                    class='dark:bg-btn-400 dark:hover:bg-btn-600 bg-btn-200 hover:bg-btn-400 transition-colors duration-300 flex items-center gap-3 w-full place-content-center px-4 sm:px-8 p-2 rounded-md text-white cursor-pointer'>
                                    <i class="fa-solid fa-object-group"></i>
                                    Proyectos
                                </button>
                            </a>
                            <a href="{{ route('contacto.index') }}" wire:navigate>
                                <button
                                    class='dark:bg-btn-400 dark:hover:bg-btn-600 bg-btn-200 hover:bg-btn-400 transition-colors duration-300 flex items-center gap-3 w-full place-content-center px-4 sm:px-8 p-2 rounded-md text-white cursor-pointer'>
                                    <i class="fa-solid fa-envelope"></i>
                                    Contacto
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:block realtive visible">
                        <img src="{{ asset('images/maquina.svg') }}" alt="imagen imprenta" class="w-180" />
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div x-data="{
        filtrosAbiertos: false,
        busqueda: '',
        orden: 'caracteristicas'
        }" class="min-h-screen ">

        {{-- ========================================================= --}}
        {{-- HEADER / BUSCADOR --}}
        {{-- ========================================================= --}}

        <div class="border-b border-gray-200 dark:border-gray-700">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 mb-10">

                <div class="flex items-center gap-4 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Buscador --}}
                    <div class="w-full lg:max-w-3xl">

                        <div class="relative">

                            <input type="text" x-model="busqueda" placeholder="¿Qué estás buscando?"
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

                        <select x-model="orden"
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
                                Características
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

                        <span class="hidden md:block text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            109 productos
                        </span>

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

        {{-- Licencias slider --}}
        {{-- Marcas --}}

        {{-- ========================================================= --}}
        {{-- CONTENIDO --}}
        {{-- ========================================================= --}}

        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <div class="flex gap-6">


                {{-- ================================================= --}}
                {{-- SIDEBAR DESKTOP --}}
                {{-- ================================================= --}}

                <aside class="hidden lg:block w-60 shrink-0">
                    <div class=" sticky top-6 bg-cont-200 dark:bg-cont-300 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden "
                        x-data="{ tipoProducto: true, marca: true, precio: true }">
                        {{-- ================================================= --}}
                        {{-- TIPO DE PRODUCTO --}}
                        {{-- ================================================= --}}
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <button type="button" @click="tipoProducto = !tipoProducto"
                                class=" w-full px-4 py-3 flex items-center justify-between bg-light-100 dark:bg-nav-900 transition ">
                                <h3 class="text-sm font-bold uppercase text-link-100"> Tipo de producto </h3> <i
                                    class=" fa-solid fa-chevron-up text-xs  transition-transform duration-300 "
                                    :class="{ 'rotate-180': !tipoProducto }"></i>
                            </button>
                            <div x-show="tipoProducto" x-collapse>
                                <div class="p-4 space-y-3"> <label class="flex items-center gap-3 cursor-pointer"> <input
                                            type="checkbox"
                                            class=" rounded-md border-gray-300 text-btn-600 focus:ring-btn-600 "> <span
                                            class="text-sm "> Sudaderas </span> </label>
                                    <label class="flex items-center gap-3 cursor-pointer"> <input type="checkbox"
                                            class=" rounded-md border-gray-300 text-btn-600 focus:ring-btn-600 "> <span
                                            class="text-sm "> Playeras </span> </label>
                                    <label class="flex items-center gap-3 cursor-pointer"> <input type="checkbox"
                                            class=" rounded-md border-gray-300 text-btn-600 focus:ring-btn-600 "> <span
                                            class="text-sm "> Accesorios </span> </label>
                                </div>
                            </div>
                        </div> {{-- ================================================= --}} {{-- MARCA --}} {{-- ================================================= --}} <div
                            class="border-b border-gray-200 dark:border-gray-700"> <button type="button"
                                @click="marca = !marca"
                                class="  w-full px-4 py-3 flex items-center justify-between bg-light-100 dark:bg-nav-900 transition ">
                                <h3 class="text-sm font-bold uppercase text-link-100"> Marca </h3> <i
                                    class=" fa-solid fa-chevron-up text-xs transition-transform duration-300 "
                                    :class="{ 'rotate-180': !marca }"></i>
                            </button>
                            <div x-show="marca" x-collapse>
                                <div class="p-4 space-y-3 overflow-y-auto">
                                    @foreach (['Animaniacs', 'Avatar', 'Batman', 'Bob Esponja', 'Dragon Ball Z', 'Escandalosos', 'Flash', 'Harry Potter', 'Hey Arnold', 'La Liga de la Justicia', 'Looney Tunes', 'Marvel', 'Superman', 'Tom y Jerry'] as $marcaItem)
                                        <label class="flex items-center gap-3 cursor-pointer"> <input type="checkbox"
                                                class=" rounded-md border-gray-300 text-btn-600 focus:ring-btn-600 ">
                                            <span class="text-sm"> {{ $marcaItem }}
                                            </span> </label>
                                    @endforeach
                                </div>
                            </div>
                        </div> {{-- ================================================= --}} {{-- PRECIO --}} {{-- ================================================= --}} <div> <button
                                type="button" @click="precio = !precio"
                                class="  w-full px-4 py-3 flex items-center justify-between bg-light-100 dark:bg-nav-900 transition ">
                                <h3 class="text-sm font-bold uppercase text-link-100"> Precio </h3> <i
                                    class=" fa-solid fa-chevron-up text-xs transition-transform duration-300 "
                                    :class="{ 'rotate-180': !precio }"></i>
                            </button>
                            <div x-show="precio" x-collapse>
                                <div class="p-4 space-y-3">
                                    <div class="flex gap-2"> <input type="number" placeholder="Mín."
                                            class="border-link-100 focus:shadow-link-200 w-full rounded-md border bg-transparent p-2 outline-none placeholder:text-white focus:shadow-md dark:placeholder:text-gray-400">
                                        <input type="number" placeholder="Máx."
                                            class="border-link-100 focus:shadow-link-200 w-full rounded-md border bg-transparent p-2 outline-none placeholder:text-white focus:shadow-md dark:placeholder:text-gray-400">
                                    </div> <button type="button"
                                        class=" w-full py-2 rounded-lg bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 text-white text-sm font-medium transition cursor-pointer ">
                                        Aplicar </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>


                {{-- ================================================= --}}
                {{-- PRODUCTOS --}}
                {{-- ================================================= --}}

                <main class="flex-1 min-w-0">

                    {{-- Resultados --}}
                    {{-- <div class="flex items-center justify-between mb-5">

                        <div>

                            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">
                                Productos
                            </h1>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Encuentra el producto que estás buscando
                            </p>

                        </div>

                        <span class="text-sm text-gray-500 dark:text-gray-400 md:hidden">
                            109 productos
                        </span>

                    </div> --}}


                    {{-- Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">

                        @foreach (range(1, 9) as $producto)
                            <article
                                class="group bg-cont-200 dark:bg-cont-400 rounded-xl overflow-hidden transition duration-300
                                ">

                                {{-- Imagen --}}
                                <div class="relative overflow-hidden bg-gray-100">

                                    <img src="https://picsum.photos/600/750?random={{ $producto }}" alt="Producto"
                                        class="
                                        w-full
                                        aspect-video
                                        object-cover
                                        group-hover:scale-105
                                        transition
                                        duration-500
                                    ">


                                    {{-- Descuento --}}
                                    <div
                                        class="absolute top-3 left-3 px-3 py-1 rounded-full bg-gray-900 text-white text-xs font-bold flex items-center gap-1
                                    ">
                                        <span class="text-green-400">
                                            ♥
                                        </span>

                                        15% DTO

                                        <span class="text-red-400">
                                            ♥
                                        </span>
                                    </div>


                                    {{-- Favorito --}}
                                    <button type="button"
                                        class="absolute top-3 right-3 w-9 h-9 rounded-full bg-btn-200 dark:bg-btn-400 flex items-center justify-center opacity-0 group-hover:opacity-100 transition
                                    ">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>

                                </div>


                                {{-- Información --}}
                                <div class="p-4">
                                    <div class="flex justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-semibold bg-categoria-200 p-1 rounded-md">Categoria</span>
                                            <span class="text-xs font-semibold bg-categoria-300 p-1 rounded-md">Oferta</span>
                                        </div>
                                        {{-- Rating --}}
                                        <div class="flex items-center justify-center gap-1 mt-2">
    
                                            <div class="flex text-yellow-400 text-sm">
    
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa-solid fa-star"></i>
                                                @endfor
    
                                            </div>
    
                                            <span class="text-xs ">
                                                ({{ rand(10, 100) }})
                                            </span>
    
                                        </div>

                                    </div>
                                    <div class="min-h-12 mt-5">
                                        <h2
                                            class="font-semibold truncate text-2xl line-clamp-1
                                        ">
                                            Sudaderota Producto {{ $producto }}
                                        </h2>
                                        <span class="text-sm font-semibold">
                                            SKU:
                                        </span>
                                    </div>
                                    <div class="font-semibold line-clamp-2">
                                        Descripcion del producto
                                    </div>

                                    {{-- Precio --}}
                                    <div class="flex items-center gap-2">
                                        <p class="text-2xl font-bold text-btn-400 dark:text-link-100">
                                            $ 999.00
                                        </p>
                                        <span class="dark:text-gray-300 font-medium text-xs line-through">
                                            $1,200
                                        </span>
                                    </div>
                                    <div class="">
                                        Disponible / Últimas piezas / Agotado
                                    </div>

                                    <div class="flex items-center gap-2 w-full mx-auto mt-5 justify-between">
                                        <a href="" class="w-full mx-auto">
                                            <button class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-color px-3 py-2 flex items-center justify-center gap-2 rounded-md w-full mx-auto text-sm md:text-base lg:text-sm cursor-pointer">
                                                <i class="fa-solid fa-shopping-cart"></i>
                                                Añadir al carrito
                                            </button>
                                        </a>
                                        <a href="" class="w-full mx-auto">
                                            <button class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-color px-3 py-2 flex items-center justify-center gap-2 rounded-md w-full mx-auto text-sm md:text-base lg:text-sm cursor-pointer">
                                                <i class="fa-solid fa-dollar"></i>
                                                Comprar
                                            </button>
                                        </a>
                                    </div>

                                </div>

                            </article>
                        @endforeach

                    </div>

                </main>

            </div>

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
                        rounded-full
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

                    {{-- Tipo --}}
                    <div>

                        <h3 class="font-bold text-link-100 uppercase text-sm mb-4">
                            Tipo de producto
                        </h3>

                        <div class="space-y-3">

                            @foreach (['Sudaderas', 'Playeras', 'Accesorios'] as $tipo)
                                <label class="flex items-center gap-3">

                                    <input type="checkbox" class="rounded-md text-btn-600 focus:ring-btn-600">

                                    <span class="text-sm">
                                        {{ $tipo }}
                                    </span>

                                </label>
                            @endforeach

                        </div>

                    </div>


                    {{-- Marca --}}
                    <div>

                        <h3 class="font-bold text-link-100  uppercase text-sm mb-4">
                            Marca
                        </h3>

                        <div class="space-y-3">

                            @foreach (['Animaniacs', 'Avatar', 'Batman', 'Bob Esponja', 'Dragon Ball Z', 'Friends', 'Harry Potter', 'Marvel', 'One Piece', 'Superman'] as $marca)
                                <label class="flex items-center gap-3">

                                    <input type="checkbox" class="rounded-md text-btn-600 focus:ring-btn-600">

                                    <span class="text-sm ">
                                        {{ $marca }}
                                    </span>

                                </label>
                            @endforeach

                        </div>

                    </div>


                    {{-- Precio --}}
                    <div>

                        <h3 class="font-bold text-link-100 uppercase text-sm mb-4">
                            Precio
                        </h3>

                        <div class="flex gap-2">

                            <input type="number" placeholder="Mín."
                                class="
                            border-link-100 focus:shadow-link-200 w-full rounded-md border bg-transparent p-2 outline-none placeholder:text-white focus:shadow-md dark:placeholder:text-gray-400
                            ">

                            <input type="number" placeholder="Máx."
                                class="
                            border-link-100 focus:shadow-link-200 w-full rounded-md border bg-transparent p-2 outline-none placeholder:text-white focus:shadow-md dark:placeholder:text-gray-400
                            ">

                        </div>

                    </div>

                </div>


                {{-- Footer --}}
                <div
                    class="
                    sticky
                    bottom-0
                    p-4
                ">

                    <button type="button" @click="filtrosAbiertos = false"
                        class="
                        w-full
                        py-3
                        rounded-lg
                        bg-btn-200
                        hover:bg-btn-400
                        dark:bg-btn-400
                        cursor-pointer
                        dark:hover:bg-btn-600
                        text-white
                        font-semibold
                    ">
                        Aplicar filtros
                    </button>

                </div>

            </aside>

        </div>

    </div>
    
    {{-- información relevante --}}
    {{-- reseñas generales --}}
@endsection
