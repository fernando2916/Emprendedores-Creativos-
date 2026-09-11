@extends('components.layouts.principal')

@section('titulo')
 {{ $proyect->titulo }} | Diseño Gráfico - Proyectos
@endsection

@section('contenido')
<header class="relative bg-cover z-10 dark:bg-cont-100 bg-light-300 h-72">
  <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
        <h3 class="text-4xl lg:text-5xl font-bold text-white drop-shadow-md">
            {{ $proyect->titulo }}
        </h3>
        <p class="mt-4 text-sm md:text-lg lg:text-xl text-white max-w-2xl drop-shadow-sm">
            {{ $proyect->descripcion }}
        </p>
    </div>
</header>

<section class="max-w-6xl mx-auto p-5">
  <!-- Imagen principal -->
  <div class="w-full mb-6">
    <img src="{{ Storage::url($proyect->image_principal) }}" 
         alt="Imagen principal del proyecto"
         class="w-full rounded-lg shadow-lg object-cover">
  </div>

  <!-- Galería inferior -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    @if($proyect->image_second)
    <img src="{{ Storage::url($proyect->image_second) }}" 
         alt="Imagen secundaria 1"
         class="w-full rounded-md shadow-md object-cover">
    @endif

    @if($proyect->image_third)
    <img src="{{ Storage::url($proyect->image_third) }}" 
         alt="Imagen secundaria 2"
         class="w-full rounded-md shadow-md object-cover">
    @endif

    @if($proyect->image_fourth)
    <img src="{{ Storage::url($proyect->image_fourth) }}" 
         alt="Imagen secundaria 3"
         class="w-full rounded-md shadow-md object-cover">
    @endif
  </div>
  <div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

  <!-- Detalles generales -->
  <div class="space-y-2">
    <h3 class="text-xl font-bold">Detalle de Proyecto</h3>
    <p class="text-sm text-gray-400"><span class="font-semibold text-white">Cliente:</span> {{ $proyect->cliente }}</p>
    <p class="text-sm text-gray-400"><span class="font-semibold text-white">Fecha: </span> {{$proyect->created_at->format('M-Y')}}</p>
  </div>

  <!-- Bloques de texto con 1½ columnas cada uno -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 rounded-lg">

    <!-- Primer bloque de texto: col-span-2 -->
    <div class="md:col-span-2">
      <p class="text-white">
        {{ $proyect->descripcion }}
      </p>
    </div>

    <!-- Segundo bloque de texto: col-span-2 -->
    <div class="md:col-span-2">
      <p class="text-white">
       {{$proyect->objetivo}}
      </p>
    </div>

  </div>

</div>
</section>
@endsection