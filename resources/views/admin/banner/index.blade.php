@extends('components.layouts.admin')

@section('contenido')
<div class="w-full flex justify-between items-center max-w-screen-xl mx-auto">
  <p class="text-xl font-semibold">
    Diapositivas Promo
  </p>
  @can('banner create')

  <a href="{{ route('admin.banner.create') }}" wire:navigate>
    <button
      class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 cursor-pointer">
      <i class="fa-solid fa-pen"></i>
      Crear diapositiva
    </button>
  </a>
  @endcan
</div>

<section class="pt-3">
  <div class="mx-auto max-w-screen-xl">
    <!-- Start coding here -->
    <div class="bg-light-200 dark:bg-cont-100 relative shadow-md rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left table-fixed">
          <thead class="uppercase bg-light-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-4 py-3">Id</th>
              <th scope="col" class="px-4 py-3">Titulo</th>
              <th scope="col" class="px-4 py-3">descipcion</th>
              <th scope="col" class="px-4 py-3">Banner</th>
              <th scope="col" class="px-4 py-3">Enlace</th>

              <th scope="col" class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($banners as $banner )
            <tr class="border-b dark:border-gray-700 ">
              <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap dark:text-white">
                {{ $banner->id }}
                </th>
              <td class="px-4 py-3">
                <p class="line-clamp-2">
                  {{ $banner->titulo }}
                </p>
              </td>
    
              <td class="px-4 py-3">
                <p class="line-clamp-1">
                  {{ $banner->descripcion }}
                </p>
              </td>              
              <td class="px-4 py-3">{{ $banner->banner }}</td>
              <td class="px-4 py-3">{{ $banner->enlace }}</td>

              <td class="px-4 py-3 flex items-center justify-start">
                <div class="flex items-center gap-2">                 
                  @can('banner edit')

                  <a href="{{ route('admin.banner.edit', $banner) }}">
                    <button
                      class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                  </a>
                  @endcan
                  @can('banner delete')

                  <form class="delete-form" action="{{ route('admin.banner.destroy', $banner) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
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