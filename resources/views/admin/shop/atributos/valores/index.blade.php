@extends('components.layouts.admin')

@section('contenido')

<div class="mx-auto max-w-7xl">

    <div class="bg-light-200 dark:bg-cont-100 shadow-md rounded-lg overflow-hidden">

        <div class="p-5 border-b border-gray-200 dark:border-gray-700">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>

                    <div class="flex items-center gap-2 mb-1">

                        <a
                            href="{{ route('admin.atributo.index') }}"
                            wire:navigate
                            class="text-gray-500 hover:text-link-200"
                        >
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>

                        <h2 class="text-xl font-semibold">
                            Valores de {{ $productoAttribute->nombre }}
                        </h2>

                    </div>

                    <p class="text-sm ">
                        Administra los valores disponibles para este atributo.
                    </p>

                </div>


                <a
                    href="{{ route('admin.atributo.valor.create', $productoAttribute) }}"
                    wire:navigate
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-md bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-all"
                >
                    <i class="fa-solid fa-plus"></i>
                    Nuevo valor
                </a>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">

                    <tr>

                        <th class="px-6 py-3">
                            ID
                        </th>

                        <th class="px-6 py-3">
                            Valor
                        </th>

                        @if ($productoAttribute->tipo === 'color')

                            <th class="px-6 py-3">
                                Color
                            </th>

                        @endif

                        <th class="px-6 py-3">
                            Slug
                        </th>

                        <th class="px-6 py-3">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($valores as $valor)

                        <tr class="border-b dark:border-gray-700">

                            <td class="px-6 py-4">
                                {{ $valor->id }}
                            </td>

                            <td class="px-6 py-4 font-medium">
                                {{ $valor->valor }}
                            </td>


                            @if ($productoAttribute->tipo === 'color')

                                <td class="px-6 py-4">

                                    @if ($valor->codigo)

                                        <div class="flex items-center gap-2">

                                            <span
                                                class="w-6 h-6 rounded-full border border-gray-300"
                                                style="background-color: {{ $valor->codigo }}"
                                            ></span>

                                            {{ $valor->codigo }}

                                        </div>

                                    @else

                                        <span class="text-gray-400">
                                            Sin color
                                        </span>

                                    @endif

                                </td>

                            @endif


                            <td class="px-6 py-4">
                                {{ $valor->slug }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="flex items-center gap-2">

                                    <a
                                        href="{{ route('admin.atributo.valor.edit', [$productoAttribute, $valor]) }}"
                                        wire:navigate
                                        class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>


                                    <form class="delete-form"
                                        action="{{ route('admin.atributo.valor.destroy', [$productoAttribute, $valor]) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ $productoAttribute->tipo === 'color' ? 5 : 4 }}"
                                class="px-6 py-10 text-center"
                            >
                                No hay valores registrados.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div class="p-5">
            {{ $valores->links() }}
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
  document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        Swal.fire({
                  title: "¿Estás seguro?",
                  text: "¡No podrás revertir esto!",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Sí, eliminar",
                  cancelButtonText: "Cancelar",
                  background: "#120024",
                  color: "#ffffff",
                }).then((result) => {
                  if(result.isConfirmed) {
                    form.submit();
                  }
                })
      })
    })
</script>
@endpush