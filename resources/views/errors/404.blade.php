<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Página no Encontrada | Emprendedores Ceativos &copy; </title>
        <meta name="description" content=@yield('descripcion')>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://kit.fontawesome.com/255bc8dd2c.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @livewireStyles
        @fluxAppearance()
    </head>

    <body class="bg-fondo-100 dark:bg-fondo-200 font-display text-white selection:bg-select-100 selection:text-white">
        <main class="pt-15.75">
            <div class="flex min-h-svh flex-col items-center gap-6 p-2 md:p-10 ">
                <div class="flex w-full max-w-md flex-col gap-6">
                    <div class="rounded-xl bg-light-200 mt-28 dark:bg-cont-100 shadow-xs mx-2 sm:mx-0">
                        <div class="px-7 md:px-10 py-8">
                            <div class="flex flex-col justify-center w-full mx-auto text-center">
                                <p class="text-link-100 font-bold text-[180px]">404</p>
                                <p class="font-semibold text-[30px]">Página no Encontrada</p>
                            </div>
                            <p class="text-center">Lo sentimos, la ruta solicitada no existe.</p>
                        </div>
                    </div>
                    <div class="flex justify-between gap-5">
                        <button
                            class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full cursor-pointer flex items-center justify-center gap-2">
                            <a href="{{ route('home') }}" wire:navigate>Inicio</a>
                        </button>
                        <button
                            class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full cursor-pointer flex items-center justify-center gap-2">
                            <a href="{{ route('contacto') }}" wire:navigate>Contacto</a>
                        </button>

                    </div>
                </div>
            </div>
        </main>
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
