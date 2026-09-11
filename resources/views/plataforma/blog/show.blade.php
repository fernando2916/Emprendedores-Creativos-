@extends('components.layouts.principal')

@section('titulo')
{{ $blog->titulo }} | Blog
@endsection

@section('contenido')
<section class="bg-light-200 dark:bg-cont-100 py-8">
  <div class="mx-auto grid w-full max-w-300 grid-cols-10 items-center gap-8 px-6">
    <div class="order-2 col-span-full lg:order-1 lg:col-span-5">
      <h1 class="mb-4 text-[2rem] leading-9">{{ $blog->titulo }}</h1>
      <p class="mb-5 text-justify">{{ $blog->descripcion_corta }}</p>
      <div class="mb-4 flex flex-col gap-2">
        <div class="flex items-center gap-1">
          <i class="fa-solid fa-tag text-btn-200 dark:text-btn-400"></i>
          {{ $blog->categoriaPost->nombre }}
        </div>
        <div class="flex items-center gap-1">
          <i class="fa-solid fa-eye text-btn-200 dark:text-btn-400"></i> {{ $blog->tiempo_de_lectura }} min.
        </div>
        <div class="flex items-center gap-1">
          <i class="fa-solid fa-calendar text-btn-200 dark:text-btn-400"></i>
          {{ $blog->created_at->diffForHumans() }}
        </div>
      </div>
      <div class="">
        @livewire('shared-post', ['blog' => $blog])
      </div>
    </div>
    <div class="order-1 col-span-full overflow-hidden rounded-lg lg:order-2 lg:col-span-5">
      <img src={{ $blog->imagen ? Storage::url($blog->imagen) : '' }} alt=""
      class="aspect-video w-full rounded-t-md object-cover" />
    </div>
  </div>
</section>
<section class="py-8">
  <div class="mx-auto grid w-full max-w-300 grid-cols-10 gap-8 px-6">
    <div class="col-span-full lg:col-span-7">
      <article class="dark:bg-cont-100 col-span-full rounded-lg bg-light-200 p-4 lg:col-span-7 lg:p-8">
        <div class=" rounded-md p-3 text-lg post-content ql-editor">
          {!! $blog->contenido !!}
        </div>
      </article>
    </div>
    <aside class="col-span-full flex flex-col gap-8 lg:col-span-3">
      <article
        class="dark:bg-cont-100 before:bg-btn-400 relative overflow-hidden rounded-lg bg-light-300 p-6 shadow-md before:absolute before:top-0 before:left-0 before:h-full before:w-1">
        <h3 class="mb-4 text-xl leading-6">Autor del Artículo</h3>
        <span class=""></span>
        <div>
          <div class="flex gap-2">

            <img src="{{ $blog->autor->profile?->avatar
            ? Storage::url($blog->autor->profile->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($blog->autor->nombre_completo) }}"
            alt="Foto de {{ $blog->autor->nombre_completo }}"
            class="w-10 h-10 rounded-full object-cover">
            <div class="">

                <p class="flex gap-2 font-semibold">
                    {{ $blog->autor->nombre_completo }}
                </p>
                <small>{{ $blog->autor->username }}</small>
            </div>
          </div>
          <p class="flex items-center gap-2 ml-12">
            <a href="/#" wire:navigate class="text-link-100 text-sm cursor-pointer">
            Ver perfil
            </a>
          </p>
        </div>
      </article>
      <article
        class="dark:bg-cont-100  before:bg-nav-400 relative overflow-hidden rounded-lg bg-light-300 p-6 shadow-md before:absolute before:top-0 before:left-0 before:h-1 before:w-full">
        <div class="flex items-center justify-between gap-3">          
          <div class="flex items-center gap-2 text-2xl">
            @auth
              
            <livewire:like-post :blog="$blog"/>
            @endauth
            <i class="fa-solid fa-heart"></i>
            <span class=""> 0</span>
          </div>
          <div class="flex items-center gap-2 text-2xl">
            <i class="fa-solid fa-comment"></i>
            <livewire:contador-comentarios :blog="$blog"/>
          </div>
          <div class="flex items-center gap-2 text-2xl">
            <i class="fa-solid fa-share"></i>
            {{-- <span class=""> {{ $blog->share_count }} </span> --}}
            <livewire:contador-shared :blog="$blog"/>
          </div>
        </div>
      </article>
    </aside>
  </div>
</section>
<section class="pb-12" aria-labelledby="commets-title">
  <div class="mx-auto grid w-full max-w-300 grid-cols-10 gap-8 px-1">
    @livewire('comentario-post', ['blog' => $blog])
</section>
@endsection