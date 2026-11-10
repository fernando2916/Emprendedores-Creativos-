<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <title>@yield('titulo') Emprendedores Creativos &copy; </title>
  <meta name="description" content=@yield('descripcion')>

    @php
        $listaDeseosCountInicial = auth()->check()
            ? auth()->user()->listaDeseos()->count()
            : 0;

        $carritoCountInicial = 0;

        $notificacionesCountInicial = auth()->check()
                ? auth()->user()->unreadNotifications()->count()
                : 0;

        
        if (auth()->check()) {
            $carritoUsuario = auth()->user()->carrito;

            $carritoCountInicial = $carritoUsuario
                ? (int) $carritoUsuario->items()->sum('cantidad')
                : 0;
        }

    @endphp

    <script>
    window.listaDeseosCount = @json((int) $listaDeseosCountInicial);
    window.carritoCount = @json((int) $carritoCountInicial);
    window.notificacionesCount = @json((int) $notificacionesCountInicial);

    document.addEventListener('alpine:init', () => {
        Alpine.store('indicadores', {
            listaDeseos: Number(window.listaDeseosCount ?? 0),
            carrito: Number(window.carritoCount ?? 0),
            notificaciones: Number(window.notificacionesCount ?? 0),

            get hayAlertas() {
                return (
                    this.listaDeseos > 0 ||
                    this.notificaciones > 0
                );
            },

            actualizarListaDeseos(cantidad) {
                this.listaDeseos = Number(cantidad ?? 0);
            },

            actualizarCarrito(cantidad) {
                this.carrito = Number(cantidad ?? 0);
            },

            actualizarNotificaciones(cantidad) {
                this.notificaciones = Number(cantidad ?? 0);
            },
        });
    });
    </script>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
   <script src="https://kit.fontawesome.com/3fe87e3ad0.js" crossorigin="anonymous"></script>
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

@persist('toast')
    <flux:toast position="top end" />
@endpersist


</body>
</html>