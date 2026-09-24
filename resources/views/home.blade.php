@extends('components.layouts.principal')

@section('contenido')
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
                        <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap sm:justify-center sm:gap-4 lg:justify-start visible">
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
    @auth
        @php
            $user = auth()->user();
            $recienRegistrado = now()->diffInMinutes($user->created_at) < 10 && !session('welcome_message_shown');

            if ($recienRegistrado) {
                session(['welcome_message_shown' => true]);
            }
        @endphp

        <div class="flex justify-center">
            <h2 class="text-xl md:text-4xl font-bold">
                {{ $recienRegistrado ? 'Bienvenido/a' : 'Hola de nuevo' }}, {{ $user->nombre_completo }}
            </h2>
        </div>
    @endauth

    @include('plataforma.home.servicios')

    <div class="mx-auto px-5 lg:container">
        <div class="">
            productos
        </div>
        <div class="">
            Cursos
        </div>
        <section class="py-32">
            <div class="max-w-350 mx-auto px-6 sm:px-10 lg:px-12">                            
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 animate-on-scroll visible">
                    <div class="max-w-2xl">
                        <span class="inline-block px-4 py-1.5 text-2xs font-mono font-semibold tracking-widest uppercase text-link-200 bg-accent-500/8 border border-link-500/20 rounded-full mb-4">
                        Del blog
                        </span>
                        <h2 class="text-4xl sm:text-6xl font-black mb-6">
                            Artículos recientes
                        </h2>
                        <p class="text-lg leading-relaxed">
                            Novedades, consejos, tips, que te pueden ayudara entender como diseñador o como cliente. 
                        </p>
                    </div>
                    <a href="{{ route('blog.index') }}" wire:navigate class="hidden md:flex items-center gap-3 text-sm font-bold text-link-400 hover:text-link-300 transition-color group">
                        Ver todos los arítuclos
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($ultimosPost as $post)
                        <a wire:navigate href={{ route('blog.show', $post->slug) }}
                            class="mb-4 block overflow-hidden rounded-lg">
                            <article class="dark:bg-cont-100 bg-light-200 text-white">
                                <div>
                                    <img src={{ $post->imagen ? Storage::url($post->imagen) : '' }} alt="{{ $post->titulo }}"
                                        class=" aspect-video w-full object-cover " />
                                </div>
                                <div class="space-y-3 p-4 mt-2">
                                    <div class="flex flex-wrap items-center gap-3 mb-3">
                                        <span
                                            class="bg-categoria-400 dark:bg-categoria-200 rounded-md px-2 py-1 text-2xs font-semibold">
                                            {{ $post->categoriaPost->nombre }}
                                        </span>
                                        <div class="flex items-center gap-1 text-sm">
                                            <i class="fa-solid fa-calendar"></i>
                                            {{ $post->created_at->diffForHumans() }}
                                        </div>
                                        <div class="flex items-center justify-center gap-3 text-sm">
                                            <div class="flex items-center gap-1">
                                                <i class="fa-solid fa-eye"></i>
                                                <p>Lectura de {{ $post->tiempo_de_lectura }} min.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="hover:text-link-400 dark:hover:text-link-200 mb-2 text-2xl font-semibold">
                                        {{ $post->titulo }}
                                    </h3>
                                    <div class="">
                                        <p class="line-clamp-2 leading-relaxed mb-5 text-justify text-sm text-slate-200 dark:text-slate-300">
                                            {{ $post->descripcion_corta }}
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center justify-center gap-3">
                                            <div class="flex items-center justify-center gap-1">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                                <p>{{ $post->likes->count() }}</p>
                                            </div>
                                            <div class="flex items-center justify-center gap-1">
                                                <i class="fa-solid fa-comment"></i>
                                                <livewire:contador-comentarios :post="$post" />
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center gap-3 text-sm">
                                            <div class="flex items-center gap-2">
                                                <img src="{{ $post->autor->profile?->avatar
                                                    ? Storage::url($post->autor->profile->avatar)
                                                    : 'https://ui-avatars.com/api/?name=' . urlencode($post->autor->nombre_completo) }}"
                                                    alt="Foto de {{ $post->autor->nombre_completo }}"
                                                    class="w-6 h-6 rounded-full object-cover">
                                                <p class="text-[10.5px]">

                                                    {{ $post->autor->nombre_completo }}
                                                </p>
                                                </p>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </a>
                    @empty
                        <p class="text-center">No hay publicaciones aun</p>
                    @endforelse
                </div>
                <a href="{{ route('blog.index') }}" class="md:hidden mt-10 flex items-center justify-center gap-3 text-sm font-bold text-link-400 hover:text-link-300 transition-color group">
                    Ver todos los artículos
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </section>
    </div>

    @include('plataforma.home.boletin')
    @include('plataforma.home.testimonios')
@endsection
