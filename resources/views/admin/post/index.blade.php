@extends('components.layouts.admin')

@section('contenido')
<div class="w-full flex justify-between items-center max-w-7xl mx-auto">
  <p class="text-xl font-semibold">
    Blog
  </p>
  @can('blog create')

  <a href="{{ route('admin.blogs.create') }}" >
    <button
      class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 cursor-pointer">
      <i class="fa-solid fa-pen"></i>
      Crear blog
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
          <thead class="uppercase bg-light-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-4 py-3">Id</th>
              <th scope="col" class="px-4 py-3">Titulo</th>
              <th scope="col" class="px-4 py-3">Imagen</th>
              <th scope="col" class="px-4 py-3">Slug</th>
              <th scope="col" class="px-4 py-3">Estado</th>
              <th scope="col" class="px-4 py-3">Categoria</th>
              <th scope="col" class="px-4 py-3">Usuario</th>
              <th scope="col" class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($blogs as $blog )
            <tr class="border-b dark:border-gray-700 ">
              <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap dark:text-white">
                {{ $blog->id }}
                </th>
              <td class="px-4 py-3">
                <p class="line-clamp-2">
                  {{ $blog->titulo }}
                </p>
              </td>
              <td class="px-4 py-3">
                <img src={{ $blog->imagen ? Storage::url($blog->imagen) : 'NULL' }} alt={{ $blog->titulo }} className="w-20 h-20 object-cover
                rounded-md" />
              </td>
              </p>
              <td class="px-4 py-3">
                <p class="line-clamp-1">
                  {{ $blog->slug }}
                </p>
              </td>
              <td class="px-4 py-3">
                <span>
                  @if ($blog->estado === 'borrador')
                  <span
                    class="border-transparent bg-red-700 text-white capitalize inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0">
                    {{ $blog->estado}}
                  </span>
                  @else
                  <span
                    class="border-transparent bg-green-700 text-white capitalize inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0">
                    {{ $blog->estado}}
                  </span>
                  @endif
                </span>
              </td>
              <td class="px-4 py-3">{{ $blog->categoriaPost->nombre }}</td>
              <td class="px-4 py-3">{{ $blog->autor->nombre_completo }}</td>
              <td class="px-4 py-3 flex items-center justify-start">
                <div class="flex items-center gap-2">
                  @can('blog show')
                  <a href="{{ route('admin.blogs.show', $blog) }}" wire:navigate>
                    <button
                      class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer">
                      <i class="fa-solid fa-eye"></i>
                    </button>
                  </a>
                  @endcan
                  @can('blog edit')

                  <a href="{{ route('admin.blogs.edit', $blog) }}">
                    <button
                      class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                  </a>
                  @endcan
                  @can('blog delete')

                  <form class="delete-form" action="{{ route('admin.blogs.destroy', $blog) }}" method="POST">
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
      <div class="m-5">
        {{ $blogs->links('vendor.pagination.tailwind') }}
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