<div>
    <!-- Botón para abrir modal -->
    <button wire:click="$set('modalAbierto', true)"
        class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full cursor-pointer flex items-center justify-center gap-2">
        Agendar sesión
    </button>

    <!-- Modal -->
    @if ($modalAbierto)
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-nav-950/90">
        <div class="bg-light-300 dark:bg-cont-300 rounded p-6 w-full max-w-lg relative mx-5">
            <button wire:click="$set('modalAbierto', false)"
                class="absolute top-2 right-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md cursor-pointer">
                <i class="fa-solid fa-xmark text-lg px-1.5"></i>
            </button>

            <h2 class="text-xl font-semibold mb-4">Agendar cita</h2>

            <form wire:submit.prevent="guardar" class="space-y-4">
                <div>
                    <label
                        class="mb-2 text-sm font-medium text-white after:ml-0.5 after:text-red-500 after:content-['*']">Nombre
                        completo</label>
                    <input type="text" wire:model.defer="nombre"
                    placeholder="Nombre completo"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2" />
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label
                        class="mb-2 text-sm font-medium text-white after:ml-0.5 after:text-red-500 after:content-['*']">Correo
                        electrónico</label>
                    <input type="email" wire:model.defer="email"
                    placeholder="Correo electrónico"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2" />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label
                        class="mb-2 text-sm font-medium text-white after:ml-0.5 after:text-red-500 after:content-['*']">Número
                        Telefónico - Seras contactado via WhatsApp</label>
                    <input type="tel" wire:model.defer="numero_telefonico" placeholder="Némero telefónico"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2" />
                    @error('numero_telefonico') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label
                        class="mb-2 text-sm font-medium text-white after:ml-0.5 after:text-red-500 after:content-['*']">Comentarios</label>
                    <textarea wire:model.defer="detalles" placeholder="Escribe los comentarios que tengas."
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"></textarea>
                    @error('detalles') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label
                        class="mb-2 text-sm font-medium text-white after:ml-0.5 after:text-red-500 after:content-['*']">Selecciona
                        un paquete</label>
                    <select wire:model.defer="paquete_foto_id"
                        class="border border-link-300 text-gray-900 text-sm rounded-lg focus:ring-link-500 focus:border-link-500 block w-full p-2.5 dark:bg-gray-800 dark:border-link-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-link-500 dark:focus:border-link-500 ">
                        <option value="" class="text-center">-- Selecciona --</option>
                        @foreach($paquetes as $paquete)
                        <option value="{{ $paquete->id }}">{{ $paquete->titulo }}</option>
                        @endforeach
                    </select>
                    @error('paquete_foto_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button  type="submit" class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full cursor-pointer flex items-center justify-center gap-2">
                        Agendar cita
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
    
    
</div>
@push('scripts')
<script>
   Livewire.on('alertCotizacion', function() {
            Swal.fire({
                title: 'Cita agendada correctamente.',
                text: 'En las proximas horas seras contactado.',
                icon: 'success',
                confirmButtonText: 'OK',
                background:  "#120024",
                color:  "#ffffff",
            });
        });
</script>
@endpush