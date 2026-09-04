<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <title>@yield('titulo') Emprendedores Creativos &copy; </title>
  <meta name="description" content=@yield('descripcion')>

   @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://kit.fontawesome.com/255bc8dd2c.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @livewireStyles
  @fluxAppearance()
</head>
<body class="bg-fondo-100 dark:bg-fondo-200 font-display text-white selection:bg-select-100 selection:text-white">
  <x-navigation.header/>

  <main class="pt-15.75">
    @yield('contenido')
  </main>
  <x-navigation.footer/>
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