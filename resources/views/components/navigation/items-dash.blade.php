<div class="h-full px-3 pb-4 overflow-y-auto bg-light-100 dark:bg-nav-900 pt-5">
    <ul class="space-y-2 font-medium">
        <li>
            <a wire:navigate href="{{ route('dashboard') }}"
            wire:navigate wire:current.exact="bg-light-200 dark:bg-purple-700"
            class="flex items-center p-2 rounded-md dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
            <i class="fa-solid fa-home"></i>
            <span class="ms-3">Inicio</span>
        </a>
    </li>
    @can('ver empresa')
    <div>
       <p class="text-gray-400 ml-2">Empresa</p>
      {{-- @can('contacto index')
  
      <li>
        <a href="{{ route('admin.contacto.index') }}" wire:navigate
          class="flex items-center p-2 rounded-lg dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
          <i class="fa-solid fa-envelope"></i>
          <span class="ms-3">
            Contacto
          </span>
        </a>
      </li>
      @endcan --}}
      @can('boletin index')
  
      <li>
        <a href="{{ route('admin.boletin.index') }}" wire:navigate
          class="flex items-center p-2 rounded-lg dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
          <i class="fa-solid fa-envelope-open"></i>
          <span class="ms-3">
            Boletin
          </span>
        </a>
      </li>
      @endcan
      {{-- @can('vacante index')
  
      <li>
        <a href="{{ route('admin.vacante.index') }}" wire:navigate
          class="flex items-center p-2 rounded-lg dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
          <i class="fa-solid fa-briefcase"></i>
          <span class="ms-3">
            Vacantes
          </span>
        </a>
      </li>
      @endcan --}}
    </div>
    @endcan
    
    @can('ver legales')
    <div>
        <p class="text-gray-400 ml-2">Legales</p>
      @can('avisoPriv index')
  
      <li>
        <a href="{{ route('admin.privacy.index') }}" wire:navigate wire:current.exact="bg-light-200 dark:bg-purple-700"
          class="flex items-center p-2 rounded-md dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
          <i class="fa-solid fa-file"></i>
          <span class="ms-3">
            Aviso de privacidad
          </span>
        </a>
      </li>
      @endcan
      @can('terminsCon index')
  
      <li>
        <a href="{{ route('admin.terminos.index') }}" wire:navigate wire:current.exact="bg-light-200 dark:bg-purple-700"
          class="flex items-center p-2 rounded-md dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
          <i class="fa-solid fa-file-lines"></i>
          <span class="ms-3">
            Terminos y condiciones
          </span>
        </a>
      </li>
      @endcan
    </div>
    @endcan
    @can('ver promo')

    <div>
      <p class="text-gray-400 ml-2">Promo</p>
      @can('banner index')

      <li>
        <a href="{{ route('admin.banner.index') }}" wire:navigate
          class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
          <i class="fa-solid fa-image"></i>
          Diapositivas
        </a>
      </li>
      @endcan
      {{-- @can('aviso index')

      <li>
        <a href="{{ route('admin.aviso.index') }}" wire:navigate
          class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
          <i class="fa-solid fa-bullhorn"></i>
          Avisos
        </a>
      </li>
      @endcan --}}

    </div>
    @endcan
    </ul>
</div>
