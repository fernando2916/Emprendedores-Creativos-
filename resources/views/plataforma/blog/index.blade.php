@extends('components.layouts.principal') 

@section('titulo') 
    Blog |
@endsection

@section('contenido')
<section class="pb-16">

  <div class="flex flex-col lg:items-start lg:grid lg:grid-cols-2 gap-8 py-16 lg:container mx-auto px-5">
{{-- Post reciente --}}
@if ($postReciente)
    <a href="{{ route('blog.show', $postReciente->slug) }}">
        <article class="dark:bg-cont-100 bg-light-200 text-white rounded-lg">
        <div class="relative">
            <img src={{ $postReciente->imagen ? Storage::url($postReciente->imagen) : '' }} alt=""
            class=" aspect-video w-full object-cover rounded-t"
            />
            <div class="flex items-center gap-2">
            <p
                class="absolute px-1 text-base font-medium translate-y-1/2 left-4 bottom-0 bg-categoria-200 text-white dark:bg-categoria-400 transition-colors rounded-md">
                {{ $postReciente->categoriaPost->nombre }}
            </p>
            <p
                class="absolute px-1 text-base font-medium translate-y-1/2 left-28 bottom-0 bg-categoria-200 text-white dark:bg-categoria-300 transition-colors rounded-md">
                Post Reciente</p>
            </div>
        </div>
        <div class="p-4">
            <h2 class="font-semibold mb-2 mt-2 text-base md:text-2xl">{{$postReciente->titulo}}</h2>
            <p class="text-sm md:text-base lg:text-xl text-justify text-white">
            {{ $postReciente->descripcion_corta }}
            </p>
        </div>
        <footer
            class="flex text-white flex-wrap gap-2 justify-between py-2 px-4 text-base bg-slate-500 dark:bg-[#001d47] rounded-b">
            <div class="flex items-center gap-2">
                <img src="{{ $postReciente->autor->profile?->avatar
                ? Storage::url($postReciente->autor->profile->avatar)
                : 'https://ui-avatars.com/api/?name=' . urlencode($postReciente->autor->nombre_completo) }}"
                alt="Foto de {{ $postReciente->autor->nombre_completo }}"
                class="w-6 h-6 rounded-full object-cover">
            <p>{{ $postReciente->autor->nombre_completo }}</p>
            </div>
            <div class="flex items-center gap-2">
            <i class="fa-solid fa-clock"></i>
            <p>Lectura de {{ $postReciente->tiempo_de_lectura }} min.</p>
            </div>
            <div class="flex items-center gap-2">
            <i class="fa-solid fa-calendar"></i>
            {{ $postReciente->created_at->diffForHumans() }}
            </div>
        </footer>
        </article>
    </a>
@endif
{{-- ultimos agregados --}}
    <div>
      <h3 class="mb-4 text-2xl font-semibold">Últimos agregados</h3>
      <ul class="flex flex-col gap-8">
        @if ($ultimosPosts->isNotEmpty())
          
        @foreach ( $ultimosPosts as $post )
        <a href="{{ route('blog.show', $post->slug) }}" wire:navigate>
          <article class="grid grid-cols-5 gap-4 items-start bg-light-200 dark:bg-cont-100 rounded-lg">
            <img src={{ $post->imagen ? Storage::url($post->imagen) : '' }} alt=""
            class="col-span-2 rounded-lg overflow-hidden aspect-video object-cover h-36 w-104"
            />
            <div class="col-span-3 ">
              <span
                class="bg-categoria-200 text-white py-1 rounded-md px-2 text-xs font-semibold">
                {{ $post->categoriaPost->nombre }}
              </span>
              <h3 class="mb-2">{{ $post->titulo }}</h3>
              <div class="flex flex-wrap gap-y-1 gap-x-4 mb-2">
                <div class="flex items-center gap-2">
                  <i class="fa-solid fa-clock"></i>
                  <p>Lectura de {{ $post->tiempo_de_lectura }} min.</p>
                </div>
                <div class="flex items-center gap-2">
                  <i class="fa-solid fa-calendar"></i>
                  {{ $post->created_at->diffForHumans() }}
                </div>
              </div>
              <div class="flex flex-wrap gap-y-1 gap-x-4 mb-2">
                 <div class="flex items-center gap-2">
                    <img src="{{ $post->autor->profile?->avatar
                    ? Storage::url($post->autor->profile->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($post->autor->nombre_completo) }}"
                    alt="Foto de {{ $post->autor->nombre_completo }}"
                    class="w-6 h-6 rounded-full object-cover">
                    <p>{{ $post->autor->nombre_completo }}</p>
                </div>
                <div class="flex items-center justify-center gap-3">
                  <div class="flex items-center justify-center gap-1">
                    <i class="fa-solid fa-thumbs-up"></i>
                    <p>{{ $post->likes->count() }}</p>
                  </div>
                  <div class="flex items-center justify-center gap-1">
                    <i class="fa-solid fa-comment"></i>
                    <livewire:contador-comentarios :blog="$post" />
                  </div>
                </div>
              </div>
            </div>
          </article>
        </a>
        @endforeach        
        @else
         <p class="text-gray-400">Aún no hay más artículos recientes.</p>
        @endif

      </ul>
    </div>
  </div>
{{-- resto de los post --}}
<div class="mx-auto px-5 lg:container">
   
    <div class="grid gap-4 pb-8 sm:grid-cols-2 lg:grid-cols-3">
      @foreach ($blogs as $blog)
      <a wire:navigate href={{ route('blog.show', $blog->slug ) }} class="mb-4 block overflow-hidden rounded-lg">
        <article class="dark:bg-cont-100 bg-light-200 text-white">
          <div class="relative">
            <img src={{ $blog->imagen ? Storage::url($blog->imagen) : '' }} alt=""
            class=" aspect-video w-full object-cover "
            />
          </div>
          <div class="space-y-3 p-4 mt-2">
            <div class="flex items-center justify-between">
              <span class="bg-categoria-300 dark:bg-categoria-200 rounded-md px-2 py-1 text-sm font-bold">
                {{ $blog->categoriaPost->nombre }}</span>
              <div class="flex items-center justify-center gap-3 text-sm">

                <div class="flex items-center gap-1">
                  <i class="fa-solid fa-eye"></i>
                  <p>Lectura de {{ $blog->tiempo_de_lectura }} min.</p>
                </div>
              </div>
            </div>

            <h3 class="hover:text-link-400 dark:hover:text-link-200 mb-2 text-2xl font-semibold">{{ $blog->titulo }}
            </h3>
            <div class="">
              <p class="line-clamp-3 text-justify text-sm text-slate-200 dark:text-slate-300">
                {{ $blog->descripcion_corta }}
              </p>
            </div>
            <div class="flex items-center justify-between">
              <div class="flex items-center justify-center gap-3">
                <div class="flex items-center justify-center gap-1">
                  <i class="fa-solid fa-thumbs-up"></i>
                  <p>{{ $blog->likes->count() }}</p>
                </div>
                <div class="flex items-center justify-center gap-1">
                  <i class="fa-solid fa-comment"></i>
                  <livewire:contador-comentarios :blog="$blog" />
                </div>
              </div>
              <div class="flex items-center justify-center gap-3 text-sm">
                <div class="flex items-center gap-1">
                    <img src="{{ $blog->autor->profile?->avatar
                    ? Storage::url($blog->autor->profile->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($blog->autor->nombre_completo) }}"
                    alt="Foto de {{ $post->autor->nombre_completo }}"
                    class="w-6 h-6 rounded-full object-cover">
                  <p class="capitalize text-[10.5px]">{{$blog->autor->nombre_completo}}</p>
                </div>
                <div class="flex items-center gap-1 text-[10.5px]">
                  <i class="fa-solid fa-calendar"></i>
                  {{ $blog->created_at->diffForHumans() }}
                </div>
              </div>
            </div>
          </div>
        </article>
      </a>
      @endforeach
    </div>
    {{ $blogs->links() }}
</div>
</section>
@endsection