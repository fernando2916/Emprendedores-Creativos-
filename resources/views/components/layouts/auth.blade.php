<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>@yield('titulo') Emprendedores Creativos &copy;</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://kit.fontawesome.com/255bc8dd2c.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @livewireStyles
        @fluxAppearance()
    </head>
    <body class="min-h-screen bg-fondo-100 dark:bg-fondo-200 text-white selection:bg-select-100 selection:text-white font-display">
        
        <nav class="bg-light-200 dark:bg-nav-900 text-slate-800 dark:text-white p-5 fixed w-full">
            <div class="flex justify-between items-center">
                <a wire:navigate href="{{ route('home') }}" class="flex items-center justify-center">
                <img src="{{ asset('images/icono.png') }}" alt="" class="w-11 h-11">
            </a>
           
            <x-utils.btn-darkmode/>
        </div>
        </nav>
        <div class="flex min-h-svh flex-col items-center gap-6 p-2 md:p-10 ">
            <div class="flex w-full max-w-md flex-col gap-6">               
                    <div class="rounded-xl bg-light-200 mt-28 dark:bg-cont-100 shadow-xs mx-2 sm:mx-0">
                        <div class="px-7 md:px-10 py-8">@yield('contenido')</div>
                    </div>
            </div>
        </div>
   
   @livewireScripts
    @fluxScripts
    @stack('scripts')  
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
