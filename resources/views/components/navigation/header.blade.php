<div class="fixed mx-auto w-full z-50">
{{-- <x-aviso-top :aviso="$aviso" /> --}}


<header class="flex justify-between w-full items-center p-3 bg-light-100 dark:bg-nav-900">
  <div>
    <a wire:navigate href="{{ route('home') }}">

      <img src="{{ asset('images/icono.png') }}" alt="icono de la empresa" class="w-10 h-10" />
    </a>
  </div>
  <div class="md:hidden -order-1 md:order-0">
    <x-navigation.sidebar />
  </div>
  <x-navigation.menu-principal />
  @auth
  <x-navigation.menu-icons />
  @else
  <x-navigation.menu-account />
  @endauth
</header>

</div>
