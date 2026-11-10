<ul class="p-3 border-b">
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md" href="{{ route('home') }}" class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-home"></i>
      Inicio
    </a>
  </li>
  @can('ver panel')
    
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    href="{{ route('dashboard') }}" 
    class="flex items-center gap-3 p-3 text-lg">
    <i class="fa-solid fa-user-shield"></i>
    Panel Administrativo
  </a>
</li>
@endcan 
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md" href="{{ route('notificaciones.index') }}" class="flex items-center justify-between gap-3 p-3 text-lg" wire:navigate>
      <div class="flex items-center gap-3">
        <i class="fa-solid fa-bell"></i>
        Notificaciones
      </div>
      <span
            x-show="$store.indicadores.notificaciones > 0"
            x-cloak
            x-text="$store.indicadores.notificaciones > 99 ? '99+' : $store.indicadores.notificaciones"
            class="w-7 h-7
            rounded-full p-3
            bg-nav-500
            text-white
            text-xs
            font-bold
            inline-flex items-center justify-center mr-4 "
        ></span>
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    {{-- href="{{ route("cuenta.cursos.index") }}"  --}}
    class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-laptop-code"></i>
      Mi aprendizaje
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    href="{{ route("mis-pedidos.index") }}" 
    class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-cart-shopping"></i>
      Mis compras
    </a>
  </li>

  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
   
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    href="{{ route("lista-deseos.index") }}" 
    class="flex items-center gap-3 p-3 text-lg justify-between">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-heart"></i>
            Lista de deseos
        </div>        
        <span x-show="$store.indicadores.listaDeseos > 0"
            x-cloak
            x-text="$store.indicadores.listaDeseos"
            class=" w-7 h-7
                rounded-full p-3
                bg-nav-500
                text-white
                text-xs
                font-bold
                inline-flex items-center justify-center mr-4 ">
    
        </span>
    </a>
  </li>

  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    href="{{ route("direcciones.index") }}" 
    class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-location-dot"></i>
      Mis Direcciones
    </a>
  </li>

  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    {{-- href="{{ route("facturacion.index") }}"  --}}
    class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-shield"></i>
      Facturación
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    {{-- href="{{ route("soporte.index") }}"  --}}
    class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-user-gear"></i>
      Soporte técnico
    </a>
  </li>
  <form method='post' action="{{ route('logout') }}">
    <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
      @csrf
      <button type='submit' class="flex items-center gap-3 p-3 text-lg cursor-pointer">
        <i class="fa-solid fa-right-from-bracket"></i>
        Salir
      </button>
    </li>
  </form>
</ul>

<ul class="p-3 border-b">
    <div class="flex items-center justify-start pl-7 text-a-500 font-semibold dark:text-slate-400 gap-3">
      <span class="">Menu</span>
    </div>
    <li @click="showMenu = false" class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all">
        <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
        href="{{ route('blog.index') }}" 
        class="flex items-center gap-3 p-3 text-xl">
          <i class="fa-solid fa-book"></i>
          Blog
        </a>
      </li>
      <li @click="showMenu = false" class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all">
        <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
        href="{{ route('tienda.index') }}" 
        class="flex items-center gap-3 p-3 text-xl">
          <i class="fa-solid fa-store"></i>
          Tienda
        </a>
      </li>
      <li @click="showMenu = false" class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all">
        <a wire:navigate 
        href="" 
        class="flex items-center gap-3 p-3 text-xl">
          <i class="fa-solid fa-video"></i>
          Cursos
        </a>
      </li>
</ul>

<ul class="p-3 border-b">
  <div class="flex items-center justify-start pl-7 text-a-500 font-semibold dark:text-slate-400 gap-3">
    <span class="">Nuestros Servicios</span>
  </div>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    href="{{ route('diseno.index') }}"
    wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-pen"></i>
      Diseño Gráfico
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    href="{{ route('fotografia.index') }}"
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-camera"></i>
      Fotografía
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    {{-- href="{{ route("desarrollo.index") }}" --}}
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-laptop-code"></i>
      Diseño y Desarrollo Web
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    {{-- href="{{ route("asesorias.index") }}" --}}
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-chalkboard-user"></i>
      Asesorias
    </a>
  </li>
</ul>

<ul class="p-3 border-b">
  <div class="flex items-center justify-start pl-7 text-a-500 font-semibold dark:text-slate-400 gap-3">
    <span class="">Más de Emprendedores</span>
  </div>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    {{-- href="{{ route("nosotros.index") }}" --}}
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-building"></i>
      Quienes somos
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    href="{{ route('contacto.index') }}"
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-envelopes-bulk"></i>
      Contacto
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    href="{{ route('recursos.index') }}"
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-download"></i>
      Recursos
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    href="{{ route('glosario.index') }}"
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-brands fa-glide-g"></i>
      Glosario
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700  rounded-md transition-all" @click="showMenu = false">
    <a wire:navigate wire:current.exact="bg-light-200 dark:bg-nav-800 rounded-md"
    href="{{ route('vacantes.index') }}"
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-briefcase"></i>
      Vacantes
    </a>
  </li>
  
</ul>