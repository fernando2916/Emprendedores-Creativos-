@extends('components.layouts.principal')

@section('titulo')
    Editar Fotografia |
@endsection

@section('contenido')
    <div class="max-w-6xl mx-auto my-8 bg-cont-200 dark:bg-cont-300 m-5 dark:border-gray-200 rounded-lg shadow-sm flex flex-col md:flex-row">

        <!-- Sidebar / Menú Lateral -->
        <x-navigation.nav-perfil/>

        <!-- Contenido Principal -->
        <main class="flex-1 p-8">
            <header class="border-b border-gray-200 pb-4 mb-6 text-center">
                <h1 class="text-2xl font-bold dark:text-gray-200">Fotografía</h1>
                <p class="text-sm dark:text-gray-500">Añade una foto tuya al perfil.</p>
            </header>

            <form action="{{ route('foto.update', $user) }}" method="POST" class="space-y-6" novalidate  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="relative w-full aspect-video">

                    <img
                        id="imgPreview"
                        src="{{ $user->profile->avatar
                            ? Storage::url($user->profile->avatar)
                            : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' }}"
                        alt="Foto de perfil"
                        class="w-full h-full object-contain object-center"
                    >
            
                    <div class="absolute top-5 right-5">
                        <label
                            for="dropzone-file"
                            class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 p-2 rounded-lg cursor-pointer"
                        >
                            Subir imagen
            
                            <input
                                id="dropzone-file"
                                name="avatar"
                                type="file"
                                accept="image/png,image/jpeg,image/jpg"
                                class="hidden"
                                onchange="preview_image(event, '#imgPreview')"
                            >
                        </label>
                    </div>

                <!-- Botón Guardar -->
                <div>
                    <button type="submit"
                        class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-6 rounded text-sm transition cursor-pointer">
                        Actualizar Foto
                    </button>
                </div>

            </form>
        </main>
    </div>
@endsection
