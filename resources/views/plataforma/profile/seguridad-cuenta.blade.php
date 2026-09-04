@extends('components.layouts.principal')

@section('titulo')
    Seguridad de la cuenta |
@endsection

@section('contenido')
    <div class="max-w-6xl mx-auto my-8 bg-cont-200 dark:bg-cont-300 m-5 dark:border-gray-200 rounded-lg shadow-sm flex flex-col md:flex-row">

        <!-- Sidebar / Menú Lateral -->
        <x-navigation.nav-perfil/>

        <!-- Contenido Principal -->
        <main class="flex-1 p-8">
            <header class="border-b border-gray-200 pb-4 mb-6 text-center">
                <h1 class="text-2xl font-bold dark:text-gray-200">Cuenta</h1>
                <p class="text-sm dark:text-gray-500">Edita la configuracion de tu cuenta y cambia la contraseña aqui.</p>
            </header>

            <div class="border-b border-gray-200 pb-4 mb-6 flex justify-center gap-2">
                <label for="email" class="hidden"></label>
                <input 
                    type="text" 
                    id="email"
                    disabled
                    placeholder="Tu dirección de correo electrónico es {{ auth()->user()->email }} "
                    class="disabled:bg-nav-900 disabled:border-nav-900 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent border-link-100 p-2 pr-10 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400 mt-2"
                />
                {{-- <button class="px-4 text-link-400 border-2 border-link-100 rounded-md hover:bg-purple-50 transition-colors">
                    <span class="text-sm">
                        <i class="fa-solid fa-pencil"></i>
                    </span>
                </button> --}}
            </div>

            <form action="{{ route('cuenta.update', $user) }}" method="POST" class="space-y-6" novalidate>
                @csrf
                @method('PUT')
                <div>
                    <label for="current_password"
                        class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Contraseña Actual</label>
                    <x-password-input id="password" name="current_password" model="current_password" placehlder="********" />
        
                </div>
                <div>
                    <label for="password"
                        class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Nueva Contraseña</label>
                    <x-password-input id="password" name="password" model="password" placehlder="********" />
        
                </div>
                <div>
                    <label for="password_confirmation"
                        class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Confirma tu nueva
                        contraseña</label>
                    <x-password-input id="password_confirmation" name="password_confirmation" model="password_confirmation"
                        placehlder="********" />
                </div>
                <!-- Botón Guardar -->
                <div>
                    <button type="submit"
                        class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-6 rounded text-sm transition cursor-pointer">
                        Cambiar la Contraseña
                    </button>
                </div>

            </form>
        </main>
    </div>
@endsection
