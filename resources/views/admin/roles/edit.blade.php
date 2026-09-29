@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.roles.index'), 'label' => 'Roles', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Rol']  {{-- Último elemento desactivado --}}
]" />

<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
    <div class="">
        <div class="">
            <h3 class="text-3xl font-bold">Editar Rol</h3>
        </div>
        <div class="">
            <form 
            action="{{ route('admin.roles.update', $role->id) }}" method="POST" noValidate>
                @csrf
                @method('PUT')
                <div>
                    <label for="name"
                        class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Nombre del
                        rol</label>
                    <input id="name" name="name" value="{{ $role->name }}" type="text" placeholder="admin" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400 mt-2 @error('name')
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
                    <h3 class="mb-4font-semibold">Permisos</h3>
                    <ul class="text-sm font-medium rounded-lg grid grid-cols-3 gap-3">
                        @foreach ( $permissions as $permission)
                        <li class="w-full rounded-t-lg ">
                            <div class="flex items-center ps-3">
                                <input id="{{ $permission->id }}" type="checkbox" name="permissions[]"
                                value="{{ $permission->id }}"
                                @checked(in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())))
                                class=" w-4 h-4 text-btn-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-btn-400
                                dark:focus:ring-btn-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700
                                focus:ring-2 checked:bg-btn-600 ">
                                <label for=" vue-checkbox" class="w-full py-3 ms-2 text-sm font-medium ">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>

                <button type="submit"
                    class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full cursor-pointer">Actualizar
                    rol</button>
            </form>
        </div>
    </div>
</div>
@endsection