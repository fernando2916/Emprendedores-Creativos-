@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.subcategoria.index'), 'label' => 'SubCategorias', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Sub Categoria']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div>
    <div>
      <h3 class="text-3xl font-bold">Editar Subcategoria</h3>
    </div>
    <div class="mt-5">
        <form
        action="{{ route('admin.subcategoria.update', $subcategoria) }}"
        method="POST"
        class="p-5 space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- Categoría --}}
        <div>

            <label
                for="categoria_id"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
                Categoría
            </label>

            <select
                id="categoiay_id"
                name="categoria_id"
                class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
            >

                @foreach ($categorias as $categoria)

                    <option
                        value="{{ $categoria->id }}"
                        @selected(old('category_id', $subcategoria->categoria_id) == $categoria->id)
                    >
                        {{ $categoria->nombre }}
                    </option>

                @endforeach

            </select>

            @error('categoria_id')

                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Nombre --}}
        <div>

            <label
                for="nombre"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
                Nombre
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre', $subcategoria->nombre) }}"
                class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
            >

            @error('nombre')

                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Estado --}}
        <div>

            <label
                for="estado"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
                Estado
            </label>

            <select
                id="estado"
                name="estado"
                class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
            >

                <option
                    value="1"
                    @selected(old('estado', $subcategoria->estado ? '1' : '0') == '1')
                >
                    Activa
                </option>

                <option
                    value="0"
                    @selected(old('estado', $subcategoria->estado ? '1' : '0') == '0')
                >
                    Inactiva
                </option>

            </select>

        </div>


        {{-- Botones --}}
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.subcategoria.index') }}"
                class="bg-red-600 hover:bg-red-800 dark:bg-red-500 text-white dark:hover:bg-red-700 duration-300 transition-colors rounded-md px-3 py-2 mt-5 cursor-pointer"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 mt-5 cursor-pointer text-2xs md:text-base"
            >
                Actualizar subcategoría
            </button>

        </div>

    </form>
    </div>
  </div>
</div>
@endsection
