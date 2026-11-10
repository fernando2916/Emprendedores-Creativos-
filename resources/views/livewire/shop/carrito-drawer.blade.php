<div class="flex min-h-0 flex-1 flex-col">

    {{-- LISTA DE PRODUCTOS --}}
    <div class=" flex-1 overflow-y-scroll py-3">

        @if ($items->isEmpty())

            {{-- CARRITO VACÍO --}}
            <div class="flex h-full min-h-64 flex-col items-center justify-center px-3 py-5 text-center">

                <i class="fa-solid fa-cart-shopping mb-4 text-5xl"></i>

                <h2 class="mb-2 text-lg font-semibold">
                    Tu carrito está vacío
                </h2>

                <p class="mb-5 text-sm ">
                    Añade los artículos que desees comprar.
                </p>

                <a
                    href="{{ route('tienda.index') }}"
                    wire:navigate
                    class="font-semibold text-link-100 hover:underline"
                >
                    Explorar la tienda
                </a>

            </div>

        @else

            <div class="space-y-5">

                @foreach ($items as $item)

                    @php
                        $producto = $item['producto'];
                        $variante = $item['variante'];
                    @endphp

                    <article
                        wire:key="carrito-drawer-{{ $variante->id }}"
                        class="border-b border-gray-200 pb-5 dark:border-gray-700"
                    >

                        <div class="flex gap-3">

                            {{-- IMAGEN --}}
                            <a
                                href="{{ route('tienda.show', $producto) }}"
                                wire:navigate
                                class="w-20 shrink-0"
                            >
                                @if ($item['imagen'])

                                    <img
                                        src="{{ Storage::disk('public')->url($item['imagen']->imagen) }}"
                                        alt="{{ $producto->nombre }}"
                                        class="aspect-square w-full rounded-lg object-cover"
                                    >

                                @else

                                    <div class="flex aspect-square items-center justify-center rounded-lg bg-gray-100 text-gray-400 dark:bg-cont-300">
                                        <i class="fa-regular fa-image text-2xl"></i>
                                    </div>

                                @endif
                            </a>

                            {{-- INFORMACIÓN --}}
                            <div class="min-w-0 flex-1">

                                <span
                                    
                                    class="line-clamp-2 text-sm font-semibold"
                                >
                                    {{ $producto->nombre }}
                                </span>

                                @if ($variante->sku)
                                    <p class="mt-1 text-xs">
                                        SKU: {{ $variante->sku }}
                                    </p>
                                @endif

                                {{-- Opciones de la variante --}}
                                @if ($variante->valores->isNotEmpty())

                                    <div class="mt-2 flex flex-wrap gap-1">

                                        @foreach ($variante->valores as $valor)
                                            <span
                                                wire:key="carrito-drawer-valor-{{ $variante->id }}-{{ $valor->id }}"
                                                class="rounded bg-cont-100 px-2 py-1 text-xs dark:bg-cont-300 "
                                            >
                                                @if ($valor->attribute)
                                                    {{ $valor->attribute->nombre }}:
                                                @endif

                                                {{ $valor->valor }}
                                            </span>
                                        @endforeach

                                    </div>

                                @endif

                                {{-- PRECIOS --}}
                                <div class="mt-3">

                                    <p class="font-bold text-link-100">
                                        ${{ number_format($item['precio_final'], 2) }} MXN
                                    </p>

                                    @if ($item['descuento_aplicado'])

                                        <p class="mt-0.5 text-xs text-alerts-300 line-through">
                                            ${{ number_format($item['precio_original'], 2) }} MXN
                                        </p>

                                        <p class="mt-1 text-xs font-medium text-green-600 dark:text-green-400">
                                            Ahorras ${{ number_format($item['ahorro_unitario'], 2) }}
                                        </p>

                                    @endif

                                    <p class="mt-1 text-xs ">
                                        Cantidad: {{ $item['cantidad'] }}
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- ACCIONES --}}
                        <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs font-medium">

                            <button
                                type="button"
                                wire:click="eliminar({{ $variante->id }})"
                                wire:loading.attr="disabled"
                                wire:target="eliminar({{ $variante->id }})"
                                class=" hover:text-red-600 disabled:opacity-50  dark:hover:text-red-400 cursor-pointer"
                            >
                                <i class="fa-regular fa-trash-can mr-1"></i>
                                Eliminar
                            </button>

                            <button
                                type="button"
                                wire:click="moverAListaDeseos({{ $variante->id }})"
                                wire:loading.attr="disabled"
                                wire:target="moverAListaDeseos({{ $variante->id }})"
                                class="text-link-100 hover:underline disabled:opacity-50 cursor-pointer"
                            >
                                <i class="fa-regular fa-heart mr-1"></i>
                                Mover a lista de deseos
                            </button>

                        </div>

                        {{-- DISPONIBILIDAD --}}
                        @if (! $item['disponible'])

                            <p class="mt-3 rounded-md bg-red-50 p-2 text-xs text-red-700 dark:bg-red-900/20 dark:text-red-300">
                                <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                                Este artículo ya no tiene existencias suficientes o no está disponible.
                            </p>

                        @endif

                    </article>

                @endforeach

            </div>

        @endif

    </div>

    {{-- RESUMEN Y ACCESO AL CARRITO COMPLETO --}}
    <div class="shrink-0 border-t border-gray-200 pt-4 dark:border-gray-700">

        @if ($items->isNotEmpty())

            @if ($ahorroTotal > 0)

                <div class="mb-2 flex items-center justify-between gap-3 text-sm">

                    <span class="">
                        Ahorro en promociones
                    </span>

                    <span class="font-semibold text-green-200 dark:text-green-400">
                        -${{ number_format($ahorroTotal, 2) }} MXN
                    </span>

                </div>

            @endif

            <div class="mb-4 flex items-center justify-between gap-3">

                <span class="font-semibold">
                    Total del carrito
                </span>

                <span class="text-xl font-bold text-link-100">
                    ${{ number_format($total, 2) }} MXN
                </span>

            </div>

        @else

            <div class="mb-4 flex items-center justify-between gap-3">
                <span class="font-semibold">
                    Total del carrito
                </span>

                <span class="text-xl font-bold">
                    $0.00 MXN
                </span>
            </div>

        @endif

        <a
            href="{{ route('carrito.index') }}"
            wire:navigate
            class="flex h-11 w-full items-center justify-center gap-2 rounded-md
                   bg-btn-200 font-medium text-white transition cursor-pointer
                   hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600"
        >
            Ir al carrito

            <i class="fa-solid fa-arrow-right"></i>
        </a>

    </div>

</div>