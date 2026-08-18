<nav class="flex items-center gap-2">
  <x-btn-darkMode />
  <x-navigation.cart/>
  <x-navigation.notification/>
  <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay3" data-dropdown-delay="500"
    data-dropdown-trigger="hover" class="font-medium rounded-lg text-center  items-center gap-1 cursor-pointer hidden md:flex"
    type="button">
      <i class="fa-solid fa-user"></i>
  </button>

   <!-- Dropdown empresa -->
  <div class="z-10 hidden bg-light-300 rounded-lg shadow-sm w-64 dark:bg-nav-800"
    id="dropdownDelay3">
    <div class="p-1 space-y-0.5">
      <div class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700">
        <div>
            <a wire:navigate 
            {{-- href="{{ route("perfil.index") }}"  --}}
            class="flex items-center gap-x-3">

              {{-- <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre_completo) }}"
                            class="w-[25px] h-[25px] rounded-full" /> --}}
              <div class="">
                {{-- {{ auth()->user()->nombre_completo }} --}}
                <p class="text-xs text-alerts-100">
                  {{-- {{ auth()->user()->roles->pluck('name')->join(', ')  }} --}}
                </p>
                <p class="text-link-100">
                  {{-- {{ auth()->user()->email }} --}}
                </p>
              </div>
            </a>
          </div>          
      </div>
      {{-- @can('ver panel') --}}
        
      <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
      wire:navigate 
      href=""
      >
      <i class="fa-solid fa-user-shield"></i>
      Panel administrativo
    </a>
    {{-- @endcan --}}
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" href="/notificaciones">
          <i class="fa-solid fa-bell"></i>
          Notificaciones
        </a>
       
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        
        wire:navigate 
        {{-- href="{{ route("compras.index") }}" --}}
        >
          <i class="fa-solid fa-basket-shopping"></i>
          Mis compras
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        wire:navigate 
        {{-- href="{{ route("facturacion.index") }}" --}}
        >
          <i class="fa-solid fa-file-export"></i>
          Facturación
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700" 
        wire:navigate 
        {{-- href="{{ route("soporte.index") }}" --}}
        >
          <i class="fa-solid fa-gears"></i>
          Soporte
        </a>
        <form action="" method="post">

          @csrf
          <button type="submit" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-slate-400 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 w-full cursor-pointer">
            <i class="fa-solid fa-right-from-bracket"></i>
            Salir
          </button>
        </form>
    </div>
  </div>
</nav>