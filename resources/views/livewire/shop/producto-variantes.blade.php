<div>

    @if ($producto->variantes->where('estado', true)->isNotEmpty())

        <div class="border-t border-gray-200 dark:border-gray-700 pt-7">

            <h2 class="text-lg font-semibold mb-6">
                Selecciona una talla y un color si aplica.
            </h2>


            {{-- ============================================== --}}
            {{-- ATRIBUTOS --}}
            {{-- ============================================== --}}

            @if ($varianteSeleccionada)

                <div class="my-5">
            
                    @if ($varianteSeleccionada->stock <= 0)
            
                        <span class="text-sm font-semibold text-red-500">
                            <i class="fa-solid fa-circle-xmark mr-1"></i>
                            Agotado
                        </span>
            
                    @elseif ($varianteSeleccionada->stock <= 4)
            
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
            @endif

            @foreach ($producto->atributos as $atributo)

                @php

                    $valoresDisponibles = $producto->variantes
                        ->where('estado', true)
                        ->flatMap(function ($variante) use ($atributo) {

                            return $variante->valores
                                ->where('producto_attribute_id', $atributo->id);

                        })
                        ->unique('id')
                        ->values();

                @endphp


                @if ($valoresDisponibles->isNotEmpty())

                    <div class="mb-6">

                        <div class="mb-3">

                            <label class="font-semibold">
                                {{ $atributo->nombre }}
                            </label>

                        </div>


                        <div class="flex flex-wrap gap-3">

                            @foreach ($valoresDisponibles as $valor)
                            @php
                                $seleccionado =
                                    isset($seleccionados[$atributo->id]) &&
                                    (int) $seleccionados[$atributo->id] === (int) $valor->id;
                            @endphp

                                    <button
                                    type="button"
                                    wire:key="atributo-{{ $atributo->id }}-valor-{{ $valor->id }}"
                                    wire:click="seleccionar({{ $atributo->id }}, {{ $valor->id }})"
                                    @class([
                                        'px-4 py-2 rounded-lg border transition font-medium cursor-pointer',
                                
                                        'border-btn-400 bg-btn-400 ring-2 ring-btn-400/20'
                                            => $seleccionado,
                                
                                        'border-gray-300 dark:border-gray-600
                                        hover:border-btn-400 hover:text-btn-400'
                                            => !$seleccionado,
                                    ])
                                >
                                    {{ $valor->valor }}
                                </button>

                            @endforeach

                        </div>

                    </div>

                @endif

            @endforeach

        </div>
        

    @endif

</div>