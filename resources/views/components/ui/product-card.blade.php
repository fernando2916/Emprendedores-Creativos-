@props([
    'producto'
])

@php
    $variantesActivas = $producto->variantes
        ->where('estado', true);

    $imagenPrincipal =
        $producto->images->firstWhere('principal', true)
        ?? $producto->images->first();
    
        /*
    |--------------------------------------------------------------------------
    | Precios y descuentos
    |--------------------------------------------------------------------------
    */

    $preciosCalculados = app(
        \App\Services\Shop\CalculadoraPrecios::class
    )->calcularVariantes($producto);

    // La variante con el precio final más económico.
    $varianteMasEconomica = $preciosCalculados
        ->sortBy('precio_final')
        ->first();

    $precioMinimo = $preciosCalculados->min('precio_final');
    $precioMaximo = $preciosCalculados->max('precio_final');

    // Datos de la variante cuyo precio se muestra en la tarjeta.
    $precioOriginalMinimo =
        $varianteMasEconomica['precio_original'] ?? null;

    $ahorroMinimo =
        $varianteMasEconomica['ahorro'] ?? 0;

    $porcentajeAhorroMinimo =
        $varianteMasEconomica['porcentaje_ahorro'] ?? 0;

    $tieneDescuentoPrecioMinimo =
        $varianteMasEconomica['aplicado'] ?? false;
    
    /*
    |--------------------------------------------------------------------------
    | Stock y reseñas
    |--------------------------------------------------------------------------
    */

    $precioMinimo = $variantesActivas->min('precio');
    $precioMaximo = $variantesActivas->max('precio');

    $stockTotal = $variantesActivas->sum('stock');

    $totalReseñas = $producto->reseñas->count();

    $promedioRaiting = $totalReseñas > 0
        ? round($producto->reseñas->avg('calificacion')* 2) / 2
        : 0;

@endphp


<article
    class="bg-cont-200 dark:bg-cont-400 rounded-xl overflow-hidden
        transition duration-300 hover:shadow-lg"
    >

    {{-- IMAGEN --}}
    <div class="relative overflow-hidden bg-gray-100 dark:bg-cont-300">

        @if ($imagenPrincipal)

            <img
                src="{{ Storage::disk('public')->url($imagenPrincipal->imagen) }}"
                alt="{{ $producto->nombre }}"
                class="w-full aspect-video object-cover
                    group-hover:scale-105
                    transition duration-500"
            >

        @else

            <div
                class="w-full aspect-video flex items-center justify-center
                    bg-gray-100 dark:bg-cont-300
                    text-gray-400"
            >
                <div class="text-center">

                    <i class="fa-regular fa-image text-4xl mb-2"></i>

                    <p class="text-sm">
                        Sin imagen
                    </p>

                </div>
            </div>

        @endif


        {{-- FAVORITO --}}
        <div class="absolute top-3 right-3 z-10">

            <livewire:shop.lista-deseos-button
                :producto="$producto"
                :key="'wishlist-card-' . $producto->id"
            />

        </div>

    </div>


    {{-- INFORMACIÓN --}}
    <div class="p-4">

        {{-- CATEGORÍA --}}
        <div class="flex flex-wrap items-center gap-2">

            @if ($producto->categoria)

                <span
                    class="text-xs font-semibold
                        bg-categoria-300
                        p-1 rounded-md"
                >
                    {{ $producto->categoria->nombre }}
                </span>

            @endif


            @if ($producto->subCategoria)

                <span
                    class="text-xs font-semibold
                        bg-categoria-300
                        p-1 rounded-md"
                >
                    {{ $producto->subCategoria->nombre }}
                </span>

            @endif

        </div>


        {{-- NOMBRE --}}
        <div class="mt-4">

            <h2 class="font-semibold text-2xl line-clamp-1">
                {{ $producto->nombre }}
            </h2>

        </div>


        {{-- TAGS --}}
        @if ($producto->tags->isNotEmpty())

            <div class="flex flex-wrap gap-2 mt-3">

                @foreach ($producto->tags as $tag)

                    <span
                        class="inline-flex items-center gap-1
                            px-2 py-1 rounded-full
                            text-xs font-medium
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

                <div class="flex items-center text-yellow-400 text-sm">

                    @for ($i = 1; $i <= 5; $i++)

                        @if ($promedioRating >= $i)

                            {{-- Estrella completa --}}
                            <i class="fa-solid fa-star"></i>

                        @elseif ($promedioRating >= ($i - 0.5))

                            {{-- Media estrella --}}
                            <i class="fa-solid fa-star-half-stroke"></i>

                        @else

                            {{-- Estrella vacía --}}
                            <i class="fa-regular fa-star"></i>

                        @endif

                    @endfor

                </div>

                <span class="text-xs">
                    {{ number_format($promedioRating, 1) }}
                </span>

                <span class="text-xs ">
                    ({{ $totalReseñas }})
                </span>

            @else

                <div class="flex items-center gap-2 ">

                    <div class="flex text-sm">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa-regular fa-star"></i>
                        @endfor
                    </div>

                    <span class="text-xs">
                        Sin reseñas
                    </span>

                </div>

            @endif

        </div>



        {{-- DESCRIPCIÓN --}}
        @if ($producto->descripcion)

            <div
                class="font-semibold line-clamp-3 text-sm mt-3 h-16"
            >
                {!! $producto->descripcion !!}
            </div>

        @endif


        {{-- PRECIO --}}
        @if ($precioMinimo !== null)
        
            <div class="mt-4">
        
                <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
        
                    {{-- Indicador para productos con precios variables --}}
                    @if ($precioMinimo != $precioMaximo)
        
                        <span class="text-xs ">
                            Desde
                        </span>
        
                    @endif
        
                    {{-- Precio final --}}
                    <p class="text-2xl font-bold text-btn-400 dark:text-link-100">
                        ${{ number_format($precioMinimo, 2) }} MXN
                    </p>
        
                    {{-- Precio original tachado --}}
                    @if ($tieneDescuentoPrecioMinimo)
        
                        <p class="text-sm text-gray-500 line-through dark:text-gray-400">
                            ${{ number_format($precioOriginalMinimo, 2) }} MXN
                        </p>
        
                    @endif
        
                </div>
        
                {{-- Ahorro de la variante más económica --}}
                @if ($tieneDescuentoPrecioMinimo)
        
                    <div class="mt-2 flex flex-wrap items-center gap-2">
        
                        <span class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-xs font-bold text-red-700 dark:bg-red-900/40 dark:text-red-300">
                            -{{ number_format($porcentajeAhorroMinimo, 0) }}%
                        </span>
        
                        <span class="text-xs font-medium text-green-600 dark:text-green-400">
                            Ahorras ${{ number_format($ahorroMinimo, 2) }} MXN
                        </span>
        
                    </div>
        
                @endif
        
            </div>
        
        @endif


        {{-- STOCK --}}
        <div class="mt-2">

            @if ($stockTotal <= 0)

                <span class="text-sm font-semibold text-red-800">
                    <i class="fa-solid fa-circle-xmark mr-1"></i>
                    Agotado
                </span>

            @elseif ($stockTotal <= 5)

                <span class="text-sm font-semibold text-orange-500">
                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                    Últimas piezas
                </span>

            @else

                <span class="text-sm font-semibold text-green-500">
                    <i class="fa-solid fa-circle-check mr-1"></i>
                    Disponible
                </span>

            @endif

        </div>
        
        {{-- BTN --}}
        <a
            href="{{ route('tienda.show', $producto) }}"
            wire:navigate
            class="group block p-2 rounded-md bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-all font-semibold mx-auto mt-3 text-center w-full"
            >
            Ver producto
            </a>
    </div>

</article>
