@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.opinion.index'), 'label' => 'Opiniones', 'navigate' => true],
    ['url' => '', 'label' => 'Crear Opinión']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div class="">
    <div class="">
      <h3 class="text-3xl font-bold">Crear Opinión</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.opinion.store') }}" method="POST" noValidate class="space-y-3"
        >
        @csrf
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Opinión</label>
          <input id="name" name="opinion" value="{{ old('opinion') }}" type="text" placeholder="Opinión" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('opinion')
          dark:border-alerts-500
          @enderror" />
          @error('opinion')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Autor</label>
          <input id="name" name="autor" value="{{ old('autor') }}" type="text"
            placeholder="Nombre del autor" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('autor')
          dark:border-alerts-500
          @enderror">
          @error('autor')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Red Social</label>
          <input id="name" name="red_social" value="{{ old('red_social') }}" type="text"
            placeholder="Facebook, Twitter, Instagram" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('red_social')
          dark:border-alerts-500
          @enderror">
          @error('red_social')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        @if(session('message'))
        <p class="text-red-500 text-sm mt-2">{{ session('message') }}</p>
        @endif

        <button type="submit"
          class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full mt-5 cursor-pointer">
          Crear Opinion
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
