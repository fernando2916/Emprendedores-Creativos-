<div>
    @if ($productos->count())

        <div class="max-w-7xl px-3 space-y-4 mx-auto">

            @foreach ($productos as $producto)

                @php
                    $variantesActivas = $producto->variantes
                        ->where('estado', true);

                    $imagenPrincipal =
                        $producto->images->firstWhere('principal', true)
                        ?? $producto->images->first();

                    $precioMinimo = $variantesActivas->min('precio');
                    $precioMaximo = $variantesActivas->max('precio');

                    $stockTotal = $variantesActivas->sum('stock');

                    $totalReseñas = $producto->reseñas->count();

                    $promedioRating = $totalReseñas > 0
                        ? round(
                            $producto->reseñas->avg('calificacion') * 2
                        ) / 2
                        : 0;
                @endphp


                {{-- PRODUCTO --}}
                <article
                    wire:key="wishlist-producto-{{ $producto->id }}"
                    class="group
                           border border-gray-300
                           dark:border-gray-700
                           bg-cont-100
                           dark:bg-cont-400
                           rounded-xl
                           overflow-hidden
                           transition-all duration-300
                           hover:border-link-300
                           hover:shadow-lg"
                >

                    <div
                        class="flex flex-col lg:flex-row
                               lg:items-center
                               gap-5
                               p-4 sm:p-5"
                    >

                        {{-- ================================================= --}}
                        {{-- IMAGEN --}}
                        {{-- ================================================= --}}
                        <a
                            href="{{ route('tienda.show', $producto) }}"
                            wire:navigate
                            class="shrink-0"
                        >

                            @if ($imagenPrincipal)

                                <div
                                    class="w-full
                                           sm:w-28
                                           lg:w-32
                                           aspect-square
                                           rounded-lg
                                           overflow-hidden
                                           bg-gray-100
                                           dark:bg-cont-300"
                                >

                                    <img
                                        src="{{ Storage::disk('public')->url($imagenPrincipal->imagen) }}"
                                        alt="{{ $producto->nombre }}"
                                        class="w-full h-full object-cover
                                               group-hover:scale-105
                                               transition-transform duration-500"
                                    >

                                </div>

                            @else

                                <div
                                    class="w-full
                                           sm:w-28
                                           lg:w-32
                                           aspect-square
                                           rounded-lg
                                           flex
                                           items-center
                                           justify-center
                                           bg-gray-100
                                           dark:bg-cont-300
                                           text-gray-400"
                                >
                                    <i class="fa-regular fa-image text-3xl"></i>
                                </div>

                            @endif

                        </a>


                        {{-- ================================================= --}}
                        {{-- INFORMACIÓN --}}
                        {{-- ================================================= --}}
                        <div class="flex-1 min-w-0">

                            {{-- NOMBRE --}}
                            <a
                                href="{{ route('tienda.show', $producto) }}"
                                wire:navigate
                                class="block"
                            >
                                <h2
                                    class="text-lg sm:text-xl
                                           font-semibold
                                           line-clamp-2
                                           hover:text-link-300
                                           transition"
                                >
                                    {{ $producto->nombre }}
                                </h2>
                            </a>


                            {{-- CATEGORÍA / SUBCATEGORÍA --}}
                            <div class="flex flex-wrap gap-2 mt-2">

                                @if ($producto->categoria)

                                    <span
                                        class="px-2 py-1
                                               rounded-md
                                               text-xs
                                               font-semibold
                                               bg-categoria-300"
                                    >
                                        {{ $producto->categoria->nombre }}
                                    </span>

                                @endif


                                @if ($producto->subCategoria)

                                    <span
                                        class="px-2 py-1
                                               rounded-md
                                               text-xs
                                               font-semibold
                                               bg-categoria-300"
                                    >
                                        {{ $producto->subCategoria->nombre }}
                                    </span>

                                @endif

                            </div>


                            {{-- TAGS --}}
                            @if ($producto->tags->isNotEmpty())

                                <div class="flex flex-wrap gap-2 mt-2">

                                    @foreach ($producto->tags as $tag)

                                        <span
                                            class="inline-flex items-center gap-1
                                                   px-2 py-1
                                                   rounded-full
                                                   text-xs
                                                   font-medium
                                                   bg-nav-600
                                                   dark:bg-cont-500"
                                        >

                                            <i class="fa-solid fa-tag text-2xs"></i>

                                            {{ $tag->nombre }}

                                        </span>

                                    @endforeach

                                </div>

                            @endif


                            {{-- RATING --}}
                            <div class="flex items-center gap-2 mt-3">

                                @if ($totalReseñas > 0)

                                    <div class="flex text-yellow-400 text-sm">

                                        @for ($i = 1; $i <= 5; $i++)

                                            @if ($promedioRating >= $i)

                                                <i class="fa-solid fa-star"></i>

                                            @elseif ($promedioRating >= ($i - 0.5))

                                                <i class="fa-solid fa-star-half-stroke"></i>

                                            @else

                                                <i class="fa-regular fa-star"></i>

                                            @endif

                                        @endfor

                                    </div>

                                    <span class="text-xs">
                                        {{ number_format($promedioRating, 1) }}
                                    </span>

                                    <span
                                        class="text-xs text-gray-500
                                               dark:text-gray-400"
                                    >
                                        ({{ $totalReseñas }})
                                    </span>

                                @else

                                    <span
                                        class="text-xs text-gray-500
                                               dark:text-gray-400"
                                    >
                                        Sin reseñas
                                    </span>

                                @endif

                            </div>


                            {{-- PRECIO + STOCK --}}
                            <div
                                class="flex flex-wrap
                                       items-center
                                       gap-4
                                       mt-3"
                            >

                                @if ($precioMinimo !== null)

                                    <div>

                                        @if ($precioMinimo == $precioMaximo)

                                            <span
                                                class="text-xl
                                                       font-bold
                                                       text-link-100"
                                            >
                                                ${{ number_format($precioMinimo, 2) }}
                                                MXN
                                            </span>

                                        @else

                                            <span
                                                class="text-sm
                                                       text-gray-500
                                                       dark:text-gray-400"
                                            >
                                                Desde
                                            </span>

                                            <span
                                                class="text-xl
                                                       font-bold
                                                       text-link-100"
                                            >
                                                ${{ number_format($precioMinimo, 2) }}
                                                MXN
                                            </span>

                                        @endif

                                    </div>

                                @endif


                                {{-- STOCK --}}
                                @if ($stockTotal <= 0)

                                    <span
                                        class="text-sm
                                               font-semibold
                                               text-red-500"
                                    >
                                        <i class="fa-solid fa-circle-xmark mr-1"></i>
                                        Agotado
                                    </span>

                                @elseif ($stockTotal <= 5)

                                    <span
                                        class="text-sm
                                               font-semibold
                                               text-orange-500"
                                    >
                                        <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                                        Últimas piezas
                                    </span>

                                @else

                                    <span
                                        class="text-sm
                                               font-semibold
                                               text-green-500"
                                    >
                                        <i class="fa-solid fa-circle-check mr-1"></i>
                                        Disponible
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- ACCIONES --}}
                        {{-- ================================================= --}}
                        <div
                            class="w-full
                                   lg:w-auto
                                   lg:min-w-87.5
                                   flex
                                   flex-col
                                   gap-3
                                   shrink-0"
                        >

                            {{-- AÑADIR AL CARRITO --}}
                            <a
                                href="{{ route('tienda.show', $producto) }}"
                                wire:navigate
                                class="w-full
                                       inline-flex
                                       items-center
                                       justify-center
                                       gap-2
                                       px-5 py-3
                                       rounded-md
                                       font-semibold
                                       bg-btn-400
                                       text-white
                                       hover:bg-btn-600
                                       transition"
                            >
                                <i class="fa-solid fa-cart-shopping"></i>

                                Añadir al carrito
                            </a>


                            {{-- QUITAR DE LA LISTA --}}
                            <div class="w-full">

                                <livewire:shop.lista-deseos-button
                                    :producto="$producto"
                                    :mostrar-texto="true"
                                    :key="'wishlist-button-' . $producto->id"
                                />

                            </div>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>


        <div class="mt-8">
            {{ $productos->links() }}
        </div>

    @else

        <div class="text-center py-20">

            <i class="fa-regular fa-heart text-5xl text-gray-400 mb-4"></i>

            <h2 class="text-xl font-semibold mb-2">
                Tu lista de deseos está vacía
            </h2>

            <p class="text-gray-500 dark:text-gray-400 mb-6">
                Guarda los productos que te interesen para encontrarlos
                fácilmente después.
            </p>

            <a
                href="{{ route('tienda.index') }}"
                wire:navigate
                class="inline-flex items-center gap-2
                       px-5 py-3 rounded-md
                       bg-btn-400 text-white
                       font-semibold
                       hover:opacity-90 transition"
            >
                <i class="fa-solid fa-store"></i>
                Explorar tienda
            </a>

        </div>

    @endif
</div>
