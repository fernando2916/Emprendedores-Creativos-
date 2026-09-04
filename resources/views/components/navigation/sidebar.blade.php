<!-- drawer init and show -->
<div class="text-center">
    <button
        class="bg-light-200 hover:bg-light-300 dark:bg-btn-400 dark:hover:bg-btn-600 rounded-md p-1 text-white transition-colors duration-150 outline-none box-content cursor-pointer"
        type="button" data-drawer-target="drawer-navigation" data-drawer-show="drawer-navigation"
        aria-controls="drawer-navigation">
        <i class="fa-solid fa-bars text-lg p-1"></i>
    </button>
</div>

<!-- drawer component -->
<div id="drawer-navigation"
    class="fixed top-0 left-0 z-40 h-screen overflow-y-auto transition-transform -translate-x-full bg-light-100 w-[20rem] dark:bg-nav-900"
    tabindex="-1" aria-labelledby="drawer-navigation-label">

    <div class="dark:bg-nav-800 flex h-36 items-center gap-3 bg-light-200 py-3">
        @auth
            <div class="flex items-center gap-3 pl-8">
                <div>
                    @if ($avatar = auth()->user()->profile?->avatar)
                        <img src="{{ Storage::url($avatar) }}" alt="Foto de perfil"
                            class="w-10 h-10 rounded-full object-cover">
                    @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre_completo) }}"
                    class="w-10 h-10 rounded-full" />
                    @endif
                </div>
                <div>
                    <span class="text-2xl">{{ auth()->user()->nombre_completo }}</span>
                    <p class="text-[13px] dark:text-gray-500 text-gray-200 italic ">
                        {{ auth()->user()->profile->headline ?? 'Sin título profesional' }}
                    </p>
                    <div class="flex items-center gap-1">
                        <a wire:navigate href="{{ route('perfil.index', ['user' => auth()->user()->username]) }}"
                            class="flex items-center gap-1" @click="showMenu = false">
                            <span class="text-link-200 text-base">Mi Perfil</span>
                            <svg class="w-4 h-4 text-link-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="p-10">
                <div class="flex items-center justify-center gap-3 pb-3">
                    <i class="fa-solid fa-user"></i>
                    <div>
                        <span class="text-lg font-semibold">Entra a tu cuenta</span>
                        <p class="text-justify text-xs text-slate-200">Podrás comprar, comentar o aprender.</p>
                    </div>
                </div>
                <a href="{{ route('login') }}" wire:navigate @click="showMenu = false">
                    <button
                        class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 w-full rounded-lg p-2 flex items-center justify-center gap-2 mx-auto text-white cursor-pointer">
                        <i class="fa-solid fa-user"></i>
                        Ingresar
                    </button>
                </a>
            </div>

        @endauth
    </div>
    <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation"
        class=" bg-light-100 hover:bg-light-300 dark:bg-btn-400 rounded-md text-sm w-8 h-8 absolute top-2.5 inset-e-2.5 inline-flex items-center justify-center dark:hover:bg-btn-600 dark:hover:text-white cursor-pointer">
        <i class="fa-solid fa-xmark text-lg px-1.5"></i>
        <span class="sr-only">Close menu</span>
    </button>

    <div>
        @auth
            <x-navigation.menu-dash />
        @else
            <x-navigation.menu-side />
        @endauth
    </div>
    <ul class="p-2">
        <li class="hover:bg-light-200 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all" @click="showMenu = false">
            <a wire:navigate href="{{ route('home') }}" class="text-sm text-link-100 font-semibold">
                Emprendedores Creativos &copy;
            </a>
            <span class="text-sm font-semibold">
                {{ now()->year }} Todos los derechos reservados.
            </span>
        </li>
    </ul>
</div>
