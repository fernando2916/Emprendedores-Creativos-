<section class="px-5 mx-auto pt-10">
    <div>
      <h2 class="grid place-content-center text-3xl font-bold mx-auto overflow-hidden max-w-7xl">Servicios</h2>
      <p class="grid place-content-center text-lg text-center pb-5">
        Conoce todas nuestra soluciones para empezar a desarrollar tu negocio.
      </p>
    </div>
  
    <div class=" hidden md:grid md:grid-cols-3 gap-8 md:shrink mx-auto mt-2 lg:max-w-7xl mb-10">
      <div class="shadow-lg hover:shadow-link-500 p-6 border-double border border-cyan-400/40 rounded-lg">
        <a wire:navigate href="{{ route('diseno.index') }}">
          <div class="flex place-content-center">
            <div class="h-16 w-16 bg-btn-600 rounded-full">
              <span class="flex justify-center items-center text-4xl py-4 text-cyan-400 h-full w-full object-cover">
                <i class="fa-solid fa-pen"></i>
              </span>
            </div>
          </div>
          <h2 class="flex justify-center text-xl font-medium py-4">
            Diseño Gráfico
          </h2>
          <p class="flex text-left items-center text-lg justify-center">
            Conocemos la importancia de tener una buena imagen para los clientes, desde un logotipo hasta toda la identidad corporativa de tu marca.
          </p>
        </a>
      </div>
      <div class="shadow-lg hover:shadow-link-500 p-6 border-double border border-cyan-400/40 rounded-lg">
        <a wire:navigate href="">
          <div class="flex place-content-center">
            <div class="h-16 w-16 bg-btn-600 rounded-full">
              <span class="flex justify-center items-center text-4xl py-4 text-cyan-400 h-full w-full object-cover">
                <i class="fa-solid fa-camera"></i>
              </span>
            </div>
          </div>
          <h2 class="flex justify-center text-xl font-medium py-4">
            Fotografía
          </h2>
          <p class="flex text-left items-center text-lg justify-center">
           Deseas renovar o crear tu portafolio personal, tu cartera de productos, etc... Nos adaptamos a tu proyecto.
          </p>
        </a>
      </div>
      <div class="shadow-lg hover:shadow-link-500 p-6 border-double border border-cyan-400/40 rounded-lg">
        <a wire:navigate href="">
          <div class="flex place-content-center">
            <div class="h-16 w-16 bg-btn-600 rounded-full">
              <span class="flex justify-center items-center text-4xl py-4 text-cyan-400 h-full w-full object-cover">
                <i class="fa-solid fa-laptop-code"></i>
              </span>
            </div>
          </div>
          <h2 class="flex justify-center text-xl font-medium py-4">
            Diseño y Desarrollo Web
          </h2>
          <p class="flex text-left items-center text-lg justify-center">
            Sabemos lo fundamental que es tener presencia en la web, es por ello que te brindamos nuestro servicio de Diseño y Desarrollo Web.
          </p>
        </a>
      </div>
      <div class="shadow-lg hover:shadow-link-500 p-6 border-double border border-cyan-400/40 rounded-lg">
        <a wire:navigate href="">
          <div class="flex place-content-center">
            <div class="h-16 w-16 bg-btn-600 rounded-full">
              <span class="flex justify-center items-center text-4xl py-4 text-cyan-400 h-full w-full object-cover">
                <i class="fa-solid fa-chalkboard-user"></i>
              </span>
            </div>
          </div>
          <h2 class="flex justify-center text-xl font-medium py-4">
           Asesorias
          </h2>
          <p class="flex text-left items-center text-lg justify-center">
            Nos jactamos en ayudar a nuestros clientes para que tengan una mejor versión de su proyecto, así mismo le puedan sacar mejor provecho.
          </p>
        </a>
      </div>
      <div class="shadow-lg hover:shadow-link-500 p-6 border-double border border-cyan-400/40 rounded-lg">
        <a wire:navigate href="">
          <div class="flex place-content-center">
            <div class="h-16 w-16 bg-btn-600 rounded-full">
              <span class="flex justify-center items-center text-4xl py-4 text-cyan-400 h-full w-full object-cover">
                <i class="fa-solid fa-bullhorn"></i>
              </span>
            </div>
          </div>
          <h2 class="flex justify-center text-xl font-medium py-4">
           Social Media Marketing
          </h2>
          <p class="flex text-left items-center text-lg justify-center">
            Te ayudamos a crear las mejores campañas en redes sociales para impulsar tu negocio y llegues a tu público ideal mediante la innovación en contenidos.
          </p>
        </a>
      </div>
    </div>
  <div class="md:hidden flex mb-10">
    @include('plataforma.home.slide-servicios')
  </div>
  </section>