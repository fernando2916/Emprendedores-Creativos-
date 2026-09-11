@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.plans.index'), 'label' => 'Planes', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Plan']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div class="">
    <div class="">
      <h3 class="text-3xl font-bold">Editar Plan</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.plans.update', $plane->id) }}" method="POST" noValidate class="space-y-3"
        >
        @csrf
        @method('PUT')
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Titulo del
            PLan</label>
          <input id="name" name="titulo" value="{{ old('titulo', $plane->titulo) }}" type="text" placeholder="Titulo" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('titulo')
          dark:border-alerts-500
          @enderror"  />
          @error('titulo')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Descripción</label>
          <input id="name" name="descripcion" value="{{ old('descripcion', $plane->descripcion) }}" type="text"
            placeholder="precio" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('descripcion_corta')
          dark:border-alerts-500
          @enderror">
          @error('descripcion')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Precio</label>
          <input id="name" name="precio" value="{{ old('precio', $plane->precio) }}" type="text"
            placeholder="precio" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('descripcion_corta')
          dark:border-alerts-500
          @enderror">
          @error('precio')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>


        <div>
          <p class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Contenido</p>
          <div class="" id="editor">
             {!!old('contenido', $plane->contenido)!!}
          </div>
          @error('contenido')
          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
          <textarea name="contenido" id="contenido" class="hidden"></textarea>
        </div>

        @if(session('message'))
        <p class="text-red-500 text-sm mt-2">{{ session('message') }}</p>
        @endif

        <button type="submit"
          class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full mt-5">
          Actualizar Plan
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
