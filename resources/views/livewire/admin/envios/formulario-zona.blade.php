<div class="mx-auto max-w-5xl space-y-6 p-4">

    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

        <div>
            <h1 class="text-2xl font-bold ">
                {{ $zonaId ? 'Editar zona de envío' : 'Crear zona de envío' }}
            </h1>

            <p class="mt-1 text-sm ">
                Define la tarifa, la cobertura y las condiciones para envío gratis.
            </p>
        </div>

        <a
            href="{{ route('zona-envio.index') }}"
            wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-md border border-link-300 px-4 py-2.5 text-sm font-medium   dark:border-link-600 "
        >
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>

    </div>

    <form
        wire:submit="guardar"
        class="space-y-6 rounded-lg border border-gray-200 bg-cont-200 p-5 shadow-sm dark:border-gray-700 dark:bg-cont-100 sm:p-7"
    >

        {{-- INFORMACIÓN GENERAL --}}
        <section class="space-y-4">

            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold  dark:border-gray-700 ">
                Información general
            </h2>

            <div>
                <label for="nombre" class="mb-2 block text-sm font-medium">
                    Nombre de la zona *
                </label>

                <input
                    id="nombre"
                    type="text"
                    wire:model="nombre"
                    maxlength="120"
                    required
                    placeholder="Ej. Ciudad de México"
                    class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                >

                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descripcion" class="mb-2 block text-sm font-medium">
                    Descripción
                </label>

                <textarea
                    id="descripcion"
                    wire:model="descripcion"
                    rows="3"
                    placeholder="Describe las localidades que comprende esta zona."
                    class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                ></textarea>

                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </section>

        {{-- TARIFAS --}}
        <section class="space-y-4">

            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold  dark:border-gray-700 ">
                Configuración de tarifas
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>
                    <label for="tarifa" class="mb-2 block text-sm font-medium">
                        Tarifa normal de envío (MXN) *
                    </label>

                    <div class="relative">
                        <span class="absolute left-3 top-7 -translate-y-1/2 ">
                            $
                        </span>

                        <input
                            id="tarifa"
                            type="number"
                            wire:model="tarifa"
                            min="0"
                            step="0.01"
                            required
                            placeholder="120.00"
                            class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 pl-7"
                        >
                    </div>

                    @error('tarifa')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="monto_minimo_envio_gratis" class="mb-2 block text-sm font-medium">
                        Envío gratis desde (MXN)
                    </label>

                    <div class="relative">
                        <span class="absolute left-3 top-7 -translate-y-1/2 ">
                            $
                        </span>

                        <input
                            id="monto_minimo_envio_gratis"
                            type="number"
                            wire:model="monto_minimo_envio_gratis"
                            min="0.01"
                            step="0.01"
                            placeholder="1500.00"
                            class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 pl-7
                        >
                    </div>

                    @error('monto_minimo_envio_gratis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Déjalo vacío si esta zona no ofrecerá envío gratis.
                    </p>
                </div>

            </div>

            <div class="rounded-lg bg-cont-100 p-4 text-sm dark:bg-gray-900 ">
                <i class="fa-solid fa-circle-info mr-1 text-link-100"></i>

                El umbral se calculará sobre el subtotal de los productos después de los descuentos y antes de agregar el envío.
            </div>

        </section>

        {{-- COBERTURA --}}
        <section class="space-y-4">

            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold  dark:border-gray-700 ">
                Cobertura de la zona
            </h2>

            <div>
                <label for="codigosPostales" class="mb-2 block text-sm font-medium">
                    Códigos postales *
                </label>

                <textarea
                    id="codigosPostales"
                    wire:model="codigosPostales"
                    rows="8"
                    required
                    spellcheck="false"
                    placeholder="06000&#10;01000&#10;03100"
                    class="w-full border-link-100 focus:shadow-link-200  rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                ></textarea>

                @error('codigosPostales')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-2 text-xs ">
                    Escribe un código postal por línea. También puedes separarlos con comas o punto y coma. Cada código debe tener cinco dígitos.
                </p>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Un código postal solo puede pertenecer a una zona. Si ya está asignado a otra, primero tendrás que cambiar su asignación.
                </p>
            </div>

        </section>

        {{-- ESTADO --}}
        <section class="space-y-3">

            <h2 class="border-b border-gray-200 pb-3 text-lg font-semibold  dark:border-gray-700 ">
                Estado de la zona
            </h2>

            <label class="flex cursor-pointer items-start gap-3 rounded-lg bg-cont-100 p-4 dark:bg-gray-900">

                <input
                    type="checkbox"
                    wire:model="activa"
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-btn-600 focus:ring-btn-600"
                >

                <span>
                    <span class="block text-sm font-medium">
                        Zona activa
                    </span>

                    <span class="mt-1 block text-xs ">
                        Solo las zonas activas podrán utilizarse para calcular el costo de envío.
                    </span>
                </span>

            </label>

        </section>

        {{-- BOTONES --}}
        <div class="flex flex-col-reverse justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-700 sm:flex-row">

            <button
                type="button"
                wire:click="cancelar"
                class="rounded-md border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700 cursor-pointer"
            >
                Cancelar
            </button>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="guardar"
                class="rounded-md bg-btn-200 hover:bg-btn-400 px-5 py-2.5 text-sm font-medium text-white dark:bg-btn-400 dark:hover:bg-btn-600 disabled:cursor-not-allowed disabled:opacity-60 cursor-pointer"
            >
                <span wire:loading.remove wire:target="guardar">
                    {{ $zonaId ? 'Guardar cambios' : 'Crear zona' }}
                </span>

                <span wire:loading wire:target="guardar">
                    Guardando...
                </span>
            </button>

        </div>

    </form>

</div>