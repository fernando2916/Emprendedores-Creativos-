@extends('components.layouts.principal')

@section('titulo')
    {{ $producto->nombre }} |
@endsection

@section('contenido')
    @php

        $atributosProducto = $producto->atributos;

        $variantesActivas = $producto->variantes->where('estado', true)->values();

        // Calcular precios promocionales de las variantes activas.
        $preciosVariantes = app(
            \App\Services\Shop\CalculadoraPrecios::class
        )->calcularVariantes($producto);

        // Precio final más bajo para mostrar inicialmente.
        $varianteMasEconomica = $preciosVariantes
            ->sortBy('precio_final')
            ->first();

        $precioInicial = $varianteMasEconomica['precio_final'] ?? null;

        $precioOriginalInicial =
            $varianteMasEconomica['precio_original'] ?? null;

        $ahorroInicial =
            $varianteMasEconomica['ahorro'] ?? 0;

        $porcentajeAhorroInicial =
            $varianteMasEconomica['porcentaje_ahorro'] ?? 0;

        $tieneDescuentoInicial =
            $varianteMasEconomica['aplicado'] ?? false;

        $totalReseñas = $producto->reseñas->count();

        $promedioRaiting = $totalReseñas > 0
            ? round($producto->reseñas->avg('calificacion')* 2) / 2
            : 0;

    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumb --}}
        <div class="mb-8 text-base">

            <a href="{{ route('tienda.index') }}" wire:navigate class="hover:text-link-400 transition">
                Tienda
            </a>

            <span class="mx-2">
                <i class="fa-solid fa-angle-right"></i>
            </span>

            @if ($producto->categoria)
                <span>
                    {{ $producto->categoria->nombre }}
                </span>

                <span class="mx-2">
                    <i class="fa-solid fa-angle-right"></i>
                </span>
            @endif

            <span class="font-semibold">
                {{ $producto->nombre }}
            </span>

        </div>



        {{-- Producto --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 xl:gap-14">


            {{-- ================================================= --}}
            {{-- GALERÍA --}}
            {{-- ================================================= --}}

            <div class="space-y-4">

                {{-- Imagen principal --}}
                <div class=" productoPrincipalSwiper rounded-xl overflow-hidden bg-gray-100 dark:bg-cont-300">

                    <div class="swiper-wrapper">

                        @forelse ($producto->images as $imagen)
                            <div class="swiper-slide">
                                <div class="aspect-cover flex items-center justify-center">

                                    <img src="{{ Storage::url($imagen->imagen) }}" alt="{{ $producto->nombre }}"
                                        class="w-full h-full object-contain">

                                </div>
                            </div>

                        @empty

                            <div class="aspect-cover flex items-center justify-center">
                                <div class="text-center text-gray-400">
                                    <i class="fa-regular fa-image text-5xl mb-3"></i>

                                    <p>
                                        Sin imágenes
                                    </p>
                                </div>
                            </div>
                        @endforelse

                    </div>

                </div>


                {{-- Miniaturas --}}
                @if ($producto->images->count() > 1)
                    <div class="swiper-img productoThumbsSwiper">

                        <div class="swiper-wrapper">

                            @foreach ($producto->images as $imagen)
                                <div class="swiper-slide cursor-pointer">

                                    <div
                                        class="aspect-cover rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">

                                        <img src="{{ Storage::url($imagen->imagen) }}" alt="{{ $producto->nombre }}"
                                            class="w-full h-full object-cover">

                                    </div>

                                </div>
                            @endforeach

                        </div>

                    </div>
                @endif

            </div>


            {{-- ================================================= --}}
            {{-- INFORMACIÓN --}}
            {{-- ================================================= --}}

            <div>
                <div class="flex gap-3 items-center">

                    {{-- Marca --}}
                    @if ($producto->brand)
                    <div class="mb-3">
                        
                        <span class="text-sm font-medium text-link-100">
                            {{ $producto->brand->nombre }}
                        </span>
                        
                    </div>
                    @endif
                    @if ($producto->license)
                    <div class="mb-3">
                        
                        <span class="text-sm font-medium text-link-100">
                            {{ $producto->license->nombre }}
                        </span>
                        
                    </div>
                    @endif
                    
                </div>

                {{-- Nombre --}}
                <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                    {{ $producto->nombre }}
                </h1>

                {{-- RATING --}}
                <div class="flex items-center gap-2 my-3">

                    @if ($totalReseñas > 0)

                        <div class="flex items-center text-yellow-400 text-sm">

                            @for ($i = 1; $i <= 5; $i++)

                                @if ($promedioRaiting >= $i)

                                    {{-- Estrella completa --}}
                                    <i class="fa-solid fa-star"></i>

                                @elseif ($promedioRaiting >= ($i - 0.5))

                                    {{-- Media estrella --}}
                                    <i class="fa-solid fa-star-half-stroke"></i>

                                @else

                                    {{-- Estrella vacía --}}
                                    <i class="fa-regular fa-star"></i>

                                @endif

                            @endfor

                        </div>

                        <span class="text-xs">
                            {{ number_format($promedioRaiting, 1) }}
                        </span>

                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            ({{ $totalReseñas }})
                        </span>

                    @else

                        <div class="flex items-center gap-2 text-gray-400">

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


                {{-- Categoría --}}
                <div class="flex flex-wrap items-center gap-2 mb-6">

                    @if ($producto->categoria)
                        <span class="text-xs font-semibold bg-categoria-200 dark:bg-categoria-300 px-2 py-1 rounded-md">
                            {{ $producto->categoria->nombre }}
                        </span>
                    @endif

                    @if ($producto->subCategoria)
                        <span class="text-xs font-semibold bg-categoria-200 dark:bg-categoria-300 px-2 py-1 rounded-md">
                            {{ $producto->subCategoria->nombre }}
                        </span>
                    @endif

                    {{-- Etiquetas --}}
                    @if ($producto->tags->isNotEmpty())
                        <div class="flex flex-wrap items-center gap-2">

                            @foreach ($producto->tags as $tag)
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md
                                            text-xs font-medium
                                            bg-categoria-300 dark:bg-cont-300
                                            
                                            

                                        <i class="fa-solid
                                    fa-tag text-2xs"></i>

                                    {{ $tag->nombre }}

                                </span>
                            @endforeach

                        </div>
                    @endif

                </div>


                {{-- Precio --}}
                @php
                    $precioMinimo = $producto->variantes
                        ->where('estado', true)
                        ->min('precio');

                    $precioMaximo = $producto->variantes
                        ->where('estado', true)
                        ->max('precio');
                @endphp

                <div
                class="mb-3"
                x-data="{
                    precio: @js($precioInicial),
                    precioInicial: @js($precioInicial),
                    precioOriginal: @js($precioOriginalInicial),
                    ahorro: @js($ahorroInicial),
                    porcentajeAhorro: @js($porcentajeAhorroInicial),
                    tieneDescuento: @js($tieneDescuentoInicial),
                    precioOriginalInicial: @js($precioOriginalInicial),
                    ahorroInicial: @js($ahorroInicial),
                    porcentajeAhorroInicial: @js($porcentajeAhorroInicial),
                    tieneDescuentoInicial: @js($tieneDescuentoInicial)
                }"
                x-on:variante-actualizada.window="
                    if ($event.detail.precio == null) {
                        precio = precioInicial;
                        precioOriginal = precioOriginalInicial;
                        ahorro = ahorroInicial;
                        porcentajeAhorro = porcentajeAhorroInicial;
                        tieneDescuento = tieneDescuentoInicial;
                    } else {
                        precio = Number($event.detail.precio);

                        precioOriginal = Number(
                            $event.detail.precio_original ?? $event.detail.precio
                        );

                        ahorro = Number($event.detail.ahorro ?? 0);

                        porcentajeAhorro = Number(
                            $event.detail.porcentaje_ahorro ?? 0
                        );

                        tieneDescuento = Boolean($event.detail.aplicado ?? false);
                    }
                "
                >
                {{-- Precio actual --}}
                <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">

                    <template x-if="precio !== null">
                        <span
                            class="text-3xl font-bold text-link-100"
                            x-text="'$' + Number(precio).toLocaleString('es-MX', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' MXN'"
                        ></span>
                    </template>

                    {{-- Precio original tachado --}}
                    <template x-if="tieneDescuento && precioOriginal > precio">
                        <span
                            class="text-base text-gray-500 line-through dark:text-gray-400"
                            x-text="'$' + Number(precioOriginal).toLocaleString('es-MX', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' MXN'"
                        ></span>
                    </template>

                </div>

                {{-- Información del ahorro --}}
                <template x-if="tieneDescuento && precioOriginal > precio">
                    <div class="mt-2 flex flex-wrap items-center gap-2">

                        <span
                            class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-xs font-bold text-red-700 dark:bg-red-900/40 dark:text-red-300"
                            x-text="'-' + Number(porcentajeAhorro).toLocaleString('es-MX', {
                                maximumFractionDigits: 2
                            }) + '%'"
                        ></span>

                        <span
                            class="text-sm font-medium text-green-600 dark:text-green-400"
                            x-text="'Ahorras $' + Number(ahorro).toLocaleString('es-MX', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' MXN'"
                        ></span>

                    </div>
                </template>
                </div>                  

                    {{-- SKU --}}
                    <div
                        class="mb-6"
                        x-data="{ sku: null }"
                        x-on:variante-actualizada.window="
                            sku = $event.detail.sku
                        "
                        >
                        <div
                            x-show="sku"
                            x-cloak
                            class="text-base "
                        >
                            <span class="font-semibold">
                                SKU:
                            </span>

                            <span x-text="sku" class="font-bold"></span>
                        </div>
                    </div>

                <div class="flex flex-col gap-4 text-xs md:text-base w-full mx-auto"  
                        x-data="{
                            qty: 1,
                            varianteStock: null
                        }"
                        x-on:variante-actualizada.window="
                            varianteStock = $event.detail.stock
                        ">
                        <div class="flex items-center space-x-6 mb-3">

                            <button
                                type="button"
                                x-on:click="qty = Math.max(1, qty - 1)"
                                x-bind:disabled="qty <= 1"
                                class="bg-btn-400
                                    hover:bg-btn-600
                                    transition-all
                                    rounded-md
                                    px-3 py-1.5
                                    text-2xl
                                    disabled:bg-btn-800
                                    disabled:cursor-not-allowed
                                    cursor-pointer"
                                >
                                -
                            </button>
                        
                            <span
                                x-text="qty"
                                class="inline-block w-4 text-center"
                            >
                            </span>
                        
                            <button
                                type="button"
                                x-on:click="qty++"
                                x-bind:disabled="
                                    varianteStock !== null &&
                                    qty >= varianteStock
                                "
                                class="bg-btn-400
                                    hover:bg-btn-600
                                    transition-all
                                    rounded-md
                                    px-3 py-1.5
                                    text-2xl
                                    text-center
                                    cursor-pointer
                                    disabled:bg-btn-800
                                    disabled:cursor-not-allowed"
                            >
                                +
                            </button>
                    
                        </div>
                        {{-- BOTONES --}}
                        <div class="flex w-full justify-between gap-4">

                            {{-- CARRITO --}}
                            <button
                                type="button"
                                x-on:click="$dispatch('agregar-al-carrito', {
                                    cantidad: qty
                                })"
                                x-bind:disabled="
                                    varianteStock !== null &&
                                    varianteStock <= 0
                                "
                                class="px-6 py-3 rounded-md font-semibold
                                    bg-btn-400 text-white
                                    hover:opacity-90 transition
                                    disabled:opacity-50 w-1/2
                                    disabled:cursor-not-allowed mb-3 cursor-pointer"
                            >
                                <i class="fa-solid fa-cart-shopping mr-2"></i>
                                Añadir al carrito
                            </button>
                        
                        
                            {{-- LISTA DE DESEOS --}}
                            <div class="w-1/2">
                        
                                <livewire:shop.lista-deseos-button
                                    :producto="$producto"
                                    :mostrar-texto="true"
                                    :key="'wishlist-detail-' . $producto->id"
                                />
                        
                            </div>
                        
                        </div>
                </div>

                <livewire:shop.producto-variantes :producto="$producto" />
                
                {{-- Descripción --}}
                @if ($producto->descripcion)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-6">

                        <h2 class="font-bold text-lg mb-3">
                            Descripción
                        </h2>

                        <div class="rounded-md p-3 text-lg post-content ql-editor">
                            {!! $producto->descripcion !!}
                        </div>

                    </div>
                @endif
                

                

            </div>

        </div>

    </div>

@endsection
