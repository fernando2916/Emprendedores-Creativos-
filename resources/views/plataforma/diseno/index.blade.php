@extends('components.layouts.principal')

@section('titulo')
Diseño Gráfico |
@endsection

@section('contenido')
<header class="relative bg-cover md:h-180 lg:h-180">
  <img src="{{ asset('images/disenadores.webp') }}" alt="diseñadores" class="opacity-30 h-full w-full object-cover">
  <div class="absolute w-full h-full flex flex-col top-0 items-center justify-center ">
    <div class="text-center p-3 space-y-3 md:space-y-7 relative lg:-top-24">
      <span class=" font-bold text-sm md:text-3xl">
        Agencia de Diseño Gráfico
      </span>
      <h3 class="text-2xl md:text-7xl xl:text-9xl font-extrabold">
        Diseño Gráfico -
      </h3>
      <div class="text-link-300 dark:text-link-100 text-3xl md:text-7xl xl:text-8xl font-extrabold md:mt-1">
        <span id="typewriter" class=""></span>
      </div>
      <p class="text-lg md:text-4xl">
        Diseñamos profesionalmente cuidando todos los detalles.
      </p>
    </div>
  </div>
</header>

<main>
  <section class="my-10 space-y-5">
    <div class="mx-5 lg:mx-auto lg:container flex justify-center text-center text-xl md:text-4xl">
      Somos diseñadores con experiencia en creación de marca, fotografía,
      diseño web, editorial, entre otras, con más de 5 años de
      experiencia.
    </div>
    <div class="mx-5 lg:mx-auto lg:container pt-10 flex text-justify justify-center text-xl ">
      <div>
        En
        <span class="text-link-100">Emprendedores Creativos&copy;</span>
        hemos desarrollado un proceso creativo y que evoluaciona para crear marcas únicas,
        nos encargamos de implementar de forma integral toda la
        comunicación visual en los diferentes medios digitales e impresos,
        aumentando con ello el reconocimmiento de la marca y la atracción
        de clientes potenciales.
      </div>
    </div>
  </section>
</main>
@include('plataforma.diseno.info', [$planes, $opiniones])

<section class="py-10 px-8 mx-auto items-center">
  <div class=" text-center max-w-4xl mx-auto">
    <p class="mt-2 font-bold tracking-tight text-5xl leading-none">
      Proyectos que ha realizado la agencia.
    </p>
  </div>
  <p class="mt-5">
    Emprendedores Creativos® es una agencia de Diseño especializada en Identidad corporativa, Imagen corporativa,
    Fotografía eh Impresión. ¡Nuestro objetivo es proporcionar una ventanilla única para todas sus necesidades
    creativas!
  </p>
  <div class="max-w-7xl mx-auto mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
    @forelse ($proyects as $proyecto )
    <a href="{{ route('diseno.show', $proyecto->slug) }}" wire:navigate class="">
    <div class="relative group w-full max-w-md overflow-hidden rounded-md shadow-lg ">
      <img src="{{ Storage::url($proyecto->image_principal) }}" alt="{{ $proyecto->titulo }}"
        class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-125">

      <div
        class="absolute inset-0 bg-black/60 flex justify-center items-end opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <div
          class="text-center p-4 transform translate-y-10 group-hover:translate-y-0 transition-all duration-500 ease-in-out">
          <h3 class="text-white text-lg font-semibold">{{ $proyecto->titulo }}</h3>
          <p class="text-gray-200 text-sm">{{ $proyecto->cliente }}</p>
        </div>
      </div>
    </div>
    </a>
    @empty
    <div class="">
      No hay proyecto aún.
    </div>
    @endforelse
  </div>
</section>
@endsection