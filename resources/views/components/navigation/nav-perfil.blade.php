<aside class="w-full md:w-64 border-r border-gray-200 p-6 flex flex-col items-center">
    <!-- Avatar y Info de usuario -->
    @if ($avatar = auth()->user()->profile?->avatar)
                        <img src="{{ Storage::url($avatar) }}" alt="Foto de perfil"
                            class="w-10 h-10 rounded-full object-cover">
                    @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre_completo) }}"
                    class="w-10 h-10 rounded-full" />
                    @endif
    <h2 class="text-base font-bold text-center">
        {{ auth()->user()->nombre_completo }}
    </h2>
    <p class="text-xs dark:text-gray-500 text-gray-200 italic text-center mb-6">
        {{ auth()->user()->profile->headline ?? 'Sin título profesional' }}
    </p>

    <!-- Navegación -->
    <nav class="w-full space-y-1 text-sm font-medium">
        <a 
        wire:navigate
        wire:current.exact="bg-light-200 dark:bg-purple-700" 
        href="{{ route('perfil.index',  ['user' => auth()->user()->username]) }}"
        class="block px-4 py-2 hover:bg-light-200 dark:hover:bg-nav-700 text-white rounded font-semibold">
            Perfil
        </a>
        <a
        wire:navigate 
        wire:current.exact="bg-light-200 dark:bg-purple-700" 
        href="{{ route('foto.edit',  ['user' => auth()->user()->username]) }}"
        class="block px-4 py-2 hover:bg-light-200 dark:hover:bg-nav-700 text-white rounded font-semibold">
            Fotografia
        </a>
        <a 
        wire:navigate
        wire:current.exact="bg-light-200 dark:bg-purple-700" 
        href="{{ route('cuenta.edit',  ['user' => auth()->user()->username]) }}" 
        class="block px-4 py-2 hover:bg-light-200 dark:hover:bg-nav-700 rounded">
            Seguridad de la cuenta
        </a>
        <a 
        wire:navigate
        wire:current.exact="bg-light-200 dark:bg-purple-700"
        href="{{ route('suscripciones.edit',  ['user' => auth()->user()->username]) }}" 
        class="block px-4 py-2 hover:bg-light-200 dark:hover:bg-nav-700 rounded">
            Suscripciones
        </a>
        <a 
        wire:navigate
        wire:current.exact="bg-light-200 dark:bg-purple-700" 
        href="{{ route('metodos.edit',  ['user' => auth()->user()->username]) }}" 
        class="block px-4 py-2 hover:bg-light-200 dark:hover:bg-nav-700 rounded">
            Métodos de pago
        </a>
        <a 
        wire:navigate
        wire:current.exact="bg-light-200 dark:bg-purple-700" 
        href="{{ route('notify.index',  ['user' => auth()->user()->username]) }}" class="block px-4 py-2 hover:bg-light-200 dark:hover:bg-nav-700 rounded">
            Preferencias de las
            notificaciones
        </a>
        <a
        wire:navigate
        wire:current.exact="bg-light-200 dark:bg-purple-700" 
        href="{{ route('clean.delete',  ['user' => auth()->user()->username]) }}" class="block px-4 py-2 text-red-600 hover:bg-light-200 dark:hover:bg-nav-700 rounded">
            Cerrar cuenta
        </a>
    </nav>
</aside>