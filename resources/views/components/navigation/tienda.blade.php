<nav class="tems-center gap-2 hidden md:flex">
    {{-- colecciones --}}
    <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay4" data-dropdown-delay="500"
      data-dropdown-trigger="hover" class="font-medium rounded-lg text-center inline-flex items-center gap-1 cursor-pointer"
      type="button">
      <i class="fa-brands fa-buffer"></i>
      Colecciones
      <i class="fa-solid fa-angle-down"></i>
    </button>
  
    <!-- Dropdown colecciones -->
    <div class="z-50 hidden bg-light-300 rounded-lg shadow-sm w-52 dark:bg-nav-800"
      id="dropdownDelay4">
      <div class="p-1 space-y-0.5 z-50 ">
        <a 
          class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
          wire:navigate 
          href="{{ route('diseno.index') }}"
          >
          <i class="fa-solid fa-pen"></i>
          Diseño Gráfico
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        wire:navigate href=" {{ route('fotografia.index') }}">
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
    {{-- Servicios --}}
    <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay5" data-dropdown-delay="500"
      data-dropdown-trigger="hover" class="font-medium rounded-lg text-center inline-flex items-center gap-1 cursor-pointer"
      type="button">
      <i class="fa-brands fa-buffer"></i>
      Colecciones
      <i class="fa-solid fa-angle-down"></i>
    </button>
  
    <!-- Dropdown servicios -->
    <div class="z-50 hidden bg-light-300 rounded-lg shadow-sm w-52 dark:bg-nav-800"
      id="dropdownDelay5">
      <div class="p-1 space-y-0.5 z-50 ">
        <a 
          class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
          wire:navigate 
          href="{{ route('diseno.index') }}"
          >
          <i class="fa-solid fa-pen"></i>
          Diseño Gráfico
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        wire:navigate href=" {{ route('fotografia.index') }}">
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
</nav>