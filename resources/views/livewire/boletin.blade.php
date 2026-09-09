<div>
    <form wire:submit.prevent="save" class="mt-4">
          <label for="correo" class="text-link-100 font-semibold text-md">
            Correo Electrónico
          </label>
          <div class="md:flex gap-2">
                <input 
                id="correo" 
                wire:model.defer="email"
                type="email" 
                placeholder="Ingresa tu Correo Electrónico"
                class="bg-transparent border-2 placeholder:text-slate-300 placeholder:font-semibold dark:placeholder:font-semibold dark:placeholder:text-gray-400 border-link-100 p-2 focus:shadow-md focus:shadow-link-200 rounded-md mt-3 md:mt-2 outline-none w-full md:w-[70%] @error('email')
                dark:border-alerts-500
                @enderror" />
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            <button
            type="submit"
              class="bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-all flex gap-1 items-center p-2 rounded-md mt-3 md:mt-2 text-md font-medium justify-center w-full md:w-[30%] cursor-pointer">
              <i class="fa-solid fa-envelope"></i>
              Suscríbete
            </button>
          </div>
        </form>
</div>
@push('scripts')
<script>
   Livewire.on('alertSuscripcion', function() {
            Swal.fire({
                title: 'Felicidades',
                text: 'Te has unido al boletin gráfico correctamente.',
                icon: 'success',
                confirmButtonText: 'OK',
                background:  "#120024",
                color:  "#ffffff",
            });
        });
</script>
@endpush
