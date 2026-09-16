@extends('components.layouts.principal')
@section('titulo')
Contacto |
@endsection

@section('contenido')
<header>
  <div class="bg-linear-to-r from-black to-gray-800 relative bg-cover md:h-192 ">
    <img src="{{ asset('images/ideas.webp') }}" alt="" class="opacity-30 object-cover static h-full w-full">
    <div class="absolute w-full h-full flex flex-col -top-5 justify-center text-center">
      <div class="text-center p-3 space-y-1 md:space-y-7">
        <span class=" text-a-100 font-bold text-xs md:text-3xl">
                ¿Dudas?
              </span>
              <h3 class="text-lg md:text-5xl font-extrabold uppercase tracking-wider">
                Contáctanos
              </h3>
      </div>
    </div>
  </div>
</header>
<main>
  <div class="flex flex-col md:flex-row m-5  ">
          {{--  INFORMACION  --}}
          <div class="w-full md:w-1/2 items-center order-last md:order-first justify-center mt-5 p-3 lg:p-10 mb-10 bg-light-300 dark:bg-nav-900 rounded-lg ">
            <div class="mx-auto max-w-2xl text-center block mt-5">
              <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">
                Medios de Contacto
              </h2>
              <p class="mt-2 text-lg leading-8 text-slate-300">
                Aqui tienes distintas maneras de contactarnos
              </p>
            </div>
            <div class="flex flex-col w-full p-5 space-y-5 items-center ">
              <div class="flex flex-col lg:flex-row gap-2 items-center">
                <div class="flex items-center gap-2">
                  <i class="fa-solid fa-clock"></i>
                  <h3 class="">Horario de Atención:</h3>
                </div>
                <p class="text-link-300 dark:text-link-100">
                  L a V : 10:00 am a 6:00 pm
                </p>
                <p class="text-link-300 dark:text-link-100">Sábados : 10:00 am a 1:00 pm</p>
              </div>
              <div class="flex flex-col lg:flex-row gap-2 items-center">
                <div class="flex items-center gap-2">
                  <i class="fa-brands fa-whatsapp"></i>
                  <h3 class="">WhatsApp:</h3>
                </div>
                <p class="text-link-300 dark:text-link-100"> 44 - 25 - 45 - 92 - 18</p>
              </div>
              <div class="flex flex-col lg:flex-row gap-2 items-center">
                <div class="flex item gap-2">
                  <i class="fa-solid fa-location-dot"></i>
                  <h3 class="">Ubicación:</h3>
                </div>
                <p class="text-link-300 dark:text-link-100 text-sm text-justify">
                 Tultepec, Edo de México.
                </p>
              </div>
              <div class="flex flex-col lg:flex-row gap-2 items-center">
                <div class="flex items-center gap-2">
                  <i class="fa-solid fa-envelope-open"></i>
                  <h3 class="">Correo Electrónico:</h3>
                </div>
                <p class="text-link-300 dark:text-link-100 ">
                  emprendedorescreativos2019@gmail.com
                </p>
              </div>
              <div>
                <p class="text-justify text-sm mx-auto lg:w-[70%]">
                  ¡Nos comprometemos a responder a tu correo lo más pronto
                  posible! Solicitamos por favor esperes a ser contactado en
                  caso de escribirnos fuera del horario de servicio anterior.
                </p>
              </div>
              <div class=" pt-5 mx-auto">
                <div class="mx-auto max-w-2xl text-center block">
                  <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    Redes Sociales
                  </h2>
                  <p class="mt-2 text-lg text-slate-300">
                    Tambien nos puedes contactar por medio de nuestras redes
                    sociales.
                  </p>
                </div>
                <div class="pt-5 flex gap-2 mx-auto justify-center">
                  <a
                    href="https://www.facebook.com/CreadoresCreativos.MX"
                    target="_blank"
                  >
                    <div class="bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 rounded-full p-5 box-content transition-colors duration-150">
                      <i class="fa-brands fa-facebook text-3xl"></i>
                    </div>
                  </a>
                  <a
                    href="https://www.twitter.com/Creadores_Creat"
                    target="_blank"
                  >
                    <div class="bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 rounded-full p-5 box-content transition-colors duration-150">
                      <i class="fa-brands fa-x-twitter text-3xl"></i>
                    </div>
                  </a>                 
                  <a
                    href="https://www.instagram.com/creadores_creat"
                    target="_blank"
                  >
                    <div class="bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 rounded-full p-5 box-content transition-colors duration-150">
                      <i class="fa-brands fa-instagram text-3xl"></i>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
          {{-- {/* FORMULARIO */} --}}
          @livewire('contacto')
        </div>
</main>
@endsection