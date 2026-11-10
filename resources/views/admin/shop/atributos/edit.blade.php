@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.atributo.index'), 'label' => 'Atributos', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Atributo']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div>
    <div>
      <h3 class="text-3xl font-bold">Editar Atributo</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.atributo.update', $atributo) }}" method="POST" noValidate class="space-y-3"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- Nombre --}}
        <div>
            <label
                for="nombre"
                class="block mb-2 text-sm font-medium"
            >
                Nombre
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre', $atributo->nombre) }}"
                placeholder="Ej. Talla"
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


        {{-- Tipo --}}
        <div>

            <label
                for="tipo"
                class="block mb-2 text-sm font-medium"
            >
                Tipo de atributo
            </label>

            <select
                id="tipo"
                name="tipo"
                class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all  @error('estado')
                dark:border-alerts-500
                @enderror"
            >

            <option
            value="select"
            @selected(old('tipo', $atributo->tipo) === 'select')
        >
            Selección
        </option>

        <option
            value="color"
            @selected(old('tipo', $atributo->tipo) === 'color')
        >
            Color
        </option>

        <option
            value="text"
            @selected(old('tipo', $atributo->tipo) === 'text')
        >
            Texto
        </option>

            </select>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Define cómo se mostrará este atributo al seleccionar una variante.
            </p>

            @error('tipo')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Estado --}}
        <div>

            <label
                for="estado"
                class="block mb-2 text-sm font-medium"
            >
                Estado
            </label>

            <select
                id="estado"
                name="estado"
                class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all  @error('estado')
                dark:border-alerts-500
                @enderror"
            >

            <option
            value="1"
            @selected(old('estado', $atributo->estado ? '1' : '0') == '1')
        >
            Activo
        </option>

        <option
            value="0"
            @selected(old('estado', $atributo->estado ? '1' : '0') == '0')
        >
            Inactivo
        </option>

            </select>

        </div>

        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.atributo.index') }}"
                wire:navigate
                class="bg-red-600 hover:bg-red-800 dark:bg-red-500 text-white dark:hover:bg-red-700 duration-300 transition-colors rounded-md px-3 py-2 mt-5 cursor-pointer"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 mt-5 cursor-pointer"
            >
                Crear atributo
            </button>

        </div>
      </form>
    </div>
  </div>
</div>
@endsection
