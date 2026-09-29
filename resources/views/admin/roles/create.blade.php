@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.roles.index'), 'label' => 'Roles', 'navigate' => true],
    ['url' => '', 'label' => 'Crear Rol']  {{-- Último elemento desactivado --}}
]" />

<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
    <div class="">
        <div class="">
            <h3 class="text-3xl font-bold">Crear Rol</h3>
        </div>
        <div class="">
            <form action="{{ route('admin.roles.store') }}" method="POST" noValidate>
                @csrf
                <div>
                    <label for="name"
                        class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Nombre del
                        rol</label>
                    <input id="name" name="name" value="{{ old('name') }}" type="text" placeholder="admin" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400 mt-2 @error('name')
          dark:border-alerts-500
          @enderror">
                    @error('name')

                    <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
                    @enderror
                </div>
                @if(session('message'))
                <p class="text-red-500 text-sm mt-2">{{ session('message') }}</p>
                @endif

                <div class="my-5">
                    <h3 class="mb-4font-semibold text-gray-900 dark:text-white">Permisos</h3>
                    <div class="mb-4 flex items-center gap-2">
                        <input id="selectAll" type="checkbox"
                            class="w-4 h-4 text-blue-500 bg-gray-700 border-gray-600 rounded">
                        <label for="selectAll" class="text-sm font-semibold">Seleccionar todos</label>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
        @foreach ($permissions as $permission)
            <label class="flex items-center space-x-2">
                <input 
                    type="checkbox" 
                    name="permissions[]" 
                    value="{{ $permission->id }}" @checked(in_array($permission->id, old('permissions',
                                [])))"
                    class="permiso w-4 h-4 text-blue-500 bg-gray-700 border-gray-600 rounded">
                <span class="text-sm">{{ $permission->name }}</span>
            </label>
        @endforeach
    </div>
                    {{-- <ul class="text-sm font-medium rounded-lg grid grid-cols-3 gap-3">
                        @foreach ( $permissions as $permission)
                        <li class="w-full rounded-t-lg ">
                            <div class="flex items-center ps-3">
                                <input id="permission-{{ $permission->id }}" type="checkbox" name="permissions[]"
                                    value="{{ $permission->id }}" @checked(in_array($permission->id, old('permissions',
                                [])))
                                class="w-4 h-4 text-btn-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-btn-400
                                dark:focus:ring-btn-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700
                                focus:ring-2 ">
                                <label for="vue-checkbox" class="w-full py-3 ms-2 text-sm font-medium ">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </li>
                        @endforeach

                    </ul> --}}
                </div>

                <button type="submit"
                    class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full">Crear
                    rol</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
    document.getElementById('selectAll').addEventListener('change', function(e) {
        const checkboxes = document.querySelectorAll('.permiso');
        checkboxes.forEach(ch => ch.checked = e.target.checked);
    });
</script>
@endpush