@extends('components.layouts.admin')

@section('contenido')
<div class="w-full flex justify-between items-center max-w-7xl mx-auto">
  <p class="text-xl font-semibold">
    Proyectos
  </p>
  @can('proyectos create')

  <a href="{{ route('admin.proyecto.create') }}" wire:navigate>
    <button
      class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 cursor-pointer">
      <i class="fa-solid fa-plus"></i>
      Crear Proyecto
    </button>
  </a>
  @endcan
</div>

<section class="pt-3">
  <div class="mx-auto max-w-7xl">
    <!-- Start coding here -->
    <div class="bg-light-200 dark:bg-cont-100 relative shadow-md rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-4 py-3">Id</th>
              <th scope="col" class="px-4 py-3">Titulo</th>
              <th scope="col" class="px-4 py-3">Slug</th>
              <th scope="col" class="px-4 py-3">Imagen Pincipal</th>
              <th scope="col" class="px-4 py-3">Imagen dos</th>
              <th scope="col" class="px-4 py-3">Imagen tres</th>
              <th scope="col" class="px-4 py-3">Imagen cuatro</th>
              <th scope="col" class="px-4 py-3">Descripcion</th>
              <th scope="col" class="px-4 py-3">Marca</th>
              <th scope="col" class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($proyectos as $proyecto )
            <tr class="border-b dark:border-gray-700">
              <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap dark:text-white">{{ $proyecto->id
                }}</th>
              <td class="px-4 py-3">{{ $proyecto->titulo }}</td>
              <td class="px-4 py-3">{{ $proyecto->slug }}</td>
             
              <td class="px-4 py-3"><img src={{ $proyecto->image_principal ? Storage::url($proyecto->image_principal) : 'NULL' }} alt={{ $proyecto->titulo }} className="w-20 h-20 object-cover
                rounded-md" /></td>
              <td class="px-4 py-3"><img src={{ $proyecto->image_second ? Storage::url($proyecto->image_second) : 'NULL' }} alt={{ $proyecto->titulo }} className="w-20 h-20 object-cover
                rounded-md" /></td>
              <td class="px-4 py-3"><img src={{ $proyecto->image_third ? Storage::url($proyecto->image_third) : 'NULL' }} alt={{ $proyecto->titulo }} className="w-20 h-20 object-cover
                rounded-md" /></td>
              <td class="px-4 py-3"><img src={{ $proyecto->image_fourth ? Storage::url($proyecto->image_fourth) : 'NULL' }} alt={{ $proyecto->titulo }} className="w-20 h-20 object-cover
                rounded-md" /></td>
                <td class="px-4 py-3">{{ $proyecto->descripcion }}</td>
              <td class="px-4 py-3">{{ $proyecto->cliente }}</td>
              <td class="px-4 py-3 flex items-center justify-end">
                <div class="flex items-center gap-2">
                  @can('proyectos edit')

                  <a href="{{ route('admin.proyecto.edit', $proyecto) }}">
                    <button
                      class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                  </a>
                  @endcan
                  @can('proyectos delete')

                  <form action="{{ route('admin.proyecto.destroy', $proyecto) }}" class="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                      class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                  @endcan
                </div>
              </td>
            </tr>
            @endforeach
             
          </tbody>
        </table>
      </div>
      <div class="m-5">
         {{ $proyectos->links('vendor.pagination.tailwind') }}
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