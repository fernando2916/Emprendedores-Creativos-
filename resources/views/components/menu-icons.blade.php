<nav class="flex items-center gap-2">
  <x-btn-darkmode/>
  <x-cart/>
  <x-notification/>
  <div class="m-1 hs-dropdown [--trigger:hover] relative inline-flex">
    <button id="hs-dropdown-hover-event" type="button" class="hs-dropdown-toggle  inline-flex items-center gap-x-2 disabled:opacity-50 disabled:pointer-events-none " aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
      <i class="fa-solid fa-user"></i>
     
     
    </button>
  
    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-slate-600 shadow-md rounded-lg mt-2 dark:bg-nav-800 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-hover-event">
      <div class="p-1 space-y-0.5">
        <div class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-slate-400 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 ">
          <i class="fa-solid fa-user-circle"></i>
          nombre apellido
        </div>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-slate-400 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 " href="/dashboard">
          <i class="fa-solid fa-user-shield"></i>
         Panel administrativo
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-slate-400 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 " href="/notificaciones">
          <i class="fa-solid fa-bell"></i>
          Notificaciones
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-slate-400 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 " href="/mi-cuenta/mi-perfil">
          <i class="fa-solid fa-user-circle"></i>
          Mi perfil
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-slate-400 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 " href="/mi-cuenta/mis-cursos">
          <i class="fa-solid fa-basket-shopping"></i>
          Mis compras
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-slate-400 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 " href="/facturacion">
          <i class="fa-solid fa-file-export"></i>
          Facturación
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-slate-400 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 " href="/mi-cuenta-soporte">
          <i class="fa-solid fa-gears"></i>
          Soporte
        </a>
        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-slate-400 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 " href="/salir">
          <i class="fa-solid fa-right-from-bracket"></i>
          Salir
        </a>
      </div>
    </div>
  </div>
</nav>