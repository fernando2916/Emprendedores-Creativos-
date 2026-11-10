<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if ($items->isEmpty())

        {{-- CARRITO VACÍO --}}
        <div class="rounded-xl border border-gray-200 dark:border-gray-700
                    bg-cont-200 dark:bg-cont-400 p-10 text-center">

            <i class="fa-solid fa-cart-shopping text-5xl mb-5"></i>

            <h2 class="text-xl font-bold mb-2">
                Tu carrito está vacío
            </h2>

            <p class=" mb-6">
                Explora nuestra tienda y encuentra algo que te guste.
            </p>

            <a
                href="{{ route('tienda.index') }}"
                wire:navigate
                class="inline-flex items-center gap-2 rounded-md
                       bg-btn-400 hover:bg-btn-600 px-5 py-3
                       text-white font-semibold transition"
            >
                <i class="fa-solid fa-store"></i>
                Ir a la tienda
            </a>

        </div>

    @else

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- PRODUCTOS --}}
            <div class="lg:col-span-2 space-y-4">

                @foreach ($items as $item)

                    @php
                        $producto = $item['producto'];
                        $variante = $item['variante'];

                        $imagenPrincipal =
                            $producto->images->firstWhere('principal', true)
                            ?? $producto->images->first();
                    @endphp

                    <article
                        wire:key="carrito-{{ $item['key'] }}"
                        class="rounded-xl border border-gray-200
                               dark:border-gray-700 bg-cont-200
                               dark:bg-cont-400 p-4 sm:p-5"
                    >

                        <div class="flex flex-col sm:flex-row gap-5">

                            {{-- IMAGEN --}}
                            <div class="w-full sm:w-36 shrink-0">

                                <a
                                    href="{{ route('tienda.show', $producto) }}"
                                    wire:navigate
                                >
                                    @if ($imagenPrincipal)

                                        <img
                                            src="{{ Storage::disk('public')->url($imagenPrincipal->imagen) }}"
                                            alt="{{ $producto->nombre }}"
                                            class="w-full aspect-square rounded-lg object-cover"
                                        >

                                    @else

                                        <div class="w-full aspect-square rounded-lg
                                                    bg-gray-100 dark:bg-cont-300
                                                    flex items-center justify-center
                                                    text-gray-400">
                                            <i class="fa-regular fa-image text-3xl"></i>
                                        </div>

                                    @endif
                                </a>

                            </div>

                            {{-- INFORMACIÓN --}}
                            <div class="flex-1 min-w-0">

                                <div class="flex items-start justify-between gap-3">

                                    <div>
                                        <h2 class="font-bold text-lg">
                                            <a
                                                href="{{ route('tienda.show', $producto) }}"
                                                wire:navigate
                                                class="hover:text-link-400 transition"
                                            >
                                                {{ $producto->nombre }}
                                            </a>
                                        </h2>

                                        @if ($variante->sku)
                                            <p class="text-xs mt-1">
                                                SKU: {{ $variante->sku }}
                                            </p>
                                        @endif

                                        @if ($variante->valores->isNotEmpty())
                                            <p class="text-sm mt-2 ">
                                                Opciones:
                                                {{ $variante->valores->pluck('valor')->implode(' / ') }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- ELIMINAR --}}
                                    <button
                                        type="button"
                                        wire:click="eliminar({{ $variante->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="eliminar({{ $variante->id }})"
                                        title="Eliminar del carrito"
                                        class="shrink-0 text-red-500 hover:text-red-700
                                               disabled:opacity-50 cursor-pointer"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </div>

                                {{-- PRECIO UNITARIO --}}
                                <div class="mt-4">

                                    <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">

                                        <span class="text-xl font-bold text-link-100">
                                            ${{ number_format($item['precio_final'], 2) }} MXN
                                        </span>

                                        @if ($item['descuento_aplicado'])
                                            <span class="text-sm text-alerts-300 line-through">
                                                ${{ number_format($item['precio_original'], 2) }} MXN
                                            </span>
                                        @endif

                                    </div>

                                    @if ($item['descuento_aplicado'])
                                        <p class="mt-1 text-sm font-medium text-green-500 dark:text-green-400">
                                            Ahorras
                                            ${{ number_format($item['ahorro_unitario'], 2) }}
                                            por unidad
                                        </p>
                                    @endif

                                </div>

                                {{-- CANTIDAD Y SUBTOTAL --}}
                                <div class="mt-5 flex flex-wrap items-end
                                            justify-between gap-4">

                                    <div>
                                        <label class="block text-xs mb-2">
                                            Cantidad
                                        </label>

                                        <div class="inline-flex items-center
                                                    rounded-lg border border-gray-300
                                                    dark:border-gray-600 overflow-hidden">

                                            <button
                                                type="button"
                                                wire:click="disminuir({{ $variante->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="disminuir({{ $variante->id }})"
                                                @disabled($item['cantidad'] <= 1)
                                                class="px-3 py-2 hover:bg-gray-100
                                                       dark:hover:bg-gray-700
                                                       disabled:opacity-40
                                                       disabled:cursor-not-allowed"
                                            >
                                                <i class="fa-solid fa-minus text-xs"></i>
                                            </button>

                                            <span class="min-w-10 text-center text-sm font-semibold">
                                                {{ $item['cantidad'] }}
                                            </span>

                                            <button
                                                type="button"
                                                wire:click="incrementar({{ $variante->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="incrementar({{ $variante->id }})"
                                                @disabled(
                                                    ! $variante->estado
                                                    || ! $producto->estado
                                                    || $item['cantidad'] >= $variante->stock
                                                )
                                                class="px-3 py-2 hover:bg-gray-100
                                                       dark:hover:bg-gray-700
                                                       disabled:opacity-40
                                                       disabled:cursor-not-allowed"
                                            >
                                                <i class="fa-solid fa-plus text-xs"></i>
                                            </button>

                                        </div>

                                        <p class="text-xs  mt-1">
                                            Existencias: {{ $variante->stock }}
                                        </p>
                                    </div>

                                    <div class="text-right">

                                        <p class="text-xs mb-1">
                                            Subtotal
                                        </p>

                                        <p class="text-xl font-bold">
                                            ${{ number_format($item['subtotal'], 2) }} MXN
                                        </p>

                                    </div>

                                </div>

                                {{-- ACCIÓN: MOVER A LISTA DE DESEOS --}}
                                <div class="mt-4 flex flex-wrap items-center gap-4">

                                    <button
                                        type="button"
                                        wire:click="moverAListaDeseos({{ $variante->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="moverAListaDeseos({{ $variante->id }})"
                                        class="inline-flex items-center gap-2 text-sm font-medium
                                            text-link-100 cursor-pointer
                                            disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        <i class="fa-regular fa-heart"></i>

                                        <span wire:loading.remove
                                            wire:target="moverAListaDeseos({{ $variante->id }})">
                                            Mover a lista de deseos
                                        </span>

                                        <span wire:loading
                                            wire:target="moverAListaDeseos({{ $variante->id }})">
                                            Moviendo...
                                        </span>
                                    </button>

                                </div>

                                {{-- DISPONIBILIDAD --}}
                                @if (! $item['disponible'])
                                    <div class="mt-4 rounded-lg bg-red-50
                                                dark:bg-red-900/20 p-3
                                                text-sm text-red-700 dark:text-red-300">
                                        <i class="fa-solid fa-triangle-exclamation mr-1"></i>

                                        La cantidad supera las existencias disponibles
                                        o el producto ya no está disponible.
                                        Ajusta la cantidad o elimina el producto.
                                    </div>
                                @endif

                            </div>

                        </div>

                    </article>

                @endforeach

                <div>
                    <a
                        href="{{ route('tienda.index') }}"
                        wire:navigate
                        class="inline-flex items-center gap-2 text-sm
                               font-semibold text-link-100 hover:underline"
                    >
                        <i class="fa-solid fa-arrow-left"></i>
                        Seguir comprando
                    </a>
                </div>

            </div>

            {{-- RESUMEN --}}
            <aside class="lg:col-span-1">

                <div class="rounded-xl border border-gray-200
                            dark:border-gray-700 bg-cont-200
                            dark:bg-cont-400 p-5 sticky top-6">

                    <h2 class="text-xl font-bold mb-5">
                        Resumen del pedido
                    </h2>

                    <div class="space-y-4 text-sm">

                        <div class="flex justify-between gap-3">
                            <span class="">
                                Productos
                            </span>

                            <span class="font-medium">
                                {{ $cantidadTotal }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="">
                                Subtotal original
                            </span>

                            <span class="{{ $ahorroTotal > 0 ? 'line-through text-alerts-300' : 'font-medium' }}">
                                ${{ number_format($totalOriginal, 2) }} MXN
                            </span>
                        </div>

                        @if ($ahorroTotal > 0)
                            <div class="flex justify-between gap-3 text-green-600 dark:text-green-400">
                                <span>Ahorro por promociones</span>

                                <span class="font-semibold">
                                    -${{ number_format($ahorroTotal, 2) }} MXN
                                </span>
                            </div>
                        @endif

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex justify-between items-start gap-3">
                                <span class="font-semibold">
                                    Total
                                </span>

                                <span class="text-2xl font-bold text-link-100 text-right">
                                    ${{ number_format($total, 2) }} MXN
                                </span>
                            </div>
                        </div>

                    </div>

                    @if ($items->contains(fn ($item) => ! $item['disponible']))
                        <div class="mt-5 rounded-lg bg-red-50
                                    dark:bg-red-900/20 p-3 text-sm
                                    text-red-700 dark:text-red-300">
                            Corrige la disponibilidad de tus productos antes de continuar.
                        </div>
                    @else
                        <a
                        href="{{ route('checkout.index') }}"
                        wire:navigate
                        class="mt-5 flex h-11 w-full items-center justify-center gap-2
                            rounded-md bg-btn-200 font-semibold text-white
                            transition hover:bg-btn-400 dark:bg-btn-400
                            dark:hover:bg-btn-600 cursor-pointer"
                    >
                        Continuar con la compra
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    @endif

                </div>

            </aside>

        </div>

    @endif

</div>