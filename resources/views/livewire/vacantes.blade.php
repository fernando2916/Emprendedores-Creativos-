<div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-white min-h-[60vh]  overflow-hidden">
    <!-- Lista de Vacantes -->
    <div class="overflow-y-auto">
        <h2 class="text-2xl font-bold p-6 border-b border-gray-700">Nuestras Vacantes Disponibles</h2>
        <div class="divide-y divide-gray-800 overflow-y-scroll">
            @forelse($vacantes as $vacante)

            {{-- ============================= --}}
            {{-- MÓVIL --}}
            {{-- ============================= --}}
            <a
                wire:navigate
                href="{{ route('vacante.show', ['vacante' => $vacante->identificador]) }}"
                class="md:hidden block p-5 hover:bg-light-200 dark:hover:bg-cont-300 rounded-md transition space-y-3"
            >
        
                <h3 class="text-lg font-semibold">
                    {{ $vacante->puesto }}
                </h3>
        
                <div class="text-sm flex items-center gap-2">
                    <i class="fa-solid fa-location-dot w-4 h-4"></i>
                    {{ $vacante->modalidad }}
                </div>
        
                <div class="text-sm flex items-center gap-2">
                    <i class="fa-solid fa-clock w-4 h-4"></i>
                    {{ $vacante->horario }}
                </div>
        
                <div class="text-sm flex items-center gap-2">
                    <i class="fa-solid fa-building w-4 h-4"></i>
                    {{ $vacante->empresa }}
                </div>
        
                <div class="text-sm font-medium">
                    <i class="fa-solid fa-dollar w-4 h-4"></i>
                    {{ $vacante->salario }} MXN
                </div>
        
                <div class="text-sm font-bold uppercase text-pink-500 mt-4">
                    Ver vacante
                    <i class="fa-solid fa-arrow-right ml-1"></i>
                </div>
        
            </a>
        
        
            {{-- ============================= --}}
            {{-- DESKTOP --}}
            {{-- ============================= --}}
            <div
                wire:click="seleccionarVacante({{ $vacante->id }})"
                class="hidden md:block p-5 cursor-pointer hover:bg-light-200 dark:hover:bg-cont-300 rounded-md transition space-y-3
                {{ $vacanteSeleccionada && $vacanteSeleccionada->id === $vacante->id
                    ? 'dark:bg-cont-300 bg-cont-200'
                    : '' }}"
            >
        
                <h3 class="text-lg font-semibold">
                    {{ $vacante->puesto }}
                </h3>
        
                <div class="text-sm flex items-center gap-2">
                    <i class="fa-solid fa-location-dot w-4 h-4"></i>
                    {{ $vacante->modalidad }}
                </div>
        
                <div class="text-sm flex items-center gap-2">
                    <i class="fa-solid fa-clock w-4 h-4"></i>
                    {{ $vacante->horario }}
                </div>
        
                <div class="text-sm flex items-center gap-2">
                    <i class="fa-solid fa-building w-4 h-4"></i>
                    {{ $vacante->empresa }}
                </div>
        
                <div class="text-sm font-medium">
                    <i class="fa-solid fa-dollar w-4 h-4"></i>
                    {{ $vacante->salario }} MXN
                </div>
        
            </div>
        
        @empty
            <div class="flex flex-col items-center justify-center my-20">
                    <h2 class="text-3xl text-center font-semibold">
                      Por el momento no tenemos vacantes disponibles.
                    </h2>
                    <a href="{{ route('contacto.index') }}" wire:navigate>
                      <button
                        type="button"
                        class="bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md p-3 mt-5 cursor-pointer"
                      >
                        Solicitar Información
                      </button>
                    </a>
                  </div>
            @endforelse
        </div>
    </div>

    <!-- Detalle de Vacante -->
    <div class="p-8 min-h-1/2 bg-light-100 dark:bg-cont-300 rounded-md space-y-5 overflow-y-scroll hidden md:block">
        @if($vacanteSeleccionada)
            <h2 class="text-3xl font-bold mb-2">{{ $vacanteSeleccionada->puesto }}</h2>            
            <p class="text-gray-400 mb-4">{{ $vacanteSeleccionada->modalidad }} | {{ $vacanteSeleccionada->horario }}</p>
            <p class="text-2xl font-semibold text-pink-500 mb-6">${{ $vacanteSeleccionada->salario }} MXN</p>
            <div class=" flex items-center gap-2 my-2">
                        <i class="fa-solid fa-building w-4 h-4"></i>
                         {{ $vacanteSeleccionada->empresa }}
                    </div>

            <h3 class="text-lg font-semibold mb-2">Descripción del puesto</h3>
            <div class="post-content bg-cont-200 p-5 rounded-md 
                        dark:bg-cont-100">
                {!! $vacanteSeleccionada->descripcion !!}
                
            </div>

            <div class="mt-6 flex justify-between items-center">
                <p class=" text-gray-400">Último día para postularse: 
                    <span class="text-white font-medium">
                        {{  $vacanteSeleccionada->postulacion->format('d/m/Y') }}
                    </span>
                </p>
            </div>

            <div class="mt-5 md:mt-0">
              <a wire:navigate class="bg-btn-200 hover:bg-btn-400 text-sm text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors uppercase duration-150 rounded-lg mt-5 font-bold p-3 w-auto" href="{{ route('vacante.show', ['vacante' => $vacanteSeleccionada->identificador]) }}">Postularme</a>
            </div>
        @else
            <p class="text-gray-400 text-center mt-10">Selecciona una vacante para ver los detalles</p>
        @endif
    </div>
</div>

