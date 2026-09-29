<div>
    <div class="flex items-center justify-between p-4 gap-2">
        <div class="md:w-2/3">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="md:w-1/2">
                <div class="relative w-full">
            
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
            
                    <input
                        type="text"
                        id="simple-search"
                        wire:model.live.debounce.400ms="busqueda"
                        class="w-full pl-12 pr-4 py-3 bg-transparent border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
                        placeholder="Buscar por nombre o correo"
                    >
            
                    {{-- Loader del buscador --}}
                    <div
                        wire:loading
                        wire:target="busqueda"
                        class="absolute inset-y-0 right-0 flex items-center pr-3"
                    >
                        <i class="fa-solid fa-circle-notch fa-spin text-gray-400"></i>
                    </div>
            
                </div>
            </div>
        </div>
        {{-- FILTRO --}}
    <div class="relative">

        {{-- BOTÓN --}}
        <button
            type="button"
            id="filterButton"
            data-dropdown-toggle="filterDropdown"
            class="flex items-center gap-2 px-4 py-3
            w-full pr-4 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
        >
            <i class="fa-solid fa-filter"></i>
            Filtros
        </button>


        {{-- DROPDOWN --}}
        <div
            id="filterDropdown"
            class="z-10 hidden absolute right-0 mt-2 w-64 p-4
                   bg-cont-200 rounded-lg shadow
                   dark:bg-nav-800"
        >

            <h6 class="mb-4 text-sm font-medium ">
                Filtrar usuarios
            </h6>

            {{-- ROL --}}
            <div class="mb-4">

                <label
                    for="rol"
                    class="block mb-2 text-sm font-medium
                          "
                >
                    Rol
                </label>

                <select
                    id="rol"
                    wire:model.live="rol"
                    class="w-full bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
                >
                    <option value="">
                        Todos los roles
                    </option>

                    <option value="Admin">Admin</option>
                    <option value="Editor">Editor</option>
                    <option value="Instructor">Instructor</option>
                    <option value="Vendedor">Vendedor</option>
                    <option value="Usuario">Usuario</option>
                </select>

            </div>


            {{-- ESTADO --}}
            <div class="mb-4">

                <label
                    for="verificado"
                    class="block mb-2 text-sm font-medium
                          "
                >
                    Estado
                </label>

                <select
                    id="verificado"
                    wire:model.live="verificado"
                    class="w-full bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
                >
                    <option value="">
                        Todos
                    </option>

                    <option value="Verificado">
                        Verificado
                    </option>

                    <option value="Pendiente">
                        Pendiente
                    </option>
                </select>

            </div>


            {{-- LIMPIAR --}}
            <button
                type="button"
                wire:click="$set('rol', ''); $set('verificado', '')"
                class="w-full px-3 py-2 text-sm font-medium
                       text-white bg-btn-200 rounded-md
                       hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-all"
            >
                <i class="fa-solid fa-filter-circle-xmark mr-1"></i>
                Limpiar filtros
            </button>

        </div>

    </div>
    
      </div>
      <div class="w-full overflow-x-auto relative">
        {{-- Loader --}}
        <div
            wire:loading.flex
            wire:target="busqueda,rol,verificado"
            class="absolute inset-0 z-10
                   items-center justify-center
                   bg-white/60 dark:bg-gray-900/60
                   backdrop-blur-[1px]"
        >
            <div class="flex flex-col items-center gap-2">
    
                <i class="fa-solid fa-circle-notch fa-spin text-3xl text-purple-500"></i>
    
                <span class="text-sm text-gray-600 dark:text-gray-300">
                    Buscando usuarios...
                </span>
    
            </div>
        </div>
        <table class="w-full min-w-250 text-sm text-left table-auto">
          <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-4 py-3">Id</th>
              <th scope="col" class="px-4 py-3">Nombre Completo</th>
              <th scope="col" class="px-4 py-3">Rol</th>
              <th scope="col" class="px-4 py-3">Correo</th>
              <th scope="col" class="px-4 py-3">Nombre de usuario</th>
              <th scope="col" class="px-4 py-3">Verificado</th>
              <th scope="col" class="px-4 py-3">Creado</th>
              <th scope="col" class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)

            <tr class="border-b dark:border-gray-700">
        
                <th
                    scope="row"
                    class="px-4 py-3 font-medium whitespace-nowrap dark:text-white"
                >
                    {{ $user->id }}
                </th>
        
                <td class="px-4 py-3">
                    {{ $user->nombre_completo }}
                </td>
        
                <td class="px-4 py-3">
                    @foreach ($user->roles as $role)
        
                        @php
                            $color = match($role->name) {
                                'Admin' => 'bg-red-600 text-white',
                                'Editor' => 'bg-link-600 text-white',
                                'Instructor' => 'bg-yellow-400 text-black',
                                'Usuario' => 'bg-btn-400 text-white',
                                'Vendedor' => 'bg-gray-400 text-white',
                                default => 'bg-nav-500 text-white',
                            };
                        @endphp
        
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $color }}">
                            {{ $role->name }}
                        </span>
        
                    @endforeach
                </td>
        
                <td class="px-4 py-3">
                    {{ $user->email }}
                </td>
        
                <td class="px-4 py-3">
                    {{ $user->username }}
                </td>
        
                <td class="px-4 py-3">
        
                    @if ($user->is_verified === 'Pendiente')
        
                        <span class="bg-red-700 text-white
                                     inline-flex items-center justify-center
                                     rounded-md border border-transparent
                                     px-2 py-0.5 text-xs font-medium
                                     whitespace-nowrap">
                            {{ $user->is_verified }}
                        </span>
        
                    @else
        
                        <span class="bg-green-700 text-white
                                     inline-flex items-center justify-center
                                     rounded-md border border-transparent
                                     px-2 py-0.5 text-xs font-medium
                                     whitespace-nowrap">
                            {{ $user->is_verified }}
                        </span>
        
                    @endif
        
                </td>
        
                <td class="px-4 py-3">
                    {{ $user->created_at->format('d-m-Y') }}
                </td>
        
                <td class="px-4 py-3">
                    <div class="flex items-center justify-end gap-2">
        
                        @can('usuarios edit')
                            <a href="{{ route('admin.users.edit', $user) }}">
                                <button
                                    class="px-3 py-2 bg-btn-200
                                           hover:bg-btn-400
                                           dark:bg-btn-400
                                           dark:hover:bg-btn-600
                                           transition-colors duration-150
                                           rounded-md cursor-pointer"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </a>
                        @endcan
        
                        @can('usuarios delete')
                            <form
                                action="{{ route('admin.users.destroy', $user) }}"
                                class="delete-form"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
        
                                <button
                                    class="px-3 py-2 bg-btn-200
                                           hover:bg-btn-400
                                           dark:bg-btn-400
                                           dark:hover:bg-btn-600
                                           transition-colors duration-150
                                           rounded-md cursor-pointer"
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
                <td colspan="8" class="px-6 py-12 text-center">
        
                    <div class="flex flex-col items-center justify-center">
        
                        <i class="fa-solid fa-user-slash
                                  text-4xl text-gray-400
                                  dark:text-gray-500 mb-3">
                        </i>
        
                        <p class="text-base font-semibold text-gray-700 dark:text-gray-200">
                            Usuario no encontrado
                        </p>
        
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            No encontramos usuarios que coincidan con tu búsqueda o filtros.
                        </p>
        
                    </div>
        
                </td>
            </tr>
        
        @endforelse
             
          </tbody>
        </table>
      </div>
      <div class="m-5">
        {{ $users->links('vendor.pagination.tailwind') }}
     </div>

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
</div>
