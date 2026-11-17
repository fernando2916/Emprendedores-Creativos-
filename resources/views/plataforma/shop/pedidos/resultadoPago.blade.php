@extends('components.layouts.principal')

@section('titulo')
    Resultado de pago |
@endsection

@section('contenido')

<div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">

    <div class="rounded-2xl border border-gray-200 bg-cont-200 p-8 text-center shadow-sm dark:border-gray-700 dark:bg-cont-400">

        @if ($intento->orden)

            @if ($intento->orden->estado_pago === 'pagado')

                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">
                    <i class="fa-solid fa-check text-3xl"></i>
                </div>

                <h1 class="mt-6 text-2xl font-bold">
                    ¡Pago confirmado!
                </h1>

                <p class="mt-3 text-gray-600 dark:text-gray-300">
                    Tu pago fue confirmado correctamente y tu pedido ya está registrado.
                </p>

                @if ($intento->orden->estado === 'en_espera_stock')

                    <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 p-4 text-left text-sm text-amber-800 dark:border-amber-800 dark:bg-amber-900/20 dark:text-amber-300">
                        <i class="fa-solid fa-clock mr-2"></i>
                        Tu pago está confirmado. Algunas unidades están pendientes de disponibilidad de inventario. Te notificaremos cuando tengamos una actualización.
                    </div>

                @endif

                <div class="mt-6 rounded-lg bg-light-200 p-4 dark:bg-cont-300">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Número de pedido
                    </p>

                    <p class="mt-1 text-xl font-bold">
                        {{ $intento->orden->numero }}
                    </p>
                </div>

                @if ($puedeVerPedido)

                    <a
                        href="{{ route('pedido.confirmacion', $intento->orden->id) }}"
                        class="mt-7 inline-flex items-center justify-center gap-2 rounded-lg bg-btn-200 px-6 py-3 font-semibold text-white transition hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600"
                    >
                        <i class="fa-solid fa-box"></i>
                        Consultar mi pedido
                    </a>

                @endif

            @else

                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                    <i class="fa-solid fa-clock text-3xl"></i>
                </div>

                <h1 class="mt-6 text-2xl font-bold">
                    Tu pedido está pendiente
                </h1>

                <p class="mt-3 text-gray-600 dark:text-gray-300">
                    Tenemos registrado tu pedido, pero todavía no aparece como pagado.
                </p>

            @endif

        @else

            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                <i class="fa-solid fa-hourglass-half text-3xl"></i>
            </div>

            <h1 class="mt-6 text-2xl font-bold">
                Estamos verificando tu pago
            </h1>

            <p class="mt-3 text-gray-600 dark:text-gray-300">
                Mercado Pago nos ha devuelto a esta página, pero todavía no tenemos una confirmación registrada.
            </p>

            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                No necesitas realizar otro pago. Cuando recibamos y validemos la notificación de Mercado Pago, actualizaremos el estado de tu compra.
            </p>

        @endif

        <div class="mt-8 border-t border-gray-200 pt-6 dark:border-gray-700">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Referencia de compra
            </p>

            <p class="mt-1 break-all text-sm font-semibold">
                {{ $intento->referencia_externa }}
            </p>

            <a
                href="{{ route('tienda.index') }}"
                class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-link-100 hover:underline"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Volver a la tienda
            </a>

        </div>

    </div>

</div>

@endsection