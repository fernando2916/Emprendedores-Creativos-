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
        }" class="min-h-screen ">

        {{-- Licencias slider --}}
        {{-- Marcas --}}
        <div class="relative overflow-hidden">
            <div class="mx- auto flex justify-center py-5">
                <span class="font-semibold text-2xl">
                    Marcas que trabajan con nosotros
                </span>
            </div>
            <div class="swiper-marcas marcasSwiper">
                <div class="swiper-wrapper items-center">

                    @foreach ($marcas as $marca)
                        <div class="swiper-slide flex justify-center items-center">
                            <img src="{{ Storage::url($marca->imagen) }}" alt="{{ $marca->nombre }}"
                                class="h-16 w-auto object-contain opacity-70
                                       hover:opacity-100 transition-opacity">
                        </div>
                    @endforeach

                </div>
            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- CONTENIDO --}}
        {{-- ========================================================= --}}

         <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <div class="flex gap-6">


                {{-- ================================================= --}}
                {{-- PRODUCTOS --}}
                {{-- ================================================= --}}

                <main class="flex-1 min-w-0">

                   <livewire:shop.productos-listado />

                </main>

            </div>

        </div>

    </div>

    {{-- información relevante --}}
    {{-- reseñas generales --}}
@endsection
