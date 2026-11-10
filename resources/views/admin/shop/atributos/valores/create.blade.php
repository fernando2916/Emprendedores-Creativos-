@extends('components.layouts.admin')

@section('contenido')

<div class="mx-auto max-w-3xl">

    <div class="bg-light-200 dark:bg-cont-100 shadow-md rounded-lg">

        <div class="p-5 border-b border-gray-200 dark:border-gray-700">

            <h2 class="text-xl font-semibold ">
                Nuevo valor
            </h2>

            <p class="text-sm  mt-1">
                Atributo: {{ $productoAttribute->nombre }}
            </p>

        </div>


        <form
            action="{{ route('admin.atributo.valor.store', $productoAttribute) }}"
            method="POST"
            class="p-5 space-y-6"
        >

            @csrf


            {{-- Valor --}}
            <div>

                <label
                    for="valor"
                    class="block mb-2 text-sm font-medium "
                >
                    Valor
                </label>

                <input
                    type="text"
                    id="valor"
                    name="valor"
                    value="{{ old('valor') }}"
                    placeholder="Ej. M"
                    class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                >

                @error('valor')

                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Código de color --}}
            @if ($productoAttribute->tipo === 'color')

                <div>

                    <label
                        for="codigo"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >
                        Código de color
                    </label>

                    <div class="flex items-center gap-3">

                        <input
                            type="color"
                            id="codigo"
                            name="codigo"
                            value="{{ old('codigo', '#000000') }}"
                            class="w-14 h-10 rounded cursor-pointer"
                        >

                        <input
                            type="text"
                            id="codigo_text"
                            value="{{ old('codigo', '#000000') }}"
                            class="flex-1 rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            readonly
                        >

                    </div>

                    @error('codigo')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            @endif


            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('admin.atributo.valor.index', $productoAttribute) }}"
                    class="bg-red-600 hover:bg-red-800 dark:bg-red-500 text-white dark:hover:bg-red-700 duration-300 transition-colors rounded-md px-3 py-2 mt-5 cursor-pointer"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 mt-5 cursor-pointer"
                >
                    Guardar valor
                </button>

            </div>

        </form>

    </div>

</div>


@if ($productoAttribute->tipo === 'color')

<script>
    const color = document.getElementById('codigo');
    const colorText = document.getElementById('codigo_text');

    color?.addEventListener('input', function () {
        colorText.value = this.value;
    });
</script>
@endif

@endsection