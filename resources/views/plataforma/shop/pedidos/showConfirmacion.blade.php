@extends('components.layouts.principal')

@section('titulo')
    Detalle del pedido |
@endsection

@section('contenido')

@php
    $estados = [
        'pendiente' => [
            'nombre' => 'Pendiente',
            'icono' => 'fa-clock',
            'clase' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
            'descripcion' => 'Tu pedido está registrado y pendiente de continuar.',
        ],
        'procesando' => [
            'nombre' => 'En proceso',
            'icono' => 'fa-gears',
            'clase' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
            'descripcion' => 'Tu pedido está siendo procesado.',
        ],
        'en_preparacion' => [
            'nombre' => 'En preparación',
            'icono' => 'fa-box',
            'clase' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
            'descripcion' => 'Estamos preparando tus artículos.',
        ],
        'enviado' => [
            'nombre' => 'Enviado',
            'icono' => 'fa-truck',
            'clase' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
            'descripcion' => 'Tu pedido ha sido enviado.',
        ],
        'entregado' => [
            'nombre' => 'Entregado',
            'icono' => 'fa-house-circle-check',
            'clase' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
            'descripcion' => 'Tu pedido aparece como entregado.',
        ],
        'completado' => [
            'nombre' => 'Completado',
            'icono' => 'fa-circle-check',
            'clase' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
            'descripcion' => 'Tu pedido se ha completado correctamente.',
        ],
        'cancelado' => [
            'nombre' => 'Cancelado',
            'icono' => 'fa-ban',
            'clase' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
            'descripcion' => 'Este pedido fue cancelado y sus reservas fueron liberadas.',
        ],

        'listo_para_recoger' => [
            'nombre' => 'Listo para recoger',
            'icono' => 'fa-store',
            'clase' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
            'descripcion' => 'Tu pedido está listo para que lo recojas en tienda.',
        ],
    ];

    $estadoActual = $estados[$orden->estado] ?? [
        'nombre' => ucfirst(str_replace('_', ' ', $orden->estado)),
        'icono' => 'fa-circle-info',
        'clase' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
        'descripcion' => 'Consulta el estado de tu pedido.',
    ];

    $estadosProgreso = $orden->tipo_entrega === 'recoger_tienda'
        ? [
            'pendiente',
            'procesando',
            'en_preparacion',
            'listo_para_recoger',
            'entregado',
            'completado',
        ]
        : [
            'pendiente',
            'procesando',
            'en_preparacion',
            'enviado',
            'entregado',
            'completado',
        ];

    $indiceEstado = array_search($orden->estado, $estadosProgreso, true);

    $direccion = $orden->direccion_entrega ?? [];
@endphp

<div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">

    {{-- NAVEGACIÓN --}}
    <div class="mb-7 flex flex-wrap items-center justify-between gap-3">

        <a
            href="{{ route('mis-pedidos.index') }}"
            wire:navigate
            class="inline-flex items-center gap-2 text-sm text-link-100 hover:underline"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Volver a mis pedidos
        </a>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Pedido realizado el {{ $orden->created_at->format('d/m/Y H:i') }}
        </p>

    </div>

    {{-- MENSAJES --}}
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300">
            <i class="fa-solid fa-circle-check mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-300">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- ENCABEZADO DEL PEDIDO --}}
    <div class="mb-7 rounded-xl border border-gray-200 bg-cont-200 p-6 dark:border-gray-700 dark:bg-cont-400">

        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Número de pedido
                </p>

                <h1 class="mt-1 text-2xl font-bold">
                    {{ $orden->numero }}
                </h1>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    <i class="fa-regular fa-calendar mr-1"></i>
                    {{ $orden->created_at->format('d/m/Y') }}
                </p>
            </div>

            <div class="sm:text-right">

                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-semibold {{ $estadoActual['clase'] }}">
                    <i class="fa-solid {{ $estadoActual['icono'] }}"></i>
                    {{ $estadoActual['nombre'] }}
                </span>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    {{ $estadoActual['descripcion'] }}
                </p>

            </div>

        </div>

        @if ($orden->estado === 'pendiente' && $orden->fecha_expiracion)

            <div class="mt-5 rounded-lg bg-amber-50 p-3 text-sm text-amber-800 dark:bg-amber-900/20 dark:text-amber-300">
                <i class="fa-solid fa-clock mr-1"></i>
                Reserva de existencias hasta:
                <strong>{{ $orden->fecha_expiracion->format('d/m/Y H:i') }}</strong>
            </div>

        @endif

        {{-- PROGRESO --}}
        @if ($orden->estado !== 'cancelado')

            <div class="mt-8">

                <div class="flex items-center justify-between mx-auto">

                    @foreach ($estadosProgreso as $estado)
                        @php
                            $indice = array_search($estado, $estadosProgreso, true);
                            $activo = $indiceEstado !== false && $indice <= $indiceEstado;
                            $ultimo = $loop->last;
                        @endphp

                        <div class="flex min-w-0 flex-1 items-center">

                            <div class="flex flex-col items-center text-center">

                                <span class="flex h-8 w-8 items-center justify-center rounded-full text-xs
                                    {{ $activo
                                        ? 'bg-nav-600 text-white dark:bg-nav-400'
                                        : 'bg-gray-200 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                    <i class="fa-solid {{ $activo ? 'fa-check' : 'fa-circle' }}"></i>
                                </span>

                                <span class="mt-2 hidden text-xs sm:block
                                    {{ $activo ? 'font-semibold' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $estados[$estado]['nombre'] }}
                                </span>

                            </div>

                            @unless ($ultimo)
                                <div class="mx-1 h-1 flex-1 rounded
                                    {{ $indiceEstado !== false && $indice < $indiceEstado
                                        ? 'bg-nav-600 dark:bg-nav-400'
                                        : 'bg-gray-200 dark:bg-gray-700' }}">
                                </div>
                            @endunless

                        </div>
                    @endforeach

                </div>

            </div>

            <p class="mt-3 text-xs text-gray-500 dark:text-gray-400 sm:hidden">
                Estado actual: {{ $estadoActual['nombre'] }}
            </p>

        @else

            <div class="mt-5 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/20 dark:text-red-300">
                <i class="fa-solid fa-ban mr-2"></i>
                El pedido fue cancelado.
            </div>

        @endif

    </div>

    <div class="grid grid-cols-1 items-start gap-7 lg:grid-cols-3">

        {{-- ARTÍCULOS --}}
        <section class="space-y-6 lg:col-span-2">

            <div class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400 sm:p-6">

                <h2 class="mb-5 text-xl font-bold">
                    <i class="fa-solid fa-box-open mr-2 text-link-100"></i>
                    Artículos del pedido
                </h2>

                <div class="space-y-5">

                    @foreach ($orden->items as $item)

                        @php
                            $datos = $item->datos_articulo ?? [];
                            $valores = $datos['valores'] ?? [];
                        @endphp

                        <article
                            wire:key="detalle-orden-item-{{ $item->id }}"
                            class="flex gap-4 border-b border-gray-200 pb-5 last:border-b-0 last:pb-0 dark:border-gray-700"
                        >

                            <div class="h-24 w-24 shrink-0 overflow-hidden rounded-lg bg-light-200 dark:bg-cont-300">

                                @if ($item->imagen)
                                    <img
                                        src="{{ Storage::disk('public')->url($item->imagen) }}"
                                        alt="{{ $item->nombre_articulo }}"
                                        class="w-full aspect-square rounded-lg object-cover"
                                    >
                                @else
                                    <div class="flex h-full items-center justify-center text-gray-400">
                                        <i class="fa-regular fa-image text-3xl"></i>
                                    </div>
                                @endif

                            </div>

                            <div class="min-w-0 flex-1">

                                <h3 class="font-semibold">
                                    {{ $item->nombre_articulo }}
                                </h3>

                                @if ($item->sku)
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        SKU: {{ $item->sku }}
                                    </p>
                                @endif

                                @if (count($valores))
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @foreach ($valores as $valor)
                                            <span class="rounded-md bg-light-200 px-2 py-1 text-xs dark:bg-cont-300">
                                                {{ $valor['atributo'] ?? 'Atributo' }}:
                                                {{ $valor['valor'] ?? '' }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Cantidad: {{ $item->cantidad }}
                                </p>

                                <div class="mt-2 flex flex-wrap items-center gap-2 text-sm">

                                    <span class="font-semibold text-link-100">
                                        ${{ number_format($item->precio_unitario, 2) }} MXN
                                    </span>

                                    @if ((float) $item->precio_original_unitario > (float) $item->precio_unitario)
                                        <span class="text-gray-500 line-through dark:text-gray-400">
                                            ${{ number_format($item->precio_original_unitario, 2) }} MXN
                                        </span>
                                    @endif

                                </div>

                            </div>

                            <div class="shrink-0 text-right">

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Subtotal
                                </p>

                                <p class="mt-1 font-bold">
                                    ${{ number_format($item->subtotal, 2) }} MXN
                                </p>

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

            {{-- ENTREGA --}}
            <div class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400 sm:p-6">

                <h2 class="mb-4 text-xl font-bold">
                    <i class="fa-solid fa-truck-fast mr-2 text-link-100"></i>
                    Información de entrega
                </h2>

                @if ($orden->tipo_entrega === 'recoger_tienda')

                    <div class="rounded-lg bg-light-200 p-4 dark:bg-cont-300">
                        <p class="font-semibold">
                            <i class="fa-solid fa-store mr-2"></i>
                            Recoger en tienda
                        </p>

                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Tu pedido fue registrado para recogida en tienda.
                        </p>
                    </div>

                @elseif ($direccion)

                    <div class="rounded-lg bg-light-200 p-4 dark:bg-cont-300">

                        <p class="font-semibold">
                            {{ $direccion['destinatario'] ?? '' }}
                        </p>

                        <p class="mt-2 text-sm">
                            {{ $direccion['calle'] ?? '' }}
                            {{ $direccion['numero_exterior'] ?? '' }}

                            @if (!empty($direccion['numero_interior']))
                                , Int. {{ $direccion['numero_interior'] }}
                            @endif
                        </p>

                        <p class="text-sm">
                            {{ $direccion['colonia'] ?? '' }},
                            {{ $direccion['municipio'] ?? '' }},
                            {{ $direccion['estado'] ?? '' }}
                        </p>

                        <p class="text-sm">
                            C. P. {{ $direccion['codigo_postal'] ?? '' }},
                            {{ $direccion['pais'] ?? 'México' }}
                        </p>

                        @if (!empty($direccion['telefono_contacto']))
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <i class="fa-solid fa-phone mr-1"></i>
                                {{ $direccion['telefono_contacto'] }}
                            </p>
                        @endif

                        @if (!empty($direccion['referencias']))
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Referencias: {{ $direccion['referencias'] }}
                            </p>
                        @endif

                    </div>

                @else

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        No hay una dirección registrada para este pedido.
                    </p>

                @endif

                @if ($orden->zona_envio)
                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Zona de envío: {{ $orden->zona_envio }}
                    </p>
                @endif

                {{-- SEGUIMIENTO VISIBLE PARA EL CLIENTE --}}
                @if (
                    $orden->tipo_entrega === 'domicilio'
                    && ($orden->paqueteria || $orden->numero_guia)
                    )

                    <div class="mt-5 rounded-lg border border-gray-200 p-4 dark:border-gray-700">

                        <h3 class="font-bold">
                            <i class="fa-solid fa-box-open mr-2 text-link-100"></i>
                            Rastrea tu pedido
                        </h3>

                        @if ($orden->paqueteria)
                            <p class="mt-3 text-sm">
                                <span class="text-gray-500 dark:text-gray-400">
                                    Paquetería:
                                </span>
                                <strong>{{ $orden->paqueteria }}</strong>
                            </p>
                        @endif

                        @if ($orden->numero_guia)
                            <p class="mt-2 text-sm">
                                <span class="text-gray-500 dark:text-gray-400">
                                    Número de guía:
                                </span>

                                <strong>{{ $orden->numero_guia }}</strong>
                            </p>
                        @endif

                        @if ($orden->fecha_envio)
                            <p class="mt-2 text-sm">
                                <span class="text-gray-500 dark:text-gray-400">
                                    Fecha de envío:
                                </span>
                                {{ $orden->fecha_envio->format('d/m/Y H:i') }}
                            </p>
                        @endif

                        @if ($orden->fecha_entrega)
                            <p class="mt-2 text-sm">
                                <span class="text-gray-500 dark:text-gray-400">
                                    Fecha de entrega:
                                </span>
                                {{ $orden->fecha_entrega->format('d/m/Y H:i') }}
                            </p>
                        @endif

                        @if ($orden->url_rastreo)
                            <a
                                href="{{ $orden->url_rastreo }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-4 inline-flex items-center gap-2 rounded-lg bg-btn-200 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600"
                            >
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                Consultar rastreo
                            </a>
                        @endif

                    </div>

                @endif

            </div>

        </section>

        {{-- RESUMEN --}}
        <aside class="space-y-6 lg:sticky lg:top-16">

            <div class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400">

                <h2 class="mb-5 text-xl font-bold">
                    Resumen de compra
                </h2>

                <div class="space-y-3 text-sm">

                    <div class="flex justify-between gap-3">
                        <span>Subtotal original</span>
                        <span class="font-medium">
                            ${{ number_format($orden->subtotal_original, 2) }}
                        </span>
                    </div>

                    @if ((float) $orden->descuento_promociones > 0)
                        <div class="flex justify-between gap-3 text-green-600 dark:text-green-400">
                            <span>Promociones</span>
                            <span class="font-semibold">
                                -${{ number_format($orden->descuento_promociones, 2) }}
                            </span>
                        </div>
                    @endif

                    @if ((float) $orden->descuento_cupon > 0)
                        <div class="flex justify-between gap-3 text-green-600 dark:text-green-400">
                            <span>
                                Cupón {{ $orden->cupon_codigo }}
                            </span>
                            <span class="font-semibold">
                                -${{ number_format($orden->descuento_cupon, 2) }}
                            </span>
                        </div>
                    @endif

                    <div class="flex justify-between gap-3">
                        <span>Envío</span>
                        <span class="font-medium">
                            @if ((float) $orden->costo_envio <= 0)
                                Gratis
                            @else
                                ${{ number_format($orden->costo_envio, 2) }}
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between gap-3 border-t border-gray-200 pt-4 text-lg font-bold dark:border-gray-700">
                        <span>Total</span>
                        <span class="text-link-100">
                            ${{ number_format($orden->total, 2) }} MXN
                        </span>
                    </div>

                </div>

            </div>

            {{-- PAGO --}}
            <div class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400">

                <h2 class="mb-3 font-bold">
                    Estado del pago
                </h2>

                @if ($orden->estado_pago === 'pagado')
                    <p class="text-sm font-semibold text-green-600 dark:text-green-400">
                        <i class="fa-solid fa-circle-check mr-1"></i>
                        Pagado
                    </p>
                @elseif ($orden->estado_pago === 'cancelado')
                    <p class="text-sm font-semibold text-red-600 dark:text-red-400">
                        <i class="fa-solid fa-circle-xmark mr-1"></i>
                        Cancelado
                    </p>
                @else
                    <p class="text-sm font-semibold text-amber-600 dark:text-amber-400">
                        <i class="fa-solid fa-clock mr-1"></i>
                        Pendiente de pago
                    </p>
                @endif

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    El pago en línea todavía no está habilitado.
                </p>

            </div>

            {{-- CANCELACIÓN --}}
            @if (
                $orden->estado === 'pendiente'
                && $orden->estado_pago === 'pendiente'
                )
                <div class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400">

                    <h2 class="mb-2 font-bold">
                        ¿Cambiaste de opinión?
                    </h2>

                    <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                        Puedes cancelar tu pedido mientras siga pendiente.
                    </p>

                    <livewire:shop.cancelar-pedido
                        :orden="$orden"
                        :key="'cancelar-pedido-' . $orden->id"
                    />

                </div>
            @endif

            <a
                href="{{ route('mis-pedidos.index') }}"
                wire:navigate
                class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-300 px-5 py-3 text-sm font-semibold transition hover:bg-light-200 dark:border-gray-700 dark:hover:bg-cont-300"
            >
                <i class="fa-solid fa-list"></i>
                Ver todos mis pedidos
            </a>

        </aside>

    </div>

</div>

@endsection