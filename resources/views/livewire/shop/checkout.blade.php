<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

    {{-- ENCABEZADO --}}
    <div class="mb-8">
        <a
            href="{{ route('carrito.index') }}"
            wire:navigate
            class="mb-3 inline-flex items-center gap-2 text-sm text-link-100"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Volver al carrito
        </a>

        <h1 class="text-3xl font-bold">
            Revisar tu compra
        </h1>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Comprueba tus productos y selecciona la dirección de entrega.
        </p>
    </div>

    @if ($tiposPendientes)
        <div class="mb-6 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-amber-800 dark:border-amber-800 dark:bg-amber-950/30 dark:text-amber-200">
            Tu carrito contiene tipos de artículos cuyo proceso de compra aún no está habilitado. Por ahora estamos preparando la compra de productos físicos.
        </div>
    @endif

    <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-3">

        {{-- DIRECCIÓN DE ENTREGA --}}
        <section class="space-y-5 lg:col-span-2">

            <div class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400 sm:p-6">

                <div class="mb-5 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                    <div>
                        <h2 class="text-xl font-bold">
                            <i class="fa-solid fa-location-dot mr-2 text-link-100"></i>
                            Dirección de entrega
                        </h2>

                        <p class="mt-1 text-sm">
                            Elige dónde quieres recibir tus productos.
                        </p>
                    </div>

                    <a
                        href="{{ route('direcciones.index') }}"
                        wire:navigate
                        class="inline-flex items-center gap-2 text-sm font-semibold text-link-100"
                    >
                        <i class="fa-solid fa-gear"></i>
                        Administrar direcciones
                    </a>
                </div>
                {{-- MODALIDAD DE ENTREGA --}}
                <div class="mb-6 space-y-3">

                    <label
                        class="flex cursor-pointer items-start gap-3 rounded-lg border p-4 transition
                            {{ $tipoEntrega === 'domicilio'
                                ? 'border-nav-500 bg-light-300/50 dark:border-nav-400 dark:bg-nav-950/20'
                                : 'border-gray-200 hover:border-gray-400 dark:border-gray-700' }}"
                    >
                        <input
                            type="radio"
                            name="tipoEntrega"
                            value="domicilio"
                            wire:model.live="tipoEntrega"
                            class="mt-1 h-4 w-4 text-btn-600 focus:ring-btn-600"
                        >

                        <span class="flex-1">
                            <span class="block font-semibold">
                                <i class="fa-solid fa-truck mr-2 text-link-100"></i>
                                Entrega a domicilio
                            </span>

                            <span class="mt-1 block text-sm ">
                                Recibe tus productos en una de tus direcciones guardadas.
                            </span>
                        </span>
                    </label>

                    <label
                        class="flex cursor-pointer items-start gap-3 rounded-lg border p-4 transition
                            {{ $tipoEntrega === 'recoger_tienda'
                                ? 'border-nav-500 bg-light-300/50 dark:border-nav-400 dark:bg-nav-950/20'
                                : 'border-gray-200 hover:border-gray-400 dark:border-gray-700' }}"
                    >
                        <input
                            type="radio"
                            name="tipoEntrega"
                            value="recoger_tienda"
                            wire:model.live="tipoEntrega"
                            class="mt-1 h-4 w-4 accent-purple-600 focus:accent-purple-500 appearance-none checked:border-nav-600 checked:bg-nav-600"
                        >

                        <span class="flex-1">
                            <span class="block font-semibold">
                                <i class="fa-solid fa-store mr-2 text-link-100"></i>
                                Recoger en tienda
                            </span>

                            <span class="mt-1 block text-sm ">
                                Recoge tu pedido personalmente en el punto de entrega.
                            </span>
                        </span>
                    </label>

                </div>

                @if ($tipoEntrega === 'recoger_tienda')

                    <div class="rounded-lg border border-nav-400 bg-light-300 p-4
                                dark:border-nav-900 dark:bg-nav-900">

                        <h3 class="font-semibold">
                            <i class="fa-solid fa-store mr-2"></i>
                            Recogida en tienda seleccionada
                        </h3>

                        <p class="mt-2 text-sm">
                            No necesitas seleccionar una dirección postal para esta modalidad.
                            La ubicación y los horarios del punto de recogida se definirán
                            antes de habilitar la compra definitiva.
                        </p>

                    </div>

                    @elseif ($direcciones->isEmpty())

                    <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center dark:border-gray-600">
                        <i class="fa-solid fa-map-location-dot mb-3 text-3xl text-gray-400"></i>

                        <h3 class="font-semibold">
                            Necesitas una dirección de entrega
                        </h3>

                        <p class="mt-2 text-sm ">
                            Registra una dirección para continuar con la preparación de tu compra.
                        </p>

                        <a
                            href="{{ route('direcciones.index') }}"
                            wire:navigate
                            class="mt-4 inline-flex items-center gap-2 rounded-lg bg-btn-200 px-4 py-2.5 font-semibold text-white hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600"
                        >
                            <i class="fa-solid fa-plus"></i>
                            Agregar dirección
                        </a>
                    </div>

                    @else

                        <div class="space-y-3">

                            @foreach ($direcciones as $direccion)

                                <label
                                    wire:key="checkout-direccion-{{ $direccion->id }}"
                                    class="flex cursor-pointer gap-3 rounded-lg border p-4 transition
                                        {{ (int) $direccionId === $direccion->id
                                            ? 'border-nav-500 bg-light-300/50 dark:border-nav-400 dark:bg-nav-950/20'
                                            : 'border-gray-200 hover:border-gray-400 dark:border-gray-700 dark:hover:border-gray-500' }}"
                                >

                                    <input
                                        type="radio"
                                        name="direccionEntrega"
                                        value="{{ $direccion->id }}"
                                        wire:model.live="direccionId"
                                        class="mt-1 h-4 w-4 border-gray-300 accent-purple-600 focus:accent-purple-500"
                                    >

                                    <div class="min-w-0 flex-1">

                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="font-semibold">
                                                {{ $direccion->alias ?: 'Mi dirección' }}
                                            </span>

                                            @if ($direccion->predeterminada)
                                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                                    Predeterminada
                                                </span>
                                            @endif
                                        </div>

                                        <p class="mt-1 text-sm">
                                            {{ $direccion->destinatario }}
                                        </p>

                                        <p class="mt-1 text-sm ">
                                            {{ $direccion->calle }},
                                            {{ $direccion->numero_exterior }}

                                            @if ($direccion->numero_interior)
                                                , Int. {{ $direccion->numero_interior }}
                                            @endif
                                        </p>

                                        <p class="text-sm ">
                                            {{ $direccion->colonia }},
                                            {{ $direccion->municipio }},
                                            {{ $direccion->estado }},
                                            C. P. {{ $direccion->codigo_postal }}
                                        </p>

                                        <p class="mt-1 text-sm ">
                                            Teléfono: {{ $direccion->telefono_contacto }}
                                        </p>

                                    </div>

                                    @if ((int) $direccionId === $direccion->id)
                                        <i class="fa-solid fa-circle-check mt-1 text-nav-600 dark:text-nav-400"></i>
                                    @endif

                                </label>

                            @endforeach

                        </div>

                        <p class="mt-4 text-xs">
                            <i class="fa-solid fa-circle-info mr-1"></i>
                            Tu selección se guarda en el carrito para que puedas retomarla después.
                        </p>

                @endif   

            </div>

            {{-- PRODUCTOS --}}
            <div class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400 sm:p-6">

                <h2 class="mb-5 text-xl font-bold">
                    <i class="fa-solid fa-box-open mr-2 text-link-100"></i>
                    Productos de tu compra
                </h2>

                @forelse ($items as $item)

                    @php
                        $producto = $item['producto'];
                        $variante = $item['variante'];
                    @endphp

                    <article
                        wire:key="checkout-item-{{ $variante->id }}"
                        class="flex gap-4 border-b border-gray-200 py-4 first:pt-0 last:border-b-0 last:pb-0 dark:border-gray-700"
                    >

                        <div class="w-20 shrink-0 sm:w-24">
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
                        </div>

                        <div class="min-w-0 flex-1">

                            <h3 class="font-semibold">
                                {{ $producto->nombre }}
                            </h3>

                            @if ($variante->sku)
                                <p class="mt-1 text-xs ">
                                    SKU: {{ $variante->sku }}
                                </p>
                            @endif

                            @if ($variante->valores->isNotEmpty())
                                <p class="mt-1 text-sm ">
                                    {{ $variante->valores->pluck('valor')->implode(' / ') }}
                                </p>
                            @endif

                            <p class="mt-2 text-sm ">
                                Cantidad: {{ $item['cantidad'] }}
                            </p>

                            <div class="mt-2 flex flex-wrap items-baseline gap-x-2 gap-y-1">
                                <span class="font-bold text-link-100">
                                    ${{ number_format($item['precio_final'], 2) }} MXN
                                </span>

                                @if ($item['descuento_aplicado'])
                                    <span class="text-sm text-alerts-300 line-through">
                                        ${{ number_format($item['precio_original'], 2) }} MXN
                                    </span>
                                @endif
                            </div>

                            @if (! $item['disponible'])
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                                    Revisa las existencias de este producto antes de continuar.
                                </p>
                            @endif

                        </div>

                        <div class="shrink-0 text-right">
                            <p class="text-xs ">
                                Subtotal
                            </p>

                            <p class="mt-1 font-bold">
                                ${{ number_format($item['subtotal'], 2) }}
                            </p>
                        </div>

                    </article>

                @empty

                    <p class="text-sm t">
                        No hay productos físicos disponibles para revisar en esta etapa.
                    </p>

                @endforelse

            </div>

        </section>

        {{-- RESUMEN --}}
        <aside class="lg:sticky lg:top-16">

            <div class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400">

                <h2 class="mb-5 text-xl font-bold">
                    Resumen de compra
                </h2>

                <div class="space-y-4 text-sm">

                    <div class="flex justify-between gap-3">
                        <span class="">
                            Artículos
                        </span>

                        <span class="font-medium">
                            {{ $items->sum('cantidad') }}
                        </span>
                    </div>

                    @if ($ahorroTotal > 0)
                        <div class="flex justify-between gap-3 text-green-500 dark:text-green-400">
                            <span>Ahorro en promociones</span>

                            <span class="font-semibold">
                                -${{ number_format($ahorroTotal, 2) }} MXN
                            </span>
                        </div>
                    @endif

                    @if ($ahorroTotal > 0)
                        <div class="flex justify-between gap-3 text-green-500 dark:text-green-400">
                            <span>Ahorro en promociones</span>

                            <span class="font-semibold">
                                -${{ number_format($ahorroTotal, 2) }} MXN
                            </span>
                        </div>
                    @endif

                    @if ($resultadoCupon['valido'] && $descuentoCupon > 0)
                        <div class="flex justify-between gap-3 text-green-600 dark:text-green-400">
                            <span>
                                Cupón ({{ $resultadoCupon['codigo'] }})
                            </span>

                            <span class="font-semibold">
                                -${{ number_format($descuentoCupon, 2) }} MXN
                            </span>
                        </div>
                    @endif

                    <div class="flex justify-between gap-3">
                        <span class="">
                            Subtotal
                        </span>

                        <span class="{{ $ahorroTotal > 0 ? 'line-through text-alerts-300' : 'font-medium' }}">
                            ${{ number_format($totalOriginal, 2) }} MXN
                        </span>
                    </div>
                  
                </div>

                <div class="mt-5 rounded-md bg-light-200 p-3 text-xs  dark:bg-cont-300 ">
                    {{-- SUBTOTAL CON DESCUENTOS --}}
                    <div class="space-y-4 text-sm">

                        {{-- ENVÍO --}}
                        <div class=" pt-4 ">

                            <div class="flex justify-between gap-3">
                                <span class="font-medium">
                                    @if ($tipoEntrega === 'recoger_tienda')
                                        Recoger en tienda
                                    @else
                                        Envío a domicilio
                                    @endif
                                </span>

                                @if ($resultadoEnvio['disponible'])

                                    @if ($tipoEntrega === 'recoger_tienda' || $resultadoEnvio['envio_gratis'])
                                        <span class="font-semibold text-green-600 dark:text-green-400">
                                            Gratis
                                        </span>
                                    @else
                                        <span class="font-semibold">
                                            ${{ number_format($resultadoEnvio['costo_envio'], 2) }} MXN
                                        </span>
                                    @endif

                                @else

                                    <span class="font-medium text-amber-600 dark:text-amber-400">
                                        Pendiente
                                    </span>

                                @endif
                            </div>

                            {{-- Nombre de la zona --}}
                            @if ($resultadoEnvio['disponible'] && $resultadoEnvio['zona'])
                                <p class="mt-2 text-xs ">
                                    Zona de entrega: {{ $resultadoEnvio['zona']->nombre }}
                                </p>
                            @endif

                            {{-- Información del envío gratis --}}
                            @if (
                                $resultadoEnvio['disponible']
                                && $tipoEntrega === 'domicilio'
                                && $resultadoEnvio['monto_faltante_envio_gratis'] !== null
                                && ! $resultadoEnvio['envio_gratis']
                            )
                                <p class="mt-2 text-xs text-alerts-300">
                                    Agrega ${{ number_format($resultadoEnvio['monto_faltante_envio_gratis'], 2) }} MXN
                                    más para obtener envío gratis.
                                </p>
                            @endif

                            @if (
                                $resultadoEnvio['disponible']
                                && $tipoEntrega === 'domicilio'
                                && $resultadoEnvio['envio_gratis']
                            )
                                <p class="mt-2 text-xs font-medium text-green-600 dark:text-green-400">
                                    <i class="fa-solid fa-circle-check mr-1"></i>
                                    ¡Tu compra cumple el requisito para envío gratis!
                                </p>
                            @endif

                            {{-- Avisos de cobertura o dirección --}}
                            @unless ($resultadoEnvio['disponible'])
                                <div class="mt-3 rounded-lg bg-amber-50 p-3 text-sm text-amber-800 dark:bg-amber-900/20 dark:text-amber-200">
                                    <i class="fa-solid fa-circle-info mr-1"></i>
                                    {{ $resultadoEnvio['mensaje'] }}
                                </div>
                            @endunless

                        </div> 

                        {{-- CUPÓN DE DESCUENTO --}}
                        <form
                            wire:submit="aplicarCupon"
                            class="mb-6 rounded-md border border-gray-200 p-4 dark:border-gray-700"
                            >
                            <label
                                for="checkout-codigo-cupon"
                                class="mb-2 block font-semibold"
                            >
                                <i class="fa-solid fa-ticket mr-1 text-link-100"></i>
                                ¿Tienes un cupón de descuento?
                            </label>

                            <div class="flex gap-2">
                                <input
                                    id="checkout-codigo-cupon"
                                    type="text"
                                    wire:model="codigoCupon"
                                    maxlength="100"
                                    autocomplete="off"
                                    placeholder="Introduce tu código"
                                    class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-md placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
                                >

                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="aplicarCupon"
                                    class="shrink-0 rounded-md bg-btn-200 px-4 py-2 text-sm font-semibold text-white transition hover:bg-btn-400 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-btn-400 dark:hover:bg-btn-600 cursor-pointer"
                                >
                                    <span wire:loading.remove wire:target="aplicarCupon">
                                        Aplicar
                                    </span>

                                    <span wire:loading wire:target="aplicarCupon">
                                        Validando...
                                    </span>
                                </button>
                            </div>

                            {{-- Mensaje de validación --}}
                            @if ($mensajeCupon !== '')
                                <p
                                    class="mt-3 text-sm
                                        {{ $tipoMensajeCupon === 'error'
                                            ? 'text-red-600 dark:text-red-400'
                                            : 'text-green-600 dark:text-green-400' }}"
                                >
                                    {{ $mensajeCupon }}
                                </p>
                            @endif

                            {{-- Estado del cupón que está guardado en el carrito --}}
                            @if ($resultadoCupon['cupon'])
                                <div class="mt-3 rounded-md p-3 text-sm
                                    {{ $resultadoCupon['valido']
                                        ? 'bg-green-50 text-green-800 dark:bg-green-900/20 dark:text-green-300'
                                        : 'bg-amber-50 text-amber-800 dark:bg-amber-900/20 dark:text-amber-300' }}"
                                >
                                    @if ($resultadoCupon['valido'])
                                        <p class="font-semibold">
                                            <i class="fa-solid fa-circle-check mr-1"></i>
                                            Cupón aplicado
                                        </p>
                                    @else
                                        <p>
                                            <i class="fa-solid fa-circle-info mr-1"></i>
                                            {{ $resultadoCupon['mensaje'] }}
                                        </p>
                                    @endif

                                    <button
                                        type="button"
                                        wire:click="quitarCupon"
                                        wire:loading.attr="disabled"
                                        wire:target="quitarCupon"
                                        class="mt-2 font-semibold underline underline-offset-2 disabled:opacity-50 cursor-pointer"
                                    >
                                        Quitar cupón
                                    </button>
                                </div>
                            @endif
                        </form>

                    </div>
                    {{-- TOTAL DEFINITIVO DE LA COMPRA --}}
                    <div class="border-t border-gray-200 pt-5 dark:border-gray-700">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <span class="block text-lg font-bold">
                                    Total de tu compra
                                </span>

                                <span class="mt-1 block text-xs ">
                                    @if ($tipoEntrega === 'recoger_tienda')
                                        Incluye tus descuentos.
                                    @elseif ($resultadoEnvio['disponible'])
                                        Incluye descuentos y costo de envío.
                                    @else
                                        El costo final se confirmará al calcular el envío.
                                    @endif
                                </span>
                            </div>

                            @if ($totalFinal !== null)
                                <span class="shrink-0 text-2xl font-bold text-link-100">
                                    ${{ number_format($totalFinal, 2) }} MXN
                                </span>
                            @else
                                <span class="shrink-0 text-right text-sm font-semibold text-amber-600 dark:text-amber-400">
                                    Por determinar
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
{{-- 
                @if ($items->contains(fn ($item) => ! $item['disponible']))

                    <div class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-700 dark:bg-red-900/20 dark:text-red-300">
                        Debes resolver los problemas de disponibilidad antes de continuar.
                    </div>

                @elseif ($tiposPendientes)

                    <div class="mt-4 rounded-lg bg-amber-50 p-3 text-sm text-amber-800 dark:bg-amber-900/20 dark:text-amber-200">
                        Hay artículos cuyo proceso de compra todavía no está habilitado.
                    </div>

                @elseif (! $resultadoEnvio['disponible'])

                    <div class="mt-4 rounded-lg bg-amber-50 p-3 text-sm text-amber-800 dark:bg-amber-900/20 dark:text-amber-200">
                        No podemos preparar el total final hasta resolver la cobertura o la dirección de entrega.
                    </div>

                @elseif ($tipoEntrega === 'recoger_tienda')

                    <div class="mt-4 rounded-lg bg-green-50 p-3 text-sm text-green-800 dark:bg-green-900/20 dark:text-green-300">
                        <i class="fa-solid fa-circle-check mr-1"></i>
                        La modalidad de recogida quedó guardada. La ubicación y los horarios se definirán antes de habilitar la compra definitiva.
                    </div>

                @else

                    <div class="mt-4 rounded-lg bg-green-50 p-3 text-sm text-green-800 dark:bg-green-900/20 dark:text-green-300">
                        <i class="fa-solid fa-circle-check mr-1"></i>
                        La tarifa de envío y el total se calcularon correctamente.
                    </div>

                @endif --}}

                @if (
                    ! $tiposPendientes
                    && $items->isNotEmpty()
                    && ! $items->contains(fn ($item) => ! $item['disponible'])
                    && $resultadoEnvio['disponible']
                    && $totalFinal !== null
                    && (
                        ! $resultadoCupon['cupon']
                        || $resultadoCupon['valido']
                    ))
                    <form
                        wire:submit="confirmarPedido"
                        class="mt-6"
                    >
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="confirmarPedido"
                            class="flex w-full items-center justify-center gap-2 rounded-md bg-btn-200 px-5 py-3 font-semibold text-white transition hover:bg-btn-400 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-btn-400 dark:hover:bg-btn-600 cursor-pointer"
                        >
                            <span wire:loading.remove wire:target="confirmarPedido">
                                <i class="fa-solid fa-check mr-1"></i>
                                Confirmar pedido
                            </span>

                            <span wire:loading wire:target="confirmarPedido">
                                <i class="fa-solid fa-spinner fa-spin mr-1"></i>
                                Procesando pedido...
                            </span>
                        </button>

                        <p class="mt-3 text-center text-xs text-gray-500 dark:text-gray-400">
                            Al confirmar, se registrará el pedido y se reservarán las existencias.
                            El pago en línea aún no está habilitado.
                        </p>
                    </form>
                @endif

            </div>

        </aside>

    </div>

</div>