<div class="text-center relative">
    <button
        class="cursor-pointer"
        type="button"
        data-drawer-target="carrito-de-compras"
        data-drawer-show="carrito-de-compras"
        data-drawer-placement="right"
        aria-controls="carrito-de-compras"
        x-bind:aria-label="
            'Abrir carrito, ' +
            $store.indicadores.carrito +
            ' unidades'
        "
    >
        <i class="fa-solid fa-cart-shopping"></i>
    </button>

    {{-- CONTADOR DINÁMICO --}}
    <span
        x-cloak
        x-show="$store.indicadores.carrito > 0"
        x-text="
            $store.indicadores.carrito > 99
                ? '99+'
                : $store.indicadores.carrito
        "
        class="absolute -top-3 -inset-e-3
               inline-flex min-w-5 h-5 px-1
               rounded-full bg-nav-500
               items-center justify-center
               text-xs font-semibold"
    ></span>
</div>
 
 <!-- drawer component -->
 <div
        id="carrito-de-compras"
        class="fixed top-0 right-0 z-40 flex h-full flex-col
        overflow-hidden p-4 transition-transform translate-x-full
        bg-cont-200 dark:bg-nav-900 w-[20rem] md:w-96"
        tabindex="-1"
         aria-labelledby="carrito-drawer-titulo"
>
    <div 
        class="border-b border-default pb-4 mb-5 flex items-center gap-2">
            <h5 
                id="carrito-drawer-titulo" 
                class="inline-flex items-center gap-2 text-lg font-medium">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="">
                        Carrito de compras
                    </span>
            </h5>
            <button
                type="button"
                data-drawer-hide="carrito-de-compras"
                aria-controls="carrito-de-compras"
                aria-label="Cerrar carrito"
                class="absolute top-2.5 inset-e-2.5 flex h-9 w-9
                    items-center justify-center rounded-md cursor-pointer
                    bg-btn-200 text-white transition
                    hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600"
                >
                <i class="fa-solid fa-xmark"></i>
            </button>
    </div>
    <livewire:shop.carrito-drawer />
 </div>