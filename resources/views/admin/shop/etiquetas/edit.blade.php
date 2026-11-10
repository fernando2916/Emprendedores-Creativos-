@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.etiqueta.index'), 'label' => 'Etiquetas', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Etiqueta']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div>
    <div>
      <h3 class="text-3xl font-bold">Editar Etiqueta</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.etiqueta.update', $etiqueta) }}" method="POST" noValidate class="space-y-3"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>

            <label
                for="nombre"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
                Nombre de la etiqueta
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre', $etiqueta->nombre) }}"
                placeholder="Ej. Marvel"
                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('nombre')
                dark:border-alerts-500
                @enderror"
            >

            @error('nombre')

                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>
        <div>

            <label
                class="block mb-2 text-sm font-medium"
            >
                Slug actual
            </label>

            <div class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2">
                {{ $etiqueta->slug }}
            </div>

        </div>

        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.etiqueta.index') }}"
                wire:navigate
                class="bg-red-600 hover:bg-red-800 dark:bg-red-500 text-white dark:hover:bg-red-700 duration-300 transition-colors rounded-md px-3 py-2 mt-5 cursor-pointer"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors text-2xs md:text-base rounded-md px-3 py-2 mt-5 cursor-pointer"
            >
                Actualizar etiqueta
            </button>

        </div>
      </form>
    </div>
  </div>
</div>
@endsection
