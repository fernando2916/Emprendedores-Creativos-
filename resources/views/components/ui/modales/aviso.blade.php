@props(['privacy'])

<div class="block md:flex items-center">

    <button data-modal-target="aviso-modal" data-modal-toggle="aviso-modal" class="flex items-center font-medium text-link-100  transition-colors duration-150 cursor-pointer disabled:opacity-50 disabled:pointer-events-none " type="button" >
        Aviso de privacidad
        </button>
    
    <!-- Default Modal -->
    <div id="aviso-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-light-200 rounded-lg shadow-sm dark:bg-nav-800">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <div class="flex flex-col">
    
                             <h2 class="text-xl font-semibold mb-4">{{ $privacy->nombre }}</h2>
                             <p class="mb-4">
                                Versión vigente: {{ $privacy->fecha->translatedFormat('j \d\e F, Y') }}
                            </p>
                        </div>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-btn-600 dark:hover:text-white" data-modal-hide="aviso-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                  <div class="overflow-y-scroll h-120 p-4">
                    <div class="ql-editor">
                        {!! $privacy->contenido !!}
                    </div>
          </div>
                
            </div>
        </div>
    </div>
    </div>
    