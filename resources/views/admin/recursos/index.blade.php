@extends('components.layouts.admin')

@section('contenido')
<div class="w-full flex justify-between items-center max-w-7xl mx-auto">
  <p class="text-xl font-semibold">
    Recursos Gráficos
  </p>
  @can('recurso create')

  <a href="{{ route('admin.recursos.create') }}">
    <button
      class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 cursor-pointer">
      <i class="fa-solid fa-plus"></i>
      Crear Recurso
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
              <th scope="col" class="px-4 py-3">Nombre</th>
              <th scope="col" class="px-4 py-3">Categoria</th>
              <th scope="col" class="px-4 py-3">Formato</th>
              <th scope="col" class="px-4 py-3">Imagen</th>
              <th scope="col" class="px-4 py-3">Descripcion</th>
              <th scope="col" class="px-4 py-3">Etiquetas</th>
              <th scope="col" class="px-4 py-3">Precio</th>
              <th scope="col" class="px-4 py-3">Archivo</th>
              <th scope="col" class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($recursos as $recurso )
            <tr class="border-b dark:border-gray-700">
              <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap dark:text-white">{{ $recurso->id
                }}</th>
              <td class="px-4 py-3">{{ $recurso->nombre }}</td>
              <td class="px-4 py-3">{{ $recurso->categoria }}</td>
              <td class="px-4 py-3">{{ $recurso->formato }}</td>
              <td class="px-4 py-3"><img src={{ $recurso->imagen ? Storage::url($recurso->imagen) : 'NULL' }} alt={{ $recurso->titulo }} className="w-20 h-20 object-cover
                rounded-md" /></td>
              <td class="px-4 py-3">{{ $recurso->descripcion }}</td>
              <td class="px-4 py-3">{{ $recurso->etiqueta }}</td>
              <td class="px-4 py-3">$ {{ $recurso->precio }}</td>
              <td class="px-4 py-3">{{ $recurso->archivo }}</td>

              <td class="px-4 py-3 flex items-center justify-end">
                <div class="flex items-center gap-2">                   
                  @can('recurso edit')

                  <a href="{{ route('admin.recursos.edit', $recurso) }}">
                    <button
                      class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer ">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                  </a>
                  @endcan
                  @can('recurso delete')

                  <form action="{{ route('admin.recursos.destroy', $recurso) }}" class="delete-form" method="POST">
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
         {{ $recursos->links('vendor.pagination.tailwind') }}
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