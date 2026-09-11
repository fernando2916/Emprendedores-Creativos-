<nav class="items-center gap-2 hidden md:flex">
  <div class="flex items center gap-2">
    <a href="/" wire:navigate class="">
      <i class="fa-solid fa-house"></i>
      Inicio
    </a>
  </div>
  {{-- Servicios --}}
  <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay" data-dropdown-delay="500"
    data-dropdown-trigger="hover" class="font-medium rounded-lg text-center inline-flex items-center gap-1 cursor-pointer"
    type="button">
    <i class="fa-brands fa-buffer"></i>
    Servicios
    <i class="fa-solid fa-angle-down"></i>
  </button>

  <!-- Dropdown servicios -->
  <div class="z-50 hidden bg-light-300 rounded-lg shadow-sm w-52 dark:bg-nav-800"
    id="dropdownDelay">
    <div class="p-1 space-y-0.5 z-50 ">
      <a 
        class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        wire:navigate 
        href=""
        >
        <i class="fa-solid fa-pen"></i>
        Diseño Gráfico
      </a>
      <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
      wire:navigate href="">
        <i class="fa-solid fa-camera"></i>
        Fotografía
      </a>
      <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
      wire:navigate href="{{ route('home') }}">
        <i class="fa-solid fa-laptop-code"></i>
        Diseño y Desarrollo Web
      </a>
      <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
      wire:navigate href="{{ route('home') }}">
        <i class="fa-solid fa-chalkboard-user"></i>
        Asesorias
      </a>
    </div>
  </div>

  <div class="flex items center gap-2">
    <a wire:navigate href="{{ route('blog.index') }}" class="">
      <i class="fa-solid fa-book"></i>
      Blog
    </a>
  </div>
  <div class="flex items center gap-2">
    <a wire:navigate href="" class="">
      <i class="fa-solid fa-shopping-cart"></i>
      Tienda
    </a>
  </div>
  <div class="flex items center gap-2">
    <a href="/cursos" class="">
      <i class="fa-solid fa-video"></i>
      Cursos
    </a>
  </div>

   {{-- Emprensa --}}
  <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay2" data-dropdown-delay="500"
    data-dropdown-trigger="hover" class="font-medium rounded-lg text-center inline-flex items-center gap-1 cursor-pointer"
    type="button">
     <i class="fa-solid fa-building"></i>
      Nosotros
    <i class="fa-solid fa-angle-down"></i>
  </button>

   <!-- Dropdown empresa -->
  <div class="z-50 hidden bg-light-300 rounded-lg shadow-sm w-52 dark:bg-nav-800"
    id="dropdownDelay2">
    <div class="p-1 space-y-0.5">
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        wire:navigate href="{{ route('home') }}">
          <i class="fa-solid fa-circle-info"></i>
          Quienes somos
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        wire:navigate href="">
          <i class="fa-solid fa-envelopes-bulk"></i>
          Contacto
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        wire:navigate href="">
          <i class="fa-solid fa-download"></i>
          Recursos
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        wire:navigate href="">
          <i class="fa-brands fa-glide-g"></i>
          Glosario
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        wire:navigate href="">
          <i class="fa-solid fa-briefcase"></i>
          Vacantes
        </a>
    </div>
  </div>

</nav>