<div class="mx-auto max-w-7xl">

    @php
        $estadosLabels = [
            'pendiente' => 'Pendiente',
            'procesando' => 'En proceso',
            'en_preparacion' => 'En preparación',
            'enviado' => 'Enviado',
            'entregado' => 'Entregado',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado',
            'listo_para_recoger' => 'Listo para recoger',
        ];

        $direccion = $orden->direccion_entrega ?? [];
    @endphp

    {{-- ENCABEZADO --}}
    <div class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

        <div>
            <a
                href="{{ route('orden.index') }}"
                wire:navigate
                class="mb-3 inline-flex items-center gap-2 text-sm text-link-100 hover:underline"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Volver a pedidos
            </a>

            <h1 class="text-2xl font-bold">
                Pedido {{ $orden->numero }}
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Registrado el {{ $orden->created_at->format('d/m/Y H:i') }}
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            <span class="rounded-full bg-light-300 px-3 py-2 text-sm font-semibold dark:bg-cont-300">
                {{ $estadosLabels[$orden->estado] ?? ucfirst($orden->estado) }}
            </span>

            <span class="rounded-full bg-light-300 px-3 py-2 text-sm font-semibold dark:bg-cont-300">
                Pago: {{ ucfirst($orden->estado_pago) }}
            </span>

        </div>

    </div>

    <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">

        {{-- COLUMNA PRINCIPAL --}}
        <div class="space-y-6 xl:col-span-2">

            {{-- CLIENTE --}}
            <section class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400">

                <h2 class="mb-4 text-lg font-bold">
                    <i class="fa-solid fa-user mr-2 text-link-100"></i>
                    Información del cliente
                </h2>

                <p class="font-semibold">
                    {{ $orden->usuario?->nombre_completo ?? 'Cliente no disponible' }}
                </p>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $orden->usuario?->email }}
                </p>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Usuario ID: {{ $orden->user_id }}
                </p>

            </section>

            {{-- ARTÍCULOS --}}
            <section class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400">

                <h2 class="mb-5 text-lg font-bold">
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
                            wire:key="admin-orden-item-{{ $item->id }}"
                            class="flex gap-4 border-b border-gray-200 pb-5 last:border-b-0 last:pb-0 dark:border-gray-700"
                        >

                            <div class="h-20 w-20 shrink-0 overflow-hidden rounded-lg bg-light-200 dark:bg-cont-300">

                                @if ($item->imagen)
                                    <img
                                        src="{{ Storage::disk('public')->url($item->imagen) }}"
                                        alt="{{ $item->nombre_articulo }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-full items-center justify-center text-gray-400">
                                        <i class="fa-regular fa-image text-2xl"></i>
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

                                @foreach ($valores as $valor)
                                    <span class="mt-1 mr-1 inline-block rounded bg-light-200 px-2 py-1 text-xs dark:bg-cont-300">
                                        {{ $valor['atributo'] ?? 'Atributo' }}:
                                        {{ $valor['valor'] ?? '' }}
                                    </span>
                                @endforeach

                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Cantidad: {{ $item->cantidad }}
                                </p>

                                <p class="mt-1 text-sm">
                                    Precio unitario:
                                    ${{ number_format($item->precio_unitario, 2) }}
                                </p>

                            </div>

                            <div class="shrink-0 text-right">

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Subtotal
                                </p>

                                <p class="font-bold">
                                    ${{ number_format($item->subtotal, 2) }}
                                </p>

                            </div>

                        </article>

                    @endforeach

                </div>

            </section>

            {{-- SEGUIMIENTO DEL PEDIDO --}}
            <section class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400">

                <h2 class="mb-2 text-lg font-bold">
                    <i class="fa-solid fa-truck-fast mr-2 text-link-100"></i>
                    Seguimiento del pedido
                </h2>

                <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                    Registra los datos de envío que podrá consultar el cliente.
                </p>

                @if ($orden->tipo_entrega === 'domicilio')

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        {{-- PAQUETERÍA --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold">
                                Paquetería
                            </label>

                            <input
                                type="text"
                                wire:model="paqueteria"
                                maxlength="100"
                                placeholder="Ej. DHL, FedEx, Estafeta..."
                                class="w-full rounded-lg border border-gray-300 bg-light-200 px-3 py-3 text-sm outline-none focus:border-btn-400 focus:ring-2 focus:ring-btn-400/30 dark:border-gray-700 dark:bg-cont-300"
                            >

                            @error('paqueteria')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NÚMERO DE GUÍA --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold">
                                Número de guía
                            </label>

                            <input
                                type="text"
                                wire:model="numeroGuia"
                                maxlength="150"
                                placeholder="Número de rastreo"
                                class="w-full rounded-lg border border-gray-300 bg-light-200 px-3 py-3 text-sm outline-none focus:border-btn-400 focus:ring-2 focus:ring-btn-400/30 dark:border-gray-700 dark:bg-cont-300"
                            >

                            @error('numeroGuia')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ENLACE DE RASTREO --}}
                        <div class="sm:col-span-2">
                            <label class="mb-2 block text-sm font-semibold">
                                Enlace de rastreo
                                <span class="font-normal text-gray-500">(opcional)</span>
                            </label>

                            <input
                                type="url"
                                wire:model="urlRastreo"
                                maxlength="2048"
                                placeholder="https://..."
                                class="w-full rounded-lg border border-gray-300 bg-light-200 px-3 py-3 text-sm outline-none focus:border-btn-400 focus:ring-2 focus:ring-btn-400/30 dark:border-gray-700 dark:bg-cont-300"
                            >

                            @error('urlRastreo')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                @else

                    <div class="rounded-lg bg-light-200 p-4 text-sm dark:bg-cont-300">
                        <i class="fa-solid fa-store mr-2 text-link-100"></i>
                        Este pedido se recogerá en tienda. No requiere paquetería ni número de guía.
                    </div>

                @endif

                {{-- FECHAS --}}
                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div class="rounded-lg bg-light-200 p-3 dark:bg-cont-300">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Fecha de envío
                        </p>

                        <p class="mt-1 text-sm font-semibold">
                            {{ $orden->fecha_envio?->format('d/m/Y H:i') ?? 'Pendiente' }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-light-200 p-3 dark:bg-cont-300">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Fecha de entrega
                        </p>

                        <p class="mt-1 text-sm font-semibold">
                            {{ $orden->fecha_entrega?->format('d/m/Y H:i') ?? 'Pendiente' }}
                        </p>
                    </div>

                </div>

                {{-- NOTAS INTERNAS --}}
                <div class="mt-5">
                    <label class="mb-2 block text-sm font-semibold">
                        Notas administrativas internas
                    </label>

                    <textarea
                        wire:model="notasAdmin"
                        rows="4"
                        maxlength="5000"
                        placeholder="Anota información interna sobre la preparación, envío o atención del pedido..."
                        class="w-full rounded-lg border border-gray-300 bg-light-200 px-3 py-3 text-sm outline-none focus:border-btn-400 focus:ring-2 focus:ring-btn-400/30 dark:border-gray-700 dark:bg-cont-300"
                    ></textarea>

                    @error('notasAdmin')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Estas notas solamente son visibles para la administración.
                    </p>
                </div>

                {{-- GUARDAR --}}
                @if ($orden->estado !== 'cancelado')
                    <button
                        type="button"
                        wire:click="guardarSeguimiento"
                        wire:loading.attr="disabled"
                        wire:target="guardarSeguimiento"
                        class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-btn-200 px-5 py-3 text-sm font-semibold text-white transition hover:bg-btn-400 disabled:opacity-50 dark:bg-btn-400 dark:hover:bg-btn-600 sm:w-auto"
                    >
                        <span wire:loading.remove wire:target="guardarSeguimiento">
                            <i class="fa-solid fa-floppy-disk mr-1"></i>
                            Guardar seguimiento
                        </span>

                        <span wire:loading wire:target="guardarSeguimiento">
                            Guardando...
                        </span>
                    </button>
                @endif

            </section>

            {{-- ENTREGA --}}
            <section class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400">

                <h2 class="mb-4 text-lg font-bold">
                    <i class="fa-solid fa-truck-fast mr-2 text-link-100"></i>
                    Información de entrega
                </h2>

                @if ($orden->tipo_entrega === 'recoger_tienda')

                    <p class="font-semibold">
                        <i class="fa-solid fa-store mr-2"></i>
                        Recoger en tienda
                    </p>

                @else

                    <div class="space-y-1 text-sm">

                        <p class="font-semibold">
                            {{ $direccion['destinatario'] ?? 'Sin destinatario' }}
                        </p>

                        <p>
                            {{ $direccion['calle'] ?? '' }}
                            {{ $direccion['numero_exterior'] ?? '' }}
                            {{ !empty($direccion['numero_interior']) ? ', Int. ' . $direccion['numero_interior'] : '' }}
                        </p>

                        <p>
                            {{ $direccion['colonia'] ?? '' }},
                            {{ $direccion['municipio'] ?? '' }},
                            {{ $direccion['estado'] ?? '' }}
                        </p>

                        <p>
                            C. P. {{ $direccion['codigo_postal'] ?? '' }},
                            {{ $direccion['pais'] ?? 'México' }}
                        </p>

                        <p>
                            Teléfono: {{ $direccion['telefono_contacto'] ?? 'No registrado' }}
                        </p>

                        @if (!empty($direccion['referencias']))
                            <p class="pt-2 text-gray-500 dark:text-gray-400">
                                Referencias: {{ $direccion['referencias'] }}
                            </p>
                        @endif

                    </div>

                @endif

                @if ($orden->zona_envio)
                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Zona: {{ $orden->zona_envio }}
                    </p>
                @endif

            </section>

        </div>

        {{-- COLUMNA LATERAL --}}
        <aside class="space-y-6 xl:sticky xl:top-16">

            {{-- CAMBIAR ESTADO --}}
            <section class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400">

                <h2 class="mb-4 text-lg font-bold">
                    Gestionar pedido
                </h2>

                @if (count($estadosDisponibles))

                    <label class="mb-2 block text-sm font-medium">
                        Siguiente estado
                    </label>

                    <select
                        wire:model.live="estadoNuevo"
                        class="w-full rounded-lg border border-gray-300 bg-light-200 px-3 py-3 text-sm dark:border-gray-700 dark:bg-cont-300"
                    >

                        @foreach ($estadosDisponibles as $estado)
                            <option value="{{ $estado }}">
                                {{ $estadosLabels[$estado] ?? $estado }}
                            </option>
                        @endforeach

                    </select>

                    <button
                        type="button"
                        wire:click="actualizarEstado"
                        wire:loading.attr="disabled"
                        wire:target="actualizarEstado"
                        class="mt-3 flex w-full items-center justify-center gap-2 rounded-lg bg-btn-200 px-4 py-3 text-sm font-semibold text-white transition hover:bg-btn-400 disabled:opacity-50 dark:bg-btn-400 dark:hover:bg-btn-600"
                    >
                        <span wire:loading.remove wire:target="actualizarEstado">
                            <i class="fa-solid fa-arrows-rotate mr-1"></i>
                            Actualizar estado
                        </span>

                        <span wire:loading wire:target="actualizarEstado">
                            Actualizando...
                        </span>
                    </button>

                @elseif ($orden->estado === 'entregado' && $orden->estado_pago !== 'pagado')

                    <p class="text-sm text-amber-600 dark:text-amber-400">
                        El pedido está entregado, pero no puede completarse hasta que el pago aparezca como pagado.
                    </p>

                @else

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        No hay más cambios de estado disponibles.
                    </p>

                @endif

                @if (
                    $orden->estado === 'pendiente'
                    && $orden->estado_pago === 'pendiente'
                )

                    <div class="mt-5 border-t border-gray-200 pt-4 dark:border-gray-700">

                        <button
                            type="button"
                            x-on:click.prevent="
                                Swal.fire({
                                    title: '¿Cancelar pedido?',
                                    text: 'Se devolverán las existencias y se liberará el cupón reservado.',
                                    icon: 'warning',
                                    background: '#120024',
                                    color: '#ffffff',
                                    showCancelButton: true,
                                    confirmButtonColor: '#dc2626',
                                    cancelButtonColor: '#4b5563',
                                    confirmButtonText: 'Sí, cancelar',
                                    cancelButtonText: 'Regresar',
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.cancelarPedido();
                                    }
                                })
                            "
                            wire:loading.attr="disabled"
                            wire:target="cancelarPedido"
                            class="w-full rounded-lg border border-red-300 px-4 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-50 disabled:opacity-50 dark:border-red-800 dark:text-red-300 dark:hover:bg-red-900/20"
                        >
                            <i class="fa-solid fa-ban mr-1"></i>
                            Cancelar pedido
                        </button>

                    </div>

                @endif

            </section>

            {{-- RESUMEN ECONÓMICO --}}
            <section class="rounded-xl border border-gray-200 bg-cont-200 p-5 dark:border-gray-700 dark:bg-cont-400">

                <h2 class="mb-4 text-lg font-bold">
                    Resumen económico
                </h2>

                <div class="space-y-3 text-sm">

                    <div class="flex justify-between gap-3">
                        <span>Subtotal original</span>
                        <span>${{ number_format($orden->subtotal_original, 2) }}</span>
                    </div>

                    @if ((float) $orden->descuento_promociones > 0)
                        <div class="flex justify-between gap-3 text-green-600 dark:text-green-400">
                            <span>Promociones</span>
                            <span>-${{ number_format($orden->descuento_promociones, 2) }}</span>
                        </div>
                    @endif

                    @if ((float) $orden->descuento_cupon > 0)
                        <div class="flex justify-between gap-3 text-green-600 dark:text-green-400">
                            <span>Cupón {{ $orden->cupon_codigo }}</span>
                            <span>-${{ number_format($orden->descuento_cupon, 2) }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between gap-3">
                        <span>Envío</span>
                        <span>
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
                            ${{ number_format($orden->total, 2) }}
                            {{ $orden->moneda }}
                        </span>
                    </div>

                </div>

            </section>

            {{-- INFORMACIÓN ADMINISTRATIVA --}}
            <section class="rounded-xl border border-gray-200 bg-cont-200 p-5 text-sm dark:border-gray-700 dark:bg-cont-400">

                <h2 class="mb-3 font-bold">
                    Información adicional
                </h2>

                <div class="space-y-2 text-gray-500 dark:text-gray-400">

                    <p>
                        ID del pedido: {{ $orden->id }}
                    </p>

                    <p>
                        Estado de pago: {{ ucfirst($orden->estado_pago) }}
                    </p>

                    <p>
                        Creado: {{ $orden->created_at->format('d/m/Y H:i') }}
                    </p>

                    <p>
                        Última actualización: {{ $orden->updated_at->format('d/m/Y H:i') }}
                    </p>

                    @if ($orden->fecha_expiracion)
                        <p>
                            Expiración de reserva:
                            {{ $orden->fecha_expiracion->format('d/m/Y H:i') }}
                        </p>
                    @endif

                </div>

            </section>

        </aside>

    </div>

</div>
