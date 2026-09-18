@extends('components.layouts.principal')

@section('titulo')
Vacantes |
@endsection

@section('contenido')
<header>
  <div class="p-12 md:py-36 items-center mx-auto text-center bg-light-300 dark:bg-cont-100">
    <span class="text-link-400 dark:text-link-100 font-bold text-xs md:text-3xl"> Agencia de Diseño Gráfico, Fotografía
      eh Impresión</span>
    <h3 class="text-lg md:text-5xl font-extrabold my-5">Vacantes</h3>
    <p class="text-sm md:text-xl">
      Encuentra el trabajo de tus sueños; ofrecemos vacantes para
      diseñadores, desarrolladores, fotográfos, impresores y mucho más!
    </p>
  </div>
</header>
<div class="py-12">
  <div class="max-w-7xl mx-auto">     
      <div class="bg-light-300 dark:bg-cont-100 rounded-lg p-6 shadow-sm divide-y divide-slate-300">
        @livewire('vacantes')
         <div class="mt-4 m-5">
         {{ $vacantes->links('vendor.pagination.tailwind') }}
      </div>        
      </div>
  </div>
</div>
@endsection