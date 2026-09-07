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
    </ul>
</div>
