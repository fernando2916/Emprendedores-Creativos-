@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.users.index'), 'label' => 'Usuarios', 'icon' => 'fa-solid fa-users', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Usuario']  {{-- Último elemento desactivado --}}
]" />

<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div class="">
    <div class="">
      <h3 class="text-3xl font-bold">Editar usuario</h3>
    </div>
    <div class="">
      <form action="{{ route('admin.users.update', $user) }}" method="POST" noValidate class="space-y-3">
        @csrf
        @method('PUT')
        <div>
          <label for="nombre_completo"
            class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Nombre
            Completo </label>
          <input id="nombre_completo" name="nombre_completo"
            value="{{ old('nombre_completo', $user->nombre_completo) }}" type="text" placeholder="Nombre completo"
            class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-gray-500 mt-2 @error('nombre_completo')
                         dark:border-alerts-500
                         @enderror">
          @error('nombre_completo')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="username"
            class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Nombre
            de usuario </label>
          <input id="username" name="username" value="{{ old('username', $user->username) }}" type="text"
            placeholder="Nombre-completo" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-gray-500 mt-2 @error('username')
                         dark:border-alerts-500
                         @enderror">
          @error('username')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="email" class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Correo
            electrónico </label>
          <input id="email" name="email" value="{{ old('email', $user->email) }}" type="text"
            placeholder="correo@correo.com" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-gray-500 mt-2 @error('email')
                         dark:border-alerts-500
                         @enderror">
          @error('email')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="password"
            class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Contraseña
          </label>
          <input id="password" name="password" value="{{ old('password') }}" type="password" placeholder="********"
            class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-gray-500 mt-2 @error('password')
                         dark:border-alerts-500
                         @enderror">
          @error('password')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
       <div class="my-5">
                    <h3 class="mb-4font-semibold">Asignar rol al usuario </h3>
                    <ul class="text-sm font-medium rounded-lg grid grid-cols-3 gap-3">
                        @foreach ( $roles as $role)
                        <li class="w-full rounded-t-lg ">
                            <div class="flex items-center ps-3">
                                <input id="{{ $role->id }}" type="checkbox" name="roles[]"
                                value="{{ $role->id }}"
                                @checked(in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())))
                                class=" w-4 h-4 text-btn-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-btn-400
                                dark:focus:ring-btn-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700
                                focus:ring-2 checked:bg-btn-600 ">
                                <label for=" vue-checkbox" class="w-full py-3 ms-2 text-sm font-medium ">
                                    {{ $role->name }}
                                </label>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
        @if(session('message'))
        <p class="text-red-500 text-sm mt-2">{{ session('message') }}</p>
        @endif

        <button type="submit"
          class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full mt-5">Actualizar
          Usuario</button>
      </form>
    </div>
  </div>
</div>
@endsection