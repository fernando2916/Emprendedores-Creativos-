<ul class="p-3 border-b">
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate href="{{ route('home') }}" class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-home"></i>
      Inicio
    </a>
  </li>
  @can('ver panel')
    
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    href="{{ route('dashboard') }}" 
    class="flex items-center gap-3 p-3 text-lg">
    <i class="fa-solid fa-user-shield"></i>
    Panel Administrativo
  </a>
</li>
@endcan
  <li @click="showMenu = false" class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all">
    <a wire:navigate 
    href="{{ route('blog.index') }}" 
    class="flex items-center gap-3 p-3 text-xl">
      <i class="fa-solid fa-book"></i>
      Blog
    </a>
  </li>
  <li @click="showMenu = false" class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all">
    <a wire:navigate 
    href="" 
    class="flex items-center gap-3 p-3 text-xl">
      <i class="fa-solid fa-shopping-cart"></i>
      Tienda
    </a>
  </li>
  <li @click="showMenu = false" class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all">
    <a wire:navigate 
    href="" 
    class="flex items-center gap-3 p-3 text-xl">
      <i class="fa-solid fa-video"></i>
      Cursos
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a href="notificaciones" class="flex items-center justify-between gap-3 p-3 text-lg">
      <div class="flex items-center gap-3">
        <i class="fa-solid fa-bell"></i>
        Notificaciones
      </div>
      <div class=" flex text-alerts-500 items-center pr-3 justify-center text-3xl relative">
        <i class="fa-solid fa-circle"></i>
        <span class="text-sm absolute mx-auto text-white">5</span>
      </div>
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    {{-- href="{{ route("cuenta.cursos.index") }}"  --}}
    class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-laptop-code"></i>
      Mi aprendizaje
    </a>
  </li>

  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    {{-- href="{{ route("deseos.index") }}"  --}}
    class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-heart"></i>
      Lista de deseos
    </a>
  </li>

  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    {{-- href="{{ route("facturacion.index") }}"  --}}
    class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-shield"></i>
      Facturación
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    {{-- href="{{ route("soporte.index") }}"  --}}
    class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-user-gear"></i>
      Soporte técnico
    </a>
  </li>
  <form method='post' action="{{ route('logout') }}">
    <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
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
    <span class="">Nuestros Servicios</span>
  </div>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    href=""
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-pen"></i>
      Diseño Gráfico
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    href=""
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-camera"></i>
      Fotografía
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    {{-- href="{{ route("desarrollo.index") }}" --}}
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-laptop-code"></i>
      Diseño y Desarrollo Web
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
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
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    {{-- href="{{ route("nosotros.index") }}" --}}
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-building"></i>
      Quienes somos
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    href=""
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-envelopes-bulk"></i>
      Contacto
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    href=""
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-download"></i>
      Recursos
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    href=""
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-brands fa-glide-g"></i>
      Glosario
    </a>
  </li>
  <li class="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
    <a wire:navigate 
    href=""
     class="flex items-center gap-3 p-3 text-lg">
      <i class="fa-solid fa-briefcase"></i>
      Vacantes
    </a>
  </li>
  
</ul>