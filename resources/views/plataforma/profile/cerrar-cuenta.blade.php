@extends('components.layouts.principal')

@section('titulo')
    Cerrar Cuenta |
@endsection

@section('contenido')
    <div class="max-w-6xl mx-auto my-8 bg-cont-200 dark:bg-cont-300 m-5 dark:border-gray-200 rounded-lg shadow-sm flex flex-col md:flex-row">

        <!-- Sidebar / Menú Lateral -->
        <x-navigation.nav-perfil/>

        <!-- Contenido Principal -->
        <main class="flex-1 p-8">
            <header class="border-b border-gray-200 pb-4 mb-6 text-center">
                <h1 class="text-2xl font-bold dark:text-gray-200">Perfil público</h1>
                <p class="text-sm dark:text-gray-500">Añade información sobre ti</p>
            </header>

            <form class="space-y-6">
                <div>
                    <p class="">
                        <b class="text-red-600 font-semibold">Advertencia:</b>
                        Si cierras tu cuenta, se cancelará tu suscripción a tus 113 cursos y perderás para siempre el acceso a tu cuenta y a los datos asociados a ella, incluso si decides crear una nueva cuenta con la misma dirección de correo electrónico más adelante.
                        <br>
                        <br>
                        Ten en cuenta que, si quieres reactivar tu cuenta tras presentar una solicitud de eliminación, tendrás 14 días desde la fecha de presentación inicial para mandar un correo electrónico a privacy@udemy.com para cancelar la solicitud.
                    </p>
                </div>
                <!-- Botón Guardar -->
                <div>
                    <button type="submit"
                        class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-6 rounded text-sm transition cursor-pointer">
                        <span class="">
                            <i class="fa-solid fa-trash"></i>
                            Cerrar Cuenta
                        </span>
                    </button>
                </div>

            </form>
        </main>
    </div>
@endsection
