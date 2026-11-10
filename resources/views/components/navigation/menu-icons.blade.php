<nav class="flex items-center gap-3 md:gap-4">
    <x-utils.btn-darkmode />
    <x-navigation.cart />
    <x-navigation.notification />
    <div class="relative">
        <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay3" data-dropdown-delay="500"
            data-dropdown-trigger="hover"
            class="font-medium rounded-md text-center  items-center gap-1 cursor-pointer hidden md:flex" type="button">
            @if ($avatar = auth()->user()->profile?->avatar)
                <img src="{{ Storage::url($avatar) }}" alt="Foto de perfil"
                    class="w-10 h-10 rounded-full object-cover">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre_completo) }}"
                class="w-10 h-10 rounded-full" />
            @endif
        </button>

        <span
        x-show="$store.indicadores.hayAlertas"
        x-cloak
        class="absolute top-0 right-0
               w-3 h-3 hidden md:flex
               rounded-full
               bg-link-500
               "
    ></span>
    </div>

    <!-- Dropdown perfil -->
    <div class="z-10 hidden bg-light-300 rounded-md shadow-sm w-64 dark:bg-nav-800" id="dropdownDelay3">
        <div class="p-1 space-y-0.5">
            <div
                class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700">
                <div>
                    <a wire:navigate href="{{ route('perfil.index', ['user' => auth()->user()->username]) }}"  class="flex items-center gap-x-3">                       
                        <div class="">
                            <div class="flex items-center gap-2">

                                {{ auth()->user()->nombre_completo }}
                                <p class="text-xs text-alerts-100">
                                    {{ auth()->user()->roles->pluck('name')->join(', ') }}
                                </p>
                            </div>
                            <div class="">
                                <p class="text-link-100">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @can('ver panel')
                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700"
                    wire:navigate href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-user-shield"></i>
                    Panel administrativo
                </a>
            @endcan
            <a class="flex items-center justify-between py-2 px-3 rounded-md  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700"
                href="{{ route('notificaciones.index') }}">
                <div class="gap-x-3.5">

                    <i class="fa-solid fa-bell mr-2"></i>
                    Notificaciones
                </div>
                <span 
                    x-show="$store.indicadores.notificaciones > 0"
                    x-cloak
                    x-text="$store.indicadores.notificaciones > 99
                        ? '99+'
                        : $store.indicadores.notificaciones"
                    class="
                        rounded-full w-7 h-7
                        bg-nav-500
                        text-white
                        text-xs
                        font-bold
                        inline-flex items-center justify-center">
                        0
                </span>
            </a>
                <a class="flex items-center justify-between py-2 px-3 rounded-md  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700"
                href="{{ route('lista-deseos.index')  }}"
                wire:navigate
                >
                <div class="gap-x-3.5">

                    <i class="fa-solid fa-heart mr-2"></i>
                    Lista de deseos
                </div>
                <span x-show="$store.indicadores.listaDeseos > 0"
                    x-cloak
                    x-text="$store.indicadores.listaDeseos"
                    class="
                        rounded-full w-7 h-7
                        bg-nav-500
                        text-white
                        text-xs
                        font-bold
                        inline-flex items-center justify-center">

                </span>
                </a>
            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700"
                wire:navigate href="{{ route("direcciones.index") }}">
                <i class="fa-solid fa-location-dot"></i>
                Mis direcciones
            </a>
            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700"
                wire:navigate href="{{ route("mis-pedidos.index") }}">
                <i class="fa-solid fa-basket-shopping"></i>
                Mis compras
            </a>
            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700"
                wire:navigate {{-- href="{{ route("facturacion.index") }}" --}}>
                <i class="fa-solid fa-file-export"></i>
                Facturación
            </a>
            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700"
                wire:navigate {{-- href="{{ route("soporte.index") }}" --}}>
                <i class="fa-solid fa-gears"></i>
                Soporte
            </a>
            <form action=" {{ route('logout') }}" method="post">

                @csrf
                <button type="submit"
                    class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm dark:text-white hover:bg-slate-400 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 w-full cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Salir
                </button>
            </form>
        </div>
    </div>
</nav>
