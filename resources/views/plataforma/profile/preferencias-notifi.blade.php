@extends('components.layouts.principal')

@section('titulo')
    Preferencias de notificaciones |
@endsection

@section('contenido')
    <div
        class="max-w-6xl mx-auto my-8 bg-cont-200 dark:bg-cont-300 m-5 dark:border-gray-200 rounded-lg shadow-sm flex flex-col md:flex-row">

        <!-- Sidebar / Menú Lateral -->
        <x-navigation.nav-perfil />

        <!-- Contenido Principal -->
        <main class="flex-1 p-8">
            <header class="border-b border-gray-200 pb-4 mb-6 text-center">
                <h1 class="text-2xl font-bold dark:text-gray-200">Preferencias de notificación</h1>
                <p class="text-sm dark:text-gray-500">Gestiona los tipos de comunicaciones que recibes.</p>
            </header>

            <form>
                <div class="border border-gray-500">
                    <div class=" flex justify-between p-2 py-3 items-center border-b">
                        <p class="font-bold text-2xl">Noticias y Ofertas</p>
                        <flux:switch />
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex items-center">
                            <input id="link-checkbox" type="checkbox" value=""
                                class="text-nav-400 w-4 h-4 accent-nav-400 ring-offset-transparent border-none focus:ring-nav-500">
                            <label for="link-checkbox" class="select-none ms-2 text-sm font-medium ">Anuncios y lanzamientos de productos</label>
                        </div>
                        <div class="flex items-center">
                            <input id="link-checkbox2" type="checkbox" value=""
                                class="text-nav-400 w-4 h-4 accent-nav-400 ring-offset-transparent border-none focus:ring-nav-500">
                            <label for="link-checkbox2" class="select-none ms-2 text-sm font-medium ">Ofertas y promociones</label>
                        </div>
                    </div>
                </div>
                <div class="border border-gray-500 my-10">
                    <div class=" flex justify-between p-2 py-3 items-center border-b">
                        <p class="font-bold text-2xl">Tú aprendizaje</p>
                        <flux:switch />
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex items-center">
                            <input id="link-checkbox3" type="checkbox" value=""
                                class="text-nav-400 w-4 h-4 accent-nav-400 ring-offset-transparent border-none focus:ring-nav-500">
                            <label for="link-checkbox3" class="select-none ms-2 text-sm font-medium ">Estadisticas de aprendizaje</label>
                        </div>
                        <div class="flex items-center">
                            <input id="link-checkbox4" type="checkbox" value=""
                                class="text-nav-400 w-4 h-4 accent-nav-400 ring-offset-transparent border-none focus:ring-nav-500">
                            <label for="link-checkbox4" class="select-none ms-2 text-sm font-medium ">Inspiración (consejos,historias, etc.)</label>
                        </div>
                        <div class="flex items-center">
                            <input id="link-checkbox5" type="checkbox" value=""
                                class="text-nav-400 w-4 h-4 accent-nav-400 ring-offset-transparent border-none focus:ring-nav-500">
                            <label for="link-checkbox5" class="select-none ms-2 text-sm font-medium ">Recomendaciones de cursos</label>
                        </div>
                        <div class="flex items-center">
                            <input id="link-checkbox6" type="checkbox" value=""
                                class="text-nav-400 w-4 h-4 accent-nav-400 ring-offset-transparent border-none focus:ring-nav-500">
                            <label for="link-checkbox6" class="select-none ms-2 text-sm font-medium ">Notificaciones de instructores</label>
                        </div>
                    </div>
                </div>

                <!-- Botón Guardar -->
                <div>
                    <button type="submit"
                        class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-6 rounded text-sm transition cursor-pointer">
                        Guardar
                    </button>
                </div>

            </form>
        </main>
    </div>
@endsection
