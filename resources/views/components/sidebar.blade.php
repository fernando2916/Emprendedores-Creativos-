

<aside
    x-data="sidebar()"
    x-init="init()"
    x-on:keydown.window.escape="showMenu = false"
    class="relative"
>
    <!-- Botón abrir -->
    <button
        type="button"
        class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 rounded-md p-1 text-white transition-colors duration-150 outline-none box-content"
        @click="showMenu = true"
    >
        <!-- Ícono Bars -->
        <i class="fa-solid fa-bars text-lg p-1"></i>
    </button>

    <!-- Fondo oscuro -->
    <div
        class="fixed inset-0 z-50 bg-gray-900/60 dark:bg-nav-950/60"
        x-show="showMenu"
        @click.outside="showMenu = false"
        x-transition.opacity
    >
        <!-- Sidebar -->
        <div
            class="fixed left-0 top-0 h-full w-3/4 max-w-sm overflow-y-auto bg-slate-200 dark:bg-nav-900 shadow-lg transition-transform duration-300 ease-out"
            :class="{ 'translate-x-0': showMenu, '-translate-x-full': !showMenu }"
            x-transition
            x-ref="sidebar"
            @touchstart="handleTouchStart($event)"
            @touchmove="handleTouchMove($event)"
        >
            <!-- Botón cerrar -->
            <button
                type="button"
                class="absolute top-5 right-5 rounded-md p-1 text-white bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 box-content"
                @click="showMenu = false"
            >
                <!-- Ícono Times -->
                <i class="fa-solid fa-xmark text-lg p-1"></i>
            </button>

            <!-- Contenido del sidebar -->
            <div class="dark:bg-nav-800 flex h-36 items-center gap-3 bg-white p-5 py-3">
                @auth
                    <div>
                        <span class="text-2xl">{{ Auth::user()->name }}</span>
                        <div class="flex items-center gap-1">
                            <a href="/" class="flex items-center gap-1" @click="showMenu = false">
                                <span class="text-link-400 text-base">Mi Perfil</span>
                                <svg class="w-4 h-4 text-link-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="p-5">
                        <div class="flex items-center justify-center gap-3 pb-3">
                          <i class="fa-solid fa-user"></i>
                            <div>
                                <span class="text-lg font-semibold">Entra a tu cuenta</span>
                                <p class="text-justify text-xs text-slate-500">Podrás comprar, comentar o aprender.</p>
                            </div>
                        </div>
                        <a href="/" @click="showMenu = false">
                            <button class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 w-full rounded-lg p-2 text-white">
                                Ingresar
                            </button>
                        </a>
                    </div>
                @endauth
            </div>

            <div>
                @auth
                    <x-menu-dash/>
                @else
                    <x-menu-side/>
                @endauth
            </div>
        </div>
    </div>
</aside>
