<div>
    @if ($mostrarTexto)

    <button
        type="button"
        wire:click="toggle"
        wire:loading.attr="disabled"
        class="w-full px-6 py-3 rounded-md font-semibold
               bg-btn-400
               hover:bg-btn-600
               transition
               disabled:opacity-50
               disabled:cursor-not-allowed
               cursor-pointer"
    >

        @if ($enLista)

            <i class="fa-solid fa-heart mr-2"></i>
            Quitar de la lista

        @else

            <i class="fa-regular fa-heart mr-2"></i>
            Agregar a la lista

        @endif

    </button>

@else

    <button
        type="button"
        wire:click="toggle"
        wire:loading.attr="disabled"
        class="w-9 h-9 rounded-full
               bg-btn-200 dark:bg-btn-400
               flex items-center justify-center
               transition hover:scale-105
               disabled:opacity-50"
        title="{{ $enLista
            ? 'Quitar de la lista de deseos'
            : 'Agregar a la lista de deseos' }}"
    >

        @if ($enLista)

            <i class="fa-solid fa-heart text-link-200"></i>

        @else

            <i class="fa-regular fa-heart"></i>

        @endif

    </button>

@endif
</div>
