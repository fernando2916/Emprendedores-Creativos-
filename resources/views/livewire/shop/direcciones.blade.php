<div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">

    {{-- ENCABEZADO --}}
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

        <div>
            <h1 class="text-3xl font-bold">
                Mis direcciones
            </h1>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Administra tus direcciones para futuras compras.
            </p>
        </div>

        @if (! $mostrarFormulario)
            <button
                type="button"
                wire:click="nueva"
                class="inline-flex items-center justify-center gap-2 rounded-lg
                       bg-btn-200 px-4 py-3 font-semibold text-white
                       transition hover:bg-btn-400 dark:bg-btn-400
                       dark:hover:bg-btn-600 cursor-pointer"
            >
                <i class="fa-solid fa-plus"></i>
                Agregar dirección
            </button>
        @endif

    </div>

    {{-- FORMULARIO --}}
    @if ($mostrarFormulario)

        <form
            wire:submit="guardar"
            class="space-y-6 rounded-xl border border-gray-200
                   bg-cont-200 p-5 shadow-sm
                   dark:border-gray-700 dark:bg-cont-400 sm:p-7"
        >

            <div>
                <h2 class="text-xl font-bold">
                    {{ $direccionId ? 'Editar dirección' : 'Nueva dirección' }}
                </h2>

                <p class="mt-1 text-sm ">
                    Completa los datos para identificar y entregar tus pedidos.
                </p>
            </div>

            {{-- ALIAS --}}
            <div>
                <label for="alias" class="mb-2 block text-sm font-medium">
                    Nombre de la dirección
                </label>

                <input
                    id="alias"
                    type="text"
                    wire:model="alias"
                    maxlength="60"
                    placeholder="Ej. Casa, Oficina"
                    class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                >

                @error('alias')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- DESTINATARIO Y TELÉFONO --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>
                    <label for="destinatario" class="mb-2 block text-sm font-medium  after:ml-0.5 after:text-red-500 after:content-['*']">
                        Nombre de quien recibe 
                    </label>

                    <input
                        id="destinatario"
                        type="text"
                        wire:model="destinatario"
                        autocomplete="name"
                        required
                        maxlength="150"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('destinatario')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telefono_contacto" class="mb-2 block text-sm font-medium  after:ml-0.5 after:text-red-500 after:content-['*']">
                        Teléfono de contacto 
                    </label>

                    <input
                        id="telefono_contacto"
                        type="tel"
                        wire:model="telefono_contacto"
                        autocomplete="tel"
                        required
                        maxlength="20"
                        placeholder="Ej. 5512345678"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('telefono_contacto')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- CALLE Y NÚMEROS --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                <div class="md:col-span-1">
                    <label for="calle" class="mb-2 block text-sm font-medium  after:ml-0.5 after:text-red-500 after:content-['*']">
                        Calle 
                    </label>

                    <input
                        id="calle"
                        type="text"
                        wire:model="calle"
                        autocomplete="address-line1"
                        required
                        maxlength="150"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('calle')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="numero_exterior" class="mb-2 block text-sm font-medium  after:ml-0.5 after:text-red-500 after:content-['*']">
                        Número exterior 
                    </label>

                    <input
                        id="numero_exterior"
                        type="text"
                        wire:model="numero_exterior"
                        required
                        maxlength="30"
                        placeholder="Ej. 125 o S/N"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('numero_exterior')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="numero_interior" class="mb-2 block text-sm font-medium">
                        Número interior
                    </label>

                    <input
                        id="numero_interior"
                        type="text"
                        wire:model="numero_interior"
                        maxlength="30"
                        placeholder="Ej. Departamento 4"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('numero_interior')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- CÓDIGO POSTAL --}}
            <div class="rounded-lg border border-link-200 p-4 dark:border-link-700">

                <label for="codigo_postal" class="mb-2 block text-sm font-medium  after:ml-0.5 after:text-red-500 after:content-['*']">
                    Código postal 
                </label>

                <div class="relative max-w-xs">

                    <input
                        id="codigo_postal"
                        type="text"
                        inputmode="numeric"
                        autocomplete="postal-code"
                        wire:model.live.debounce.500ms="codigo_postal"
                        maxlength="5"
                        required
                        placeholder="Ej. 01000"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    <span
                        wire:loading
                        wire:target="codigo_postal"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"
                    >
                        <i class="fa-solid fa-spinner fa-spin"></i>
                    </span>

                </div>

                @error('codigo_postal')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror

                @if ($mensajeCodigoPostal !== '')
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        {{ $mensajeCodigoPostal }}
                    </p>
                @endif

            </div>

            {{-- COLONIA --}}
            <div>
                <label for="colonia" class="mb-2 block text-sm font-medium  after:ml-0.5 after:text-red-500 after:content-['*']">
                    Colonia o asentamiento 
                </label>

                @if (count($coloniasDisponibles) > 0)

                    <select
                        id="colonia"
                        wire:model.live="colonia"
                        required
                        class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
                    >
                        <option value="">Selecciona tu colonia</option>

                        @foreach ($coloniasDisponibles as $opcion)
                            <option
                                wire:key="colonia-{{ md5($opcion['nombre'].'|'.$opcion['municipio'].'|'.$opcion['estado']) }}"
                                value="{{ $opcion['nombre'] }}"
                            >
                                {{ $opcion['nombre'] }}
                                @if ($opcion['tipo'])
                                    — {{ $opcion['tipo'] }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                @else

                    <input
                        id="colonia"
                        type="text"
                        wire:model="colonia"
                        required
                        maxlength="150"
                        placeholder="Escribe tu colonia"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                @endif

                @error('colonia')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- MUNICIPIO Y ESTADO --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>
                    <label for="municipio" class="mb-2 block text-sm font-medium  after:ml-0.5 after:text-red-500 after:content-['*']">
                        Municipio o alcaldía 
                    </label>

                    <input
                        id="municipio"
                        type="text"
                        wire:model="municipio"
                        required
                        maxlength="150"
                        @if (count($coloniasDisponibles) > 0) readonly @endif
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('municipio')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="estado" class="mb-2 block text-sm font-medium">
                        Estado *
                    </label>

                    <input
                        id="estado"
                        type="text"
                        wire:model="estado"
                        required
                        maxlength="100"
                        @if (count($coloniasDisponibles) > 0) readonly @endif
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('estado')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- PAÍS --}}
            <div>
                <label for="pais" class="mb-2 block text-sm font-medium">
                    País
                </label>

                <input
                    id="pais"
                    type="text"
                    wire:model="pais"
                    readonly
                    class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                >
            </div>

            {{-- REFERENCIAS --}}
            <div>
                <label for="referencias" class="mb-2 block text-sm font-medium">
                    Referencias adicionales
                </label>

                <textarea
                    id="referencias"
                    wire:model="referencias"
                    rows="3"
                    maxlength="2000"
                    placeholder="Ej. Casa de dos pisos, portón negro, entre las calles..."
                    class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                ></textarea>

                @error('referencias')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- PREDETERMINADA --}}
            <label class="flex cursor-pointer items-start gap-3 rounded-lg bg-gray-50 p-4 dark:bg-gray-900">

                <input
                    type="checkbox"
                    wire:model="predeterminada"
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-btn-600 focus:ring-btn-600"
                >

                <span>
                    <span class="block text-sm font-medium">
                        Establecer como dirección predeterminada
                    </span>

                    <span class="mt-1 block text-xs text-gray-500 dark:text-gray-400">
                        Se utilizará como dirección preferida al preparar tus compras físicas.
                    </span>
                </span>

            </label>

            {{-- BOTONES --}}
            <div class="flex flex-col-reverse justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-700 sm:flex-row">

                <button
                    type="button"
                    wire:click="cancelar"
                    class="rounded-lg border border-gray-300 px-5 py-2.5
                           text-sm font-medium transition hover:bg-gray-100
                           dark:border-gray-600 dark:hover:bg-gray-700 cursor-pointer"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="guardar"
                    class="rounded-lg bg-btn-200 px-5 py-2.5
                           text-sm font-semibold text-white transition
                           hover:bg-btn-400 disabled:cursor-not-allowed
                           disabled:opacity-50 dark:bg-btn-400
                           dark:hover:bg-btn-600 cursor-pointer"
                >
                    <span wire:loading.remove wire:target="guardar">
                        {{ $direccionId ? 'Guardar cambios' : 'Guardar dirección' }}
                    </span>

                    <span wire:loading wire:target="guardar">
                        Guardando...
                    </span>
                </button>

            </div>

        </form>

    @else

        {{-- LISTADO --}}
        @if ($direcciones->isEmpty())

            <div class="rounded-xl border border-gray-200 bg-cont-200
                        p-10 text-center dark:border-gray-700 dark:bg-cont-400">

                <i class="fa-solid fa-location-dot mb-4 text-5xl text-gray-400"></i>

                <h2 class="mb-2 text-xl font-bold">
                    Todavía no tienes direcciones guardadas
                </h2>

                <p class="mb-6 text-sm ">
                    Añade una dirección para tener tus datos preparados al comprar.
                </p>

                <button
                    type="button"
                    wire:click="nueva"
                    class="rounded-lg bg-btn-200 px-5 py-3 font-semibold
                           text-white transition hover:bg-btn-400
                           dark:bg-btn-400 dark:hover:bg-btn-600 cursor-pointer"
                >
                    Agregar mi primera dirección
                </button>

            </div>

        @else

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                @foreach ($direcciones as $direccion)

                    <article
                        wire:key="direccion-{{ $direccion->id }}"
                        class="rounded-xl border border-gray-200
                               bg-cont-200 p-5 dark:border-gray-700
                               dark:bg-cont-400"
                    >

                        <div class="mb-4 flex items-start justify-between gap-3">

                            <div>
                                <h2 class="text-lg font-bold">
                                    {{ $direccion->alias ?: 'Mi dirección' }}
                                </h2>

                                @if ($direccion->predeterminada)
                                    <span class="mt-2 inline-flex rounded-full
                                                 bg-green-800 px-2.5 py-1
                                                 text-xs font-semibold
                                                 dark:bg-green-900/40 dark:text-green-300">
                                        Predeterminada
                                    </span>
                                @endif
                            </div>

                            <i class="fa-solid fa-location-dot text-xl text-link-100"></i>

                        </div>

                        <div class="space-y-1 text-sm ">

                            <p class="font-semibold text-gray-900 dark:text-white">
                                {{ $direccion->destinatario }}
                            </p>

                            <p>{{ $direccion->telefono_contacto }}</p>

                            <p>
                                {{ $direccion->calle }},
                                {{ $direccion->numero_exterior }}

                                @if ($direccion->numero_interior)
                                    , Int. {{ $direccion->numero_interior }}
                                @endif
                            </p>

                            <p>{{ $direccion->colonia }}</p>

                            <p>
                                {{ $direccion->municipio }},
                                {{ $direccion->estado }},
                                C. P. {{ $direccion->codigo_postal }}
                            </p>

                            @if ($direccion->referencias)
                                <p class="pt-2 text-xs">
                                    <span class="font-semibold">Referencias:</span>
                                    {{ $direccion->referencias }}
                                </p>
                            @endif

                        </div>

                        {{-- ACCIONES --}}
                        <div class="mt-5 flex flex-wrap items-center gap-x-4 gap-y-3 border-t border-gray-200 pt-4 dark:border-gray-700">

                            <button
                                type="button"
                                wire:click="editar({{ $direccion->id }})"
                                class="text-sm font-medium text-link-100 hover:underline cursor-pointer"
                            >
                                <i class="fa-solid fa-pen-to-square mr-1"></i>
                                Editar
                            </button>

                            @unless ($direccion->predeterminada)
                                <button
                                    type="button"
                                    wire:click="marcarPredeterminada({{ $direccion->id }})"
                                    wire:loading.attr="disabled"
                                    class="text-sm font-medium text-link-100 hover:underline cursor-pointer"
                                >
                                    Usar como predeterminada
                                </button>
                            @endunless

                            <button
                                type="button"
                                x-on:click='
                                    Swal.fire({
                                        title: "¿Eliminar dirección?",
                                        text: "Esta dirección dejará de estar disponible para tus futuras compras.",
                                        icon: "warning",
                                        background: "#120024",
                                        color: "#ffffff",
                                        showCancelButton: true,
                                        confirmButtonColor: "#dc2626",
                                        cancelButtonColor: "#4b5563",
                                        confirmButtonText: "Sí, eliminar",
                                        cancelButtonText: "Cancelar",
                                        reverseButtons: true,
                                        focusCancel: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.eliminar({{ $direccion->id }});
                                        }
                                    })
                                '
                                class="text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-700 cursor-pointer"
                            >
                                <i class="fa-solid fa-trash mr-1"></i>
                                Eliminar
                            </button>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    @endif

</div>