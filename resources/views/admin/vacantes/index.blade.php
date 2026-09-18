@extends('components.layouts.admin')

@section('contenido')
<div class="w-full flex justify-between items-center max-w-7xl mx-auto">
  <p class="text-xl font-semibold">
    Vacantes
  </p>
  @can('vacante create')

  <a href="{{ route('admin.vacante.create') }}">
    <button
      class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 cursor-pointer">
      <i class="fa-solid fa-plus"></i>
      Crear Vacante
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
              <th scope="col" class="px-4 py-3">Puesto</th>
              <th scope="col" class="px-4 py-3">Modalidad</th>
              <th scope="col" class="px-4 py-3">Horario</th>
              <th scope="col" class="px-4 py-3">Empresa</th>
              <th scope="col" class="px-4 py-3">Salario</th>
              <th scope="col" class="px-4 py-3">Identificador</th>
              <th scope="col" class="px-4 py-3">Postulación</th>
              <th scope="col" class="px-4 py-3">Descripcion</th>
              <th scope="col" class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($vacantes as $vacante )
            <tr class="border-b dark:border-gray-700">
              <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap dark:text-white">{{ $vacante->id
                }}</th>
              <td class="px-4 py-3">{{ $vacante->puesto }}</td>
              <td class="px-4 py-3">{{ $vacante->modalidad }}</td>
              <td class="px-4 py-3">{{ $vacante->horario }}</td>
              <td class="px-4 py-3">{{ $vacante->empresa }}</td>
              <td class="px-4 py-3">{{ $vacante->salario }}</td>
              <td class="px-4 py-3">{{ $vacante->identificador }}</td>
              <td class="px-4 py-3">{{ $vacante->postulacion->format('d/m/Y') }}</td>
              <td class="px-4 py-3">{!! $vacante->descripcion !!}</td>
              <td class="px-4 py-3 flex items-center justify-end">
                <div class="flex items-center gap-2">
                   <a href="{{ route('candidatos.index', $vacante) }}" wire:navigate>
                    <button
                      class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer flex items-center gap-2">
                      {{ $vacante->candidatos->count() }}
                      <i class="fa-solid fa-eye"></i>
                    </button>
                  </a>
                  @can('vacante edit')

                  <a href="{{ route('admin.vacante.edit', $vacante) }}">
                    <button
                      class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer ">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                  </a>
                  @endcan
                  @can('vacante delete')

                  <form action="{{ route('admin.vacante.destroy', $vacante) }}" class="delete-form" method="POST">
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
         {{ $vacantes->links('vendor.pagination.tailwind') }}
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