@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.terminos.index'), 'label' => 'Terminos y condiciones', 'navigate' => true],
    ['url' => '', 'label' => 'Crear Terminos y condiciones']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div class="">
    <div class="">
      <h3 class="text-3xl font-bold">Crear terminos y conficiones</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.terminos.store') }}" method="POST" noValidate class="space-y-3"
        enctype="multipart/form-data">
        @csrf
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Ttitulo</label>
          <input id="name" name="titulo" value="{{ old('titulo') }}" type="text" placeholder="Titulo" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('titulo')
          dark:border-alerts-500
          @enderror"/>
          @error('titulo')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">
            Fecha
        </label>
          <input id="name" name="fecha" value="{{ old('fecha') }}" type="date"
            placeholder="fecha" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('fecha')
          dark:border-alerts-500
          @enderror">
          @error('fecha')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
            <p class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Contenido</p>
            <div class="" id="editor">
  
            </div>
            @error('contenido')
            <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
            @enderror
            <textarea name="contenido" id="contenido" class="hidden"></textarea>
          </div>
        <input type="hidden" name="content" id="content">


        <button type="submit"
          class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full mt-5 cursor-pointer">
          Crear Terminos
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
