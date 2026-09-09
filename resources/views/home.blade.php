@extends('components.layouts.principal')

@section('contenido')

@if ($banners->isNotEmpty())
    @include('plataforma.home.carousel', $banners)
@else
<div class="w-full bg-light-300 dark:to-[#010338] bg-radial dark:from-link-300 p-4 md:p-6 lg:p-8 xl:h-187.5">
        
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-5 place-content-center">
        <div class="grid place-content-center p-10 gap-y-3 lg:mx-24 xl:h-125">
            <div class="text-5xl font-semibold text-left">
                Emprendedores Creativos &copy;
                <p class="py-3 dark:text-white text-base font-normal text-justify">
                    Una identidad visual correctamente desarrollada, llamara la
                    atención de tus clientes y lograra que se acuerden de ti a
                    futuro, eso se logra trabajando de la mano con profesionales.
                </p>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <a href="{{ route('contacto') }}" wire:navigate>
                <button
                    class='dark:bg-btn-400 dark:hover:bg-btn-600 bg-btn-200 hover:bg-btn-400 transition-colors duration-300 flex items-center gap-3 w-full place-content-center p-2 rounded-md text-white cursor-pointer'>
                    <i class="fa-solid fa-envelope"></i>
                    Contacto
                </button>
                </a>
            </div>
        </div>
        <div class="md:flex justify-center bg-center w-auto p-12">
            <img src="{{ asset('images/maquina.svg') }}" alt="imagen imprenta" class="w-180" />
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
            {{ $recienRegistrado ? '¡Bienvenido/a' : 'Hola de nuevo' }}, {{ $user->nombre_completo }}
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
    <div>
        <div class="justify-center font-semibold mb-10 text-center text-2xl mx-auto">
            Últimas publicaciones
        </div>
        <div class="grid gap-4 pb-8 sm:grid-cols-2 lg:grid-cols-3">
            {{-- @forelse ($ultimosPost as $post)
           <a wire:navigate href={{ route('blog.show', $post->slug ) }} class="mb-4 block overflow-hidden rounded-lg">
            <article class="dark:bg-cont-100 bg-light-200 text-white">
              <div>
                <img src={{ $post->imagen ? Storage::url($post->imagen) : '' }} alt="{{  $post->titulo  }}"
                class=" aspect-video w-full object-cover "
                />
              </div>
              <div class="space-y-3 p-4 mt-2">
                <div class="flex items-center justify-between">
                  <span class="bg-categoria-200 rounded-md px-2 py-1 text-sm font-bold">
                    {{ $post->categoriaPost->nombre }}</span>
                  <div class="flex items-center justify-center gap-3 text-sm">

                    <div class="flex items-center gap-1">
                      <i class="fa-solid fa-eye"></i>
                      <p>Lectura de {{ $post->tiempo_de_lectura }} min.</p>
                    </div>
                  </div>
                </div>

                <h3 class="hover:text-link-400 dark:hover:text-link-200 mb-2 text-2xl font-semibold">{{ $post->titulo }}
                </h3>
                <div class="">
                  <p class="line-clamp-3 text-justify text-sm text-slate-200 dark:text-slate-300">
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
                    <div class="flex items-center gap-1">
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($post->autor->nombre_completo) }}"
                                class="w-[25px] h-[25px] rounded-full" />
                      <p class="capitalize">{{$post->autor->nombre_completo}}</p>
                    </div>
                    <div class="flex items-center gap-1">
                      <i class="fa-solid fa-calendar"></i>
                      {{ $post->created_at->diffForHumans() }}
                    </div>
                  </div>
                </div>
              </div>
            </article>
          </a>
          @empty --}}
          <p class="text-center">No hay publicaciones aun</p>
            {{-- @endforelse --}}
        </div>
    </div>
</div>

@include('plataforma.home.boletin')
@include('plataforma.home.testimonios')

@endsection