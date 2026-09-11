<ul class="p-3 border-b">
    <li
      class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
      @click="showMenu = false"
    >
      <a
        href="{{ route('home') }}"
        class="flex items-center gap-3 p-3 text-lg"
      >
        <i class="fa-solid fa-house"></i>
      Inicio
        
      </a>
    </li>
    <li
      class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
      @click="showMenu = false"
    >
      <a
        wire:navigate 
        href="{{ route('blog.index') }}"
        class="flex items-center gap-3 p-3 text-lg"
      >
        <i class="fa-solid fa-book"></i>
      Blog
        
      </a>
    <li
      class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
      @click="showMenu = false"
    >
      <a
        wire:navigate 
        href=""
        class="flex items-center gap-3 p-3 text-lg"
      >
        <i class="fa-solid fa-shopping-cart"></i>
      Tienda
        
      </a>
    </li>
    <li
      class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
      @click="showMenu = false"
    >
      <a
        wire:navigate 
        {{-- href="{{ route("cursos.index") }}" --}}
        class="flex items-center gap-3 p-3 text-lg"
      >
        <i class="fa-solid fa-video"></i>
      Cursos
        
      </a>
    </li>
  </ul>

  <p class="ml-8 pt-2 font-semibold text-link-200 dark:text-gray-400">
    Nuestros servicios
  </p>

  <ul class="p-3 border-b">
    <li
      class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
      @click="showMenu = false"
    >
      <a
        wire:navigate
        wire:current.exact="bg-light-200 dark:bg-purple-700"
        href="{{ route('diseno.index') }}"
        class="flex items-center gap-3 p-3 text-lg"
      >
        <i class="fa-solid fa-pen"></i>
      Diseño Gráfico
        
      </a>
    </li>
    <li
      class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
      @click="showMenu = false"
    >
      <a
        wire:navigate 
        href=""
        class="flex items-center gap-3 p-3 text-lg"
      >
        <i class="fa-solid fa-camera"></i>
      Fotografía
        
      </a>
    </li>
    <li
      class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
      @click="showMenu = false"
    >
      <a
        wire:navigate 
        {{-- href="{{ route("desarrollo.index") }}" --}}
        class="flex items-center gap-3 p-3 text-lg"
      >
      <i class="fa-solid fa-laptop-code"></i>
      Diseño y Desarrollo web
        
      </a>
    </li>

    <li
      class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
      @click="showMenu = false"
    >
      <a
        wire:navigate 
        {{-- href="{{ route("asesorias.index") }}" --}}
        class="flex items-center gap-3 p-3 text-lg"
      >
      <i class="fa-solid fa-chalkboard-user"></i>
      Asesorias
        
      </a>
    </li>
  </ul>
  
  <p class="ml-8 pt-2 font-semibold text-link-200 dark:text-gray-400">
   Sobre nosotros
  </p>

  <ul class="p-3 border-b">
    <li
    class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      wire:navigate 
      {{-- href="{{ route("nosotros.index") }}" --}}
      class="flex items-center gap-3 p-3 text-lg"
    >
      <i class="fa-solid fa-circle-info"></i>
    Quienes somos
      
    </a>
  </li>
  <li
    class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      wire:navigate 
      href=""
      class="flex items-center gap-3 p-3 text-lg"
    >
    <i class="fa-solid fa-envelopes-bulk"></i>
   Contacto
      
    </a>
  </li>
  <li
    class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      wire:navigate 
      href=""
      class="flex items-center gap-3 p-3 text-lg"
    >
    <i class="fa-solid fa-briefcase"></i>
   Vacantes
      
    </a>
  </li>
  <li
    class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      wire:navigate 
      href=""
      class="flex items-center gap-3 p-3 text-lg"
    >
    <i class="fa-solid fa-download"></i>
    Recursos
      
    </a>
  </li>
  <li
    class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      wire:navigate 
      href=""
      class="flex items-center gap-3 p-3 text-lg"
    >
    <i class="fa-brands fa-glide-g"></i>
    Glosario Gráfico
      
    </a>
  </li>
  </ul>