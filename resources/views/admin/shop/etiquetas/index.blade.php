@extends('components.layouts.admin')

@section('contenido')
<div class="w-full flex justify-between items-center max-w-7xl mx-auto">
  <p class="text-xl font-semibold">
    Etiquetas
  </p>
  @can('tag create')

  <a href="{{ route('admin.etiqueta.create') }}" wire:navigate>
    <button
      class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 cursor-pointer text-xs md:text-base">
      <i class="fa-solid fa-pen"></i>
      Crear Etiqueta
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
              <th scope="col" class="px-4 py-3">Etiqueta</th>
              <th scope="col" class="px-4 py-3">Slug</th>
              <th scope="col" class="px-4 py-3">Productos</th>
              <th scope="col" class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($etiquetas as $etiqueta)

            <tr class="border-b dark:border-gray-700">

                <td class="px-6 py-4">
                    {{ $etiqueta->id }}
                </td>

                <td class="px-6 py-4 font-medium">
                    {{ $etiqueta->nombre }}
                </td>

                <td class="px-6 py-4">
                    {{ $etiqueta->slug }}
                </td>
                <td class="px-6 py-4">
                    {{ $etiqueta->productos_count }}
                </td>

                <td class="px-6 py-4">

                    <div class="flex items-center gap-2">
                        @can('tag edit')
                        <a
                            href="{{ route('admin.etiqueta.edit', $etiqueta) }}"
                            class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer"
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        @endcan
                        @can('tag delete')
                            <form
                            class="delete-form"
                                action="{{ route('admin.etiqueta.destroy', $etiqueta) }}"
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
                    class="px-6 py-10 text-center"
                >
                    No hay etiquetas registradas.
                </td>
            </tr>

        @endforelse

          </tbody>
        </table>
      </div>     
      <div class="m-5">
           {{ $etiquetas->links('vendor.pagination.tailwind') }}
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