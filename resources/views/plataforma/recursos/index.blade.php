@extends('components.layouts.principal')

@section('titulo')
Recursos |
@endsection

@section('contenido')
<header>
  <div class="relative bg-cover md:h-260 z-10">
    <img src="{{ asset('images/disenadores.webp') }}" alt="diseñadores" class="opacity-30 h-full w-full object-cover">
    <div class="absolute w-full h-full flex flex-col top-0 items-center justify-center ">
      <div class="text-center p-3 space-y-3 md:space-y-7 relative lg:-top-24">
              <span class=" text-link-100 font-bold text-xs md:text-3xl">
                Agencia de Diseño Gráfico
              </span>
              <h3 class="text-lg md:text-5xl font-extrabold">
                Recursos para diseñadores gráficos, freelances y
                estudiantes.
              </h3>
              <p class="text-sm md:text-xl">
                Fotos, plantillas, mockups, compatible con la paqueteria adobe y nuevas herramientas como Affinity.  
              </p>
            </div>
    </div>
  </div>
</header>
<div class="m-2">
        <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5 pt-3">
          @forelse ( $recursos as $recurso )
          <li>
            <div class="bg-light-300 dark:bg-cont-100 rounded-2xl">
              <div class="relative">
                <img src="{{  $recurso->imagen ? Storage::url($recurso->imagen) : ''  }}" alt="{{ $recurso->nombre }}" class="aspect-video w-full object-cover rounded-t-2xl" />
              <div class="bg-categoria-200 text-white dark:bg-categoria-300 py-1 rounded-md px-2 text-sm font-bold absolute top-3 left-3">
                <span class="font-semibold text-base text-white p-2">{{ $recurso->formato }}</span>
              </div>
              </div>
              <div class="p-3">
                <h3 class="text-xl font-semibold text-btn-50 dark:text-btn-200">
                  {{ $recurso->nombre }}
                </h3>
                <p class="">{{ $recurso->categoria }}</p>               
                <div class="mb-3">
                  <p class=" text-justify line-clamp-2 post-content">
                   {!! $recurso->descripcion !!}
                  </p>                  
                </div>
              </div>

              <div class="flex items-center mx-auto justify-evenly gap-2 p-2">
                @if ($recurso->precio === 'Gratis')
                <button class="bg-btn-200  text-white dark:bg-btn-400  transition-colors duration-150 p-2 flex text-lg font-semibold rounded-md items-center gap-2"> 
                {{ $recurso->precio }}
              </button>
                  
                @else
                  <button class="bg-btn-200  text-white dark:bg-btn-400  transition-colors duration-150 p-2 flex text-lg font-semibold rounded-md items-center gap-2">
                <i class="fa-solid fa-dollar"></i>   
                {{ $recurso->precio }}
                MXN
              </button>
                @endif

              
              @if ($recurso->precio === 'Gratis')
             <a href="{{ route('recursos.download', $recurso->id) }}" class="">              
                <button class="bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 p-2 flex text-lg font-semibold mx-auto rounded-md items-center gap-2 cursor-pointer">
                  <i class="fa-solid fa-download"></i>   
                  Descargar
                </button>
              </a> 
              @else 
               <a href="" class="">              
              <button class="bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 p-2 flex text-lg font-semibold mx-auto rounded-md items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-shopping-cart"></i>   
                Agregar al carrito
              </button>
              </a>                 
              
              @endif
              </div>
            </div>
          </li>  
          @empty
            <div class="mx-auto text-center col-span-full py-10">
              <p class="text-3xl font-bold">Aún no hay recursos disponibles</p>
            </div>
          @endforelse
          
        </ul>
</div>
@endsection