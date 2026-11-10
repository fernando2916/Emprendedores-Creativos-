@extends('components.layouts.admin')

@section('contenido')
<div class="w-full flex justify-between items-center max-w-7xl mx-auto">
  <p class="text-xl font-semibold">
    Productos
  </p>
  @can('producto create')

  <a href="{{ route('admin.producto.create') }}" wire:navigate>
    <button
      class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 cursor-pointer">
      <i class="fa-solid fa-pen"></i>
      Crear producto
    </button>
  </a>
  @endcan
</div>

<section class="pt-3">
  <div class="mx-auto max-w-7xl">
    <!-- Start coding here -->
    <div class="bg-light-200 dark:bg-cont-100 relative shadow-md rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left table-auto">
          <thead class="uppercase bg-light-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-4 py-3">Id</th>
              <th scope="col" class="px-4 py-3">Nombre</th>
              <th scope="col" class="px-4 py-3">Marca</th>
              <th scope="col" class="px-4 py-3">Licencia</th>
              <th scope="col" class="px-4 py-3">Categoria</th>
              <th scope="col" class="px-4 py-3">Sub Categoria</th>
              <th scope="col" class="px-4 py-3">Etiqueta</th>
              <th scope="col" class="px-4 py-3">Estado</th>
              <th scope="col" class="px-4 py-3">Destacado</th>
              <th scope="col" class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($productos as $producto)

            <tr class="border-b dark:border-gray-700">

                <td class="px-6 py-4">
                    {{ $producto->id }}
                </td>

                <td class="px-6 py-4 font-medium">
                    {{ $producto->nombre }}
                </td>

                <td class="px-6 py-4">
                    {{ $producto->brand?->nombre ?? 'Sin marca' }}
                </td>
                <td class="px-6 py-4">
                    {{ $producto->license?->nombre ?? 'Sin licencia' }}
                </td>
                <td class="px-6 py-4">
                    {{ $producto->categoria?->nombre ?? 'Sin Categoria'  }}
                </td>
                <td class="px-6 py-4">
                    {{ $producto->subCategoria?->nombre ?? 'Sin Sub categoria' }}
                </td>
                <td class="px-6 py-4">
                    @forelse ($producto->tags as $tag)

                <span class="inline-block px-2 py-1 mb-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                    {{ $tag->nombre }}
                </span>

            @empty

                <span class="text-sm text-gray-500">
                    Sin etiquetas
                </span>

            @endforelse
                </td>

                <td class="px-6 py-4">

                    @if ($producto->estado)

                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-800">
                            Activo
                        </span>

                    @else

                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-800">
                            Inactivo
                        </span>

                    @endif

                </td>
                <td class="px-6 py-4">

                    @if ($producto->destacado)

                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-800">
                            Si
                        </span>

                    @else

                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-800">
                            No
                        </span>

                    @endif

                </td>

                <td class="px-6 py-4">

                    <div class="flex items-center gap-2">
                        @can('producto edit')
                        <a
                            href="{{ route('admin.producto.edit', $producto) }}"
                            wire:navigate
                            class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer"
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        @endcan
                        @can('producto delete')
                        <form
                        class="delete-form"
                            action="{{ route('admin.producto.destroy', $producto) }}"
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
                        @endcan

                    </div>

                </td>

            </tr>

        @empty

            <tr>
                <td
                    colspan="5"
                    class="px-6 py-10 justify-center mx-auto text-center"
                >
                    No hay productos registradas.
                </td>
            </tr>

        @endforelse

          </tbody>
        </table>
      </div>     
      <div class="m-5">
           {{ $productos->links('vendor.pagination.tailwind') }}
        </div>
    </div>
  </div>
</section>

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