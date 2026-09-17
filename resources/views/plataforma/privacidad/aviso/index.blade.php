@extends('components.layouts.principal')
@section('titulo')
Aviso de Privacidad |
@endsection

@section('contenido')
<section>
  <div class="relative w-full z-20">
    <div class="flex items-center justify-end max-w-7xl mx-5 md:mx-auto mt-5 gap-2">
      <i class="fa-solid fa-user-shield"></i>
      <a href="{{ route("resumen.index") }}" wire:navigate class="cursor-pointer">
        <h3 class="text-link-300 dark:text-link-100">Ir a la Declaración de privacidad</h3>
      </a>
      <i class="fa-solid fa-angle-right"></i>
    </div>
    <div class="grid md:grid-cols-12 mx-5 max-w-7xl md:mx-auto">
      <div class="col-span-6 md:p-10 mt-5 space-y-3 place-content-center">
        <div>
          <h2 class="text-2xl md:text-3xl font-bold mb-3">
            Centro de privacidad Emprendedores Creativos
          </h2>
          <p class=" text-justify text-sm md:text-lg lg:text-xl">
            Te contamos cómo usamos y protegemos tus datos personales para
            mejorar nuestros servicios y ofrecerte una experiencia
            personalizada.
          </p>
        </div>
        <div>
          <ul class="flex flex-col md:flex-row justify-between gap-2 text-sm lg:text-lg">
            <li class="flex items-center gap-2">
              <i class="fa-solid fa-check"></i>
              Administra el uso de tus datos
            </li>
            <li class="flex items-center gap-2">
              <i class="fa-solid fa-check"></i>
              Conoce tus derechos
            </li>
          </ul>
        </div>
      </div>
      <div class="col-span-6 p-10">
        <img src="{{ asset('images/Hero.png') }}" alt="Aviso de privacidad" class="w-auto" />
      </div>
    </div>
  </div>
</section>

<section class="bg-slate-500 dark:bg-cont-100">
  <div class="grid md:grid-cols-12 max-w-7xl mx-5 md:mx-auto py-10">
    <div class="col-span-6 order-2 md:p-10">

      <div>
        <h2 class="text-2xl md:text-3xl mb-2 font-bold">Gestiona tus datos personales</h2>
      </div>
      <div class="mt-6 max-w-lg relative text-left">
        <ul>
          <div>

            <li class="flex items-center gap-5">
              <i class="fa-solid fa-check"></i>
              <h3 class="text-link-300 dark:text-link-100">
                Modifica a tus datos
              </h3>
            </li>
            <p class="text-justify text-sm pl-9 mb-3">
              Mantener actualizados tus datos personales nos permite
              ofrecerte una experiencia personalizada, garantizar el uso
              correcto de nuestras plataformas y el cumplimiento de las
              regulaciones vigentes.
            </p>
          </div>
          <div>

            <li class="flex items-center gap-5">
              <i class="fa-solid fa-check"></i>
              <h3 class="text-link-300 dark:text-link-100">
                Tus datos personales deben ser verídicos
              </h3>
            </li>
            <p class="text-justify text-sm pl-9 mb-3">
              Debes garantizar que los datos personales que nos das son exactos y verídicos para evitar la suspensión en
              los servicios o la inhabilitación de tu cuenta.
            </p>
          </div>
          <div>

            <li class="flex items-center gap-5">
              <i class="fa-solid fa-check"></i>
              <h3 class="text-link-300 dark:text-link-100">
                Integramos tus datos en nuestras plataformas
              </h3>
            </li>
            <p class="text-justify text-sm pl-9 mb-3">
              Buscamos que vender, comprar o lo que quieras hacer, sea rápido y fácil en todo nuestro ecosistema.
            </p>
          </div>
        </ul>
      </div>
      <div class="flex gap-10 my-5 max-w-lg items-center">
        <a wire:navigate href="{{ route('perfil.index', ['user' => auth()->user()->username]) }}" class="">
          <button
            class="p-3 bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-lg font-semibold text-sm md:text-lg cursor-pointer">Gestionar
            tus datos</button>
        </a>
        <a href="" class="">
          <button
            class="p-3 bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-lg font-semibold text-sm md:text-lg cursor-pointer">
            Conoce más
            <i class="fa-solid fa-angle-right"></i>
          </button>
        </a>
      </div>
    </div>
    <div class="col-span-6 px-10">
      <img src="{{ asset('images/PersonalData.svg') }}" alt="Gestiona tus datos personales" class="rounded-lg" />
    </div>
  </div>
</section>

<section>
  <div class="grid md:grid-cols-12 max-w-7xl mx-5 md:mx-auto py-5">
    <div class="col-span-6 md:p-10">
      <div>
        <h2 class="text-2xl md:text-3xl mb-2 font-bold">Configura tus preferencias</h2>
        <p class="test-justify">
          Puedes controlar tu experiencia mediante la configuración de los
          permisos de privacidad. Habilitar estas opciones nos permite
          mostrarte contenido relevante según tus intereses.
        </p>
      </div>
      <div class="col-span-6 order-1 px-10 my-5 md:hidden ">
        <img src="{{ asset('images/Hero.png') }}" alt="Aviso de privacidad" class="w-auto" />
      </div>
      <div class="mt-6 max-w-lg relative text-left">
        <ul>
          <div>
            <li class="flex items-center gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="text-base md:text-xl font-semibold">
                Personalizan tu experiencia
              </h3>
            </li>
            <p class="text-justify text-sm pl-9 mb-3">
              Te damos recomendaciones útiles de otros productos de acuerdo
              a la información de tus últimas compras, búsquedas y
              favoritos.
            </p>
          </div>
          <div>
            <li class="flex items-center gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="text-base md:text-xl font-semibold">
                Nos ayudan a mejorar nuestros servicios
              </h3>
            </li>
            <p class="text-justify text-sm pl-9 mb-3">
              Cierta información sobre tu actividad cuando navegas nuestros
              sitios, nos permite analizar tus preferencias para mejorar
              nuestros servicios o crear nuevas soluciones
            </p>
          </div>
        </ul>
      </div>
      <div class="my-5">
        <button
          class="p-3 bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-lg font-semibold text-sm md:text-lg w-full md:w-auto"
          type="button">
          Configurar preferencias
        </button>
      </div>
    </div>
    <div class="col-span-6 order-1 px-10 my-5 md:flex ">
      <img src="{{ asset('images/Hero.png') }}" alt="Aviso de privacidad" class="rounded-lg" />
    </div>

  </div>
</section>

<section class="my-10 py-10 bg-slate-500 dark:bg-cont-100">
  <div class="my flex flex-col items-center justify-center md:mx-auto max-w-7xl">
    <div class="space-y-3 mx-5">
      <h2 class="text-2xl md:text-3xl font-bold text-center">
        Cómo usamos las cookies
      </h2>
      <p class="text-justify text-sm md:text-lg">
        Las cookies nos permiten conocer cómo navegas nuestras páginas y
        mantener su funcionamiento. Con esta información, hacemos que sea
        más fácil, rápido y seguro usar tu cuenta. Si desactivas ciertas
        cookies, es posible que no puedas disfrutar de algunas
        funcionalidades de nuestros sitios.
      </p>
    </div>
    <div class="my-3">
      <p>Te contamos para qué sirven:</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-2 md:mx-5 ">
      <div class="shadow-lg shadow-cyan-950 bg-slate-500 dark:bg-nav-800 rounded-xl mx-7 md:mx-2 p-7">
        <span>
          <img src="{{ asset('images/StickerAdvertising.svg') }}" alt=""
            class="p-5 w-32 md:w-44 justify-center mx-auto">
        </span>
        <div class="text-center mx-auto">
          <h2 class="font-bold mb-2">Publicidad personalizada</h2>
          <p class="text-sm text-center">Mejoramos nuestras ofertas y servicios y te mostramos anuncios que pueden
            interesarte.</p>
        </div>
      </div>
      <div class="shadow-lg shadow-cyan-950 bg-slate-500 dark:bg-nav-800 rounded-xl mx-7 md:mx-2 p-7">
        <span>
          <img src="{{ asset('images/StickerUserExperience.svg') }}" alt=""
            class="p-5 w-32 md:w-44 justify-center mx-auto">
        </span>
        <div class="text-center mx-auto">
          <h2 class="font-bold mb-2">Faciliita tu experiencia</h2>
          <p class="text-sm text-center">Recordamos tus datos para un ingreso fácil y rápido desde tus
            dispositivos habituales.</p>
        </div>
      </div>
      <div class="shadow-lg shadow-cyan-950 bg-slate-500 dark:bg-nav-800 rounded-xl mx-7 md:mx-2 p-7">
        <span>
          <img src="{{ asset('images/StickerSecurity.svg') }}" alt="" class="p-5 w-32 md:w-44 justify-center mx-auto">
        </span>
        <div class="text-center mx-auto">
          <h2 class="font-bold mb-2">Más seiguridad</h2>
          <p class="text-sm text-center">Refuerzan la seguridad de nuestro sitio y protegen a tu cuenta
            de posibles ataques maliciosos.
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="flex items-center justify-center gap-10 mb-5 mt-10">
    <button type="button"
      class="p-3 bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-lg font-semibold text-sm md:text-lg">
      Configurar cookies
    </button>
    <button type="button"
      class="text-link-300 hover:text-link-500 dark:text-link-100 dark:hover:text-link-300 duration-150 transition-colors font-semibold flex items-center gap-2 text-sm md:text-lg">
      Conocer más
      <i class="fa-solid fa-angle-right"></i>
    </button>
  </div>
</section>

<section class="my-5">
  <div class="grid md:grid-cols-12 max-w-7xl mx-5 md:mx-auto py-5">
    <div class="col-span-6 md:p-10">
      <div>
        <h2 class="text-2xl md:text-3xl mb-2 font-bold">Cómo procesamos tus datos</h2>
        <p class="text-justify mb-5">Procesar tus datos personales nos permite darte un exclente servicio en los
          productos y/o beneficios que ofrecemos. Resguardamos tus datos personales con adecuadas medidas de seguridad.
          No vendemos ni comercializamos información que pueda identificarte.</p>
        <p>Usamos tus datos para:</p>
      </div>
      <div class="col-span6 order-1 px-10 my-5 md:hidden">
        <img src="{{ asset('images/Hero.png') }}" alt="Aviso de privacidad" class="w-auto" />
      </div>
      <div class="mt-6 max-w-lg relative text-left">
        <ul>
          <div>
            <li class="flex items-center gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="md:text-xl font-semibold">Proteger tu seguridad</h3>
            </li>
            <p class="text-justify text-xs md:text-sm pl-9 mb-3">
              Prevenir fraude, abusos y delitos para un ecosistema seguro.
            </p>
          </div>
          <div>
            <li class="flex items-center gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="md:text-xl font-semibold">Garantizar el ejercicio de derechos</h3>
            </li>
            <p class="text-justify text-xs md:text-sm pl-9 mb-3">
              Habilitamos canales para que puedas ejercer tus derechos.
            </p>
          </div>
          <div>
            <li class="flex items-center gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="md:text-xl font-semibold">Sustentabilidad de nuestras plataformas</h3>
            </li>
            <p class="text-justify text-xs md:text-sm pl-9 mb-3">
              Cumplir con obligaciones legales y requerimientos de autoridades competentes.
            </p>
          </div>
        </ul>
      </div>
      <div class="my-5">
        <button type="button"
          class="p-3 bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-lg font-semibold text-sm md:text-lg w-full md:w-auto">
          Conocer más
        </button>
      </div>
    </div>
    <div class="col-span-6 order-1 px-10 my-5 md:flex">
      <img src="{{ asset('images/Hero.png') }}" alt="Aviso de privacidad" class="rounded-lg" />
    </div>

  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mx-5 max-w-7xl md:mx-auto">
    <div class="p-3 justify-center mx-auto">
      <span class="justify-center mx-auto flex text-link-300 m-5 text-3xl">
        <i class="fa-solid fa-download"></i>
      </span>
      <div class="text-center justify-center mx-auto">
        <h2 class="text-xl font-semibold mb-2">¿Quién los procesa?</h2>
        <p class="">Conoce la información detallada sobre los responsables del tratamiento de tus datos.</p>
      </div>
      <button class="flex items-center justify-center mx-auto text-link-100 gap-2" type="button">
        Saber más
        <i class="fa-solid fa-angle-right"></i>
      </button>
    </div>
    <div class="p-3 justify-center mx-auto">
      <span class="justify-center mx-auto flex text-link-300 m-5 text-3xl">
        <i class="fa-solid fa-gear"></i>
      </span>
      <div class="text-center justify-center mx-auto">
        <h2 class="text-xl font-semibold mb-2">Nuestro sistema</h2>
        <p class="">Usamos herramientas que nos ayudan a tomar decisiones automatiadas para ser más eficientes.</p>
      </div>
      <button class="flex items-center justify-center mx-auto text-link-100 gap-2" type="button">
        Saber más
        <i class="fa-solid fa-angle-right"></i>
      </button>
    </div>
    <div class="p-3 justify-center mx-auto">
      <span class="justify-center mx-auto flex text-link-300 m-5 text-3xl"><i class="fa-solid fa-copy"></i></span>
      <div class="text-center justify-center mx-auto">
        <h2 class="text-xl font-semibold mb-2">Reporte de datos</h2>
        <p class="text-sm mx-5 mb-3">Puedes pedir un reporte con los datos personales que usamos y guardamos sobre tu
          cuenta.</p>
      </div>
      <button class="flex items-center justify-center mx-auto text-link-100 gap-2" type="button">
        Solicitar reporte
        <i class="fa-solid fa-angle-right"></i>
      </button>
    </div>
    <div class="p-3 justify-center mx-auto">
      <span class="justify-center mx-auto flex text-link-300 m-5 text-3xl"><i class="fa-solid fa-bell"></i></span>
      <div class="text-center justify-center mx-auto">
        <h2 class="text-xl font-semibold mb-2">Novedades</h2>
        <p class="text-sm mx-5 mb-3">Conoce los canales habilitados para avisarte si hay cambios en el uso de tus datos
          personales.</p>
      </div>
      <button class="flex items-center justify-center mx-auto text-link-100 gap-2" type="button">
        Consultar canales
        <i class="fa-solid fa-angle-right"></i>
      </button>
    </div>
  </div>
</section>

<section class="py-5 bg-slate-500 dark:bg-cont-100">
  <div class="grid md:grid-cols-12 max-w-7xl mx-5 md:mx-auto py-10">

    <!-- Intro Section -->
    <div class="col-span-6 p-10">
      <h2 class="text-3xl font-bold mb-4">Consultas frecuentes antes de abrir una cuenta en Emprendedores
        Creativos</h2>
      <p class="">
        ¿No encuentras la respuesta que buscas? Comunicate con nuestro equipo
        <a wire:navigate href="{{ route('contacto.index') }}"
          class="dark:text-link-300 text-link-200 font-medium">atención al cliente</a>
        para ayudarte con tus dudas.
      </p>
    </div>

    <!-- FAQ Section -->
    <div class="col-span-6 px-10 space-y-3" x-data="{ open: null }">
      <!-- Item -->
      <button @click="open === 1 ? open = null : open = 1"
        class="flex justify-between gap-2.5 w-full text-left text-lg font-medium ">
        <h3 class="font-semibold ">¿Cómo elimino mis datos personales?</h3>
        <svg :class="{ 'rotate-180': open === 1 }" class="w-5 h-5 transition-transform" fill="none"
          stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open === 1" x-transition class="mt-2 ">
        <p class="text-slate-200 dark:text-slate-500">
          Si decides cancelar tu cuenta, mantendremos tus datos personales durante el tiempo mínimo necesario para
          cumplir
          su propósito inicial de recolección o por requerimientos legales, pero luego de esto tus datos serán
          eliminados
          de nuestra plataforma.
        </p>
      </div>
      <button @click="open === 2 ? open = null : open = 2"
        class="flex justify-between w-full gap-3 text-left text-lg font-medium ">
        <h3 class="font-semibold">Si me registro en Mercado Libre</h3>
        <svg :class="{ 'rotate-180': open === 2 }" class="w-5 h-5 transition-transform" fill="none"
          stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open === 2" x-transition class="mt-2 ">
        <p class="text-slate-200 dark:text-slate-500">
          Cuando te registras en cualquiera de nuestras plataformas, creas un usuario único que te permite ingresar a
          todas las demás. Sin embargo, este acceso no es automático y te pediremos una activación adicional cuando
          quieras usar cada uno de los servicios del ecosistema Mercado Libre.
        </p>
      </div>
      <button @click="open === 3 ? open = null : open = 3"
        class="flex justify-between w-full text-left text-lg font-medium ">
        <h3 class="font-semibold ">¿Tengo que dar todos mis datos personales para abrir una cuenta?</h3>
        <svg :class="{ 'rotate-180': open === 3 }" class="w-5 h-5 transition-transform" fill="none"
          stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open === 3" x-transition class="mt-2 ">
        <p class="text-slate-200 dark:text-slate-500">
          Dar tus datos personales no es obligatorio, pero sí es un requisito para usar nuestros servicios. Usamos tus
          datos para ofrecerte una experiencia personalizada y para mejorar nuestros servicios de manera continua.
        </p>
      </div>
      <button @click="open === 4 ? open = null : open = 4"
        class="flex justify-between w-full text-left text-lg font-medium ">
        <h3 class="font-semibold ">Si soy menor de edad, ¿Puedo abrir una cuenta?</h3>
        <svg :class="{ 'rotate-180': open === 4 }" class="w-5 h-5 transition-transform" fill="none"
          stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open === 4" x-transition class="mt-2 ">
        <p class="text-slate-200 dark:text-slate-500">
          En Mercado Libre trabajamos para mantener una comunidad segura, donde los usuarios puedan operar con
          confianza. Por eso, solo aquellos usuarios que tengan capacidad legal de contratar pueden operar dentro del
          sitio. Lamentablemente los menores de edad no se encuentran en esta situación ya que de acuerdo a las leyes
          vigentes no están autorizados para responder por transacciones comerciales.
        </p>
      </div>
      <button @click="open === 5 ? open = null : open = 5"
        class="flex justify-between w-full text-left text-lg font-medium ">
        <h3 class="font-semibold ">Si no tengo una cuenta, ¿Cómo puedo ejercer mis derechos?</h3>
        <svg :class="{ 'rotate-180': open === 5 }" class="w-5 h-5 transition-transform" fill="none"
          stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open === 5" x-transition class="mt-2 ">
        <p class="text-slate-200 dark:text-slate-500">
          Cuando no tienes una cuenta, solo guardamos tu información de navegación. Si consideras que tenemos datos personales tuyos, puedes contactarte con nosotros para ejercer tus derechos de privacidad.
        </p>
      </div>
    </div>

  </div>

  </div>
</section>

 <section class="py-5">
      <div class="max-w-7xl mx-5 md:mx-auto">
        <h2 class="text-center text-2xl md:text-xl font-semibold">Protegemos tus datos y te damos el control</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
          <div class="px-5 py-14">
            <h3 class="text-center text-lg font-semibold">Preferencias de uso de tus datos</h3>
            <button type="button" class="flex items-center gap-2 justify-center mx-auto text-link-300 hover:text-link-500 dark:text-link-100 dark:hover:text-link-300 duration-150 transition-colors">
             Gestionar tu privacidad
              <i class="fa-solid fa-angle-right"></i>
              </button>
          </div>
          <div class="px-5 py-14">
            <h3 class="text-center text-lg font-semibold">Tus datos personales</h3>
            <button type="button" class="flex items-center gap-2 justify-center mx-auto text-link-300 hover:text-link-500 dark:text-link-100 dark:hover:text-link-300 duration-150 transition-colors">
              Administrar tus datos
              <i class="fa-solid fa-angle-right"></i>
              </button>
          </div>
          <div class="px-5 py-14">
            <h3 class="text-center text-lg font-semibold">Declaración de privacidad</h3>
            <button type="button" class="flex items-center gap-2 justify-center mx-auto text-link-300 hover:text-link-500 dark:text-link-100 dark:hover:text-link-300 duration-150 transition-colors">
             Conocer los detalles
              <i class="fa-solid fa-angle-right"></i>
              </button>
          </div>
          <div class="px-5 py-14">
            <h3 class="text-center text-base font-semibold">Centro de ayuda sobre privacidad</h3>
            <button type="button" class="flex items-center gap-2 justify-center mx-auto text-link-300 hover:text-link-500 dark:text-link-100 dark:hover:text-link-300 duration-150 transition-colors">
              Consultar la ayuda
              <i class="fa-solid fa-angle-right"></i>
              </button>
          </div>
        </div>
      </div>
    </section>
    <section class="py-5 bg-slate-300 dark:bg-cont-100">
      <div class=" flex flex-col justify-center items-center mx-5 md:mx-auto">
        <h2 class="text-2xl md:text-3xl font-bold my-2">Revisa documentos adicionales</h2>
        <div class="flex flex-col justify-center items-center md:mx-auto space-y-3 my-3 rounded-xl p-5 md:p-10 bg-slate-500 dark:bg-nav-800 md:w-177.5 lg:w-7xl shadow-lg shadow-cyan-950 ">
          <h2 class="font-semibold">Términos y condiciones</h2>
          <p class="text-sm">Consulta más detalles sobre el uso de nuestras plataformas.</p>
          <button type="button" class="flex items-center gap-2 text-link-200 hover:text-link-300 dark:text-link-100 dark:hover:text-link-300 duration-150 transition-colors">
            Consutar documento
            <i class="fa-solid fa-angle-right"></i>
          </button>
        </div>
      </div>
    </section>


@endsection