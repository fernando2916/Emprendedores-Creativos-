<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="darkMode()" x-init="init()"
    :class="{ 'dark': isDarkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel de Administración | Emprendedores Creativos &copy; </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/255bc8dd2c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('css')
    @livewireStyles
    @fluxAppearance()

</head>

<body class="bg-fondo-100 dark:bg-fondo-200 font-display text-white selection:bg-select-100 selection:text-white">

    <nav class="fixed top-0 z-50 w-full bg-light-100 border-b border-gray-200 dark:bg-nav-900 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="bg-light-200 hover:bg-light-300 dark:bg-btn-400 dark:hover:bg-btn-600 cursor-pointer rounded-md p-1 text-white transition-colors duration-150 outline-none box-content sm:hidden">
                        <span class="sr-only">Abrir panel</span>
                        <i class="fa-solid fa-bars text-lg p-1"></i>
                    </button>
                    <a wire:navigate href="{{ route('dashboard') }}" class="flex ms-2 md:me-24">
                        <img src="{{ asset('images/emprende-blanco.png') }}" class="h-8 me-3" alt="Logotipo empresa" />
                    </a>
                </div>
                <div class="flex items-center">
                    <x-utils.btn-darkMode />
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-link-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Abrir menu usuario</span>
                                @if ($avatar = auth()->user()->profile?->avatar)
                                <img src="{{ Storage::url($avatar) }}" alt="Foto de perfil"
                                    class="w-10 h-10 rounded-full object-cover">
                            @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre_completo) }}"
                            class="w-10 h-10 rounded-full" />
                            @endif
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-light-300 divide-y divide-gray-100 rounded-md shadow-sm dark:bg-nav-800 w-56 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3 space-y-2" role="none">
                                <div class="flex flex-col">

                                    <p class="text-sm" role="none">
                                        {{ auth()->user()->nombre_completo }}
                                    </p>
                                    <p class="text-xs text-alerts-100">
                                        {{ auth()->user()->roles->pluck('name')->join(', ') }}
                                    </p>
                                </div>
                                <p class="text-sm font-medium truncate text-link-100" role="none">
                                    {{ auth()->user()->email }}
                                </p>

                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg  dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700"
                                        wire:navigate href="{{ route('home') }}">
                                        <i class="fa-solid fa-home"></i>
                                        Plataforma
                                    </a>
                                </li>
                                <li>
                                    <form action=" {{ route('logout') }}" method="post">

                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm dark:text-white hover:bg-light-200 focus:outline-hidden focus:bg-gray-100 text-slate-200 dark:hover:bg-nav-700 w-full cursor-pointer">
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                            Salir
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-bg-light-100 border-r border-gray-200 sm:translate-x-0 dark:bg-nav-900 dark:border-gray-700"
        aria-label="Sidebar">
        <x-navigation.items-dash />
    </aside>

    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">

            @yield('contenido')
        </div>
    </div>

    @livewireScripts
    @fluxScripts
    @stack('scripts')
    @if (session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif
    <script>
        function darkMode() {
            return {
                isDarkMode: false,
                init() {
                    const storedTheme = localStorage.getItem('theme');
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    this.isDarkMode = storedTheme === 'dark' || (!storedTheme && prefersDark);
                    this.applyTheme();

                    Livewire.hook('message.processed', () => {
                        this.applyTheme();
                    });
                },
                toggle() {
                    this.isDarkMode = !this.isDarkMode;
                    localStorage.setItem('theme', this.isDarkMode ? 'dark' : 'light');
                    this.applyTheme();
                },
                applyTheme() {
                    document.documentElement.classList.toggle('dark', this.isDarkMode);
                }
            }
        }
    </script>
      <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>

</html>
