<div class="w-full md:w-1/2 flex flex-col md:px-5 mt-5">
    <div class="mx-auto max-w-2xl text-center">
       <h3 class="text-3xl font-bold tracking-tight sm:text-4xl">
           Formulario de contacto
       </h3>
       <p class="mt-2 md:text-base text-slate-300 text-xs lg:flex">
             ¿Tienes un proyecto en mente? Cuéntanos tu idea y estaremos
             encantados de ayudarte.
           </p>
    </div>
    <div class="mt-5">
       <form class="space-y-4" wire:submit.prevent="save">
           <div class="flex flex-col space-y-2">
               <label for="name" class="text-sm after:content-['*'] after:ml-0.5 after:text-red-500">Nombre Completo</label>
               <input 
                   type="text"
                   wire:model.defer="name"
                   id="name"
                   placeholder="Nombre Completo" 
                   class="bg-transparent p-2 disabled:bg-nav-900 disabled:border-nav-900 rounded-md border-link-100 border-2 outline-none focus:shadow-md focus:shadow-link-200 w-full placeholder:text-slate-300 dark:placeholder:text-gray-400 @error('name')
             dark:border-alerts-500
             @enderror">
                   @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
           </div>
           <div class="flex flex-col space-y-2">
               <label for="email" class="text-sm after:content-['*'] after:ml-0.5 after:text-red-500">Correo Electrónico</label>
               <input 
                   type="email"
                   wire:model.defer="email"
                   id="email"
                   placeholder="Ingresa tu Correo Electrónico" 
                   class="bg-transparent p-2 disabled:bg-nav-900 disabled:border-nav-900 rounded-md border-link-100 border-2 outline-none focus:shadow-md focus:shadow-link-200 w-full placeholder:text-slate-300 dark:placeholder:text-gray-400 @error('email')
             dark:border-alerts-500
             @enderror">
                   @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
           </div>
           <div class="flex flex-col space-y-2">
               <label for="company" class="text-sm after:content-['*'] after:ml-0.5 after:text-red-500">Empresa</label>
               <input 
                   id="company"
                   wire:model.defer="company"
                   type="text"
                   placeholder="Negocio o independiente" 
                   class="bg-transparent p-2 disabled:bg-nav-900 disabled:border-nav-900 rounded-md border-link-100 border-2 outline-none focus:shadow-md focus:shadow-link-200 w-full placeholder:text-slate-300 dark:placeholder:text-gray-400 @error('company')
             dark:border-alerts-500
             @enderror">
                   @error('company') <span class="text-red-500">{{ $message }}</span> @enderror
           </div>
           <div class="flex flex-col space-y-2">
               <label for="phone" class="text-sm after:content-['*'] after:ml-0.5 after:text-red-500">Teléfono de contacto</label>
               <input 
                   type="text"
                   wire:model.defer="phone"
                   id="phone"
                   placeholder="Numero de Contacto"
                   class="bg-transparent p-2 disabled:bg-nav-900 disabled:border-nav-900 rounded-md border-link-100 border-2 outline-none focus:shadow-md focus:shadow-link-200 w-full placeholder:text-slate-300 dark:placeholder:text-gray-400 @error('phone')
             dark:border-alerts-500
             @enderror">
                   @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
           </div>
           <div class="flex flex-col space-y-2">
               <label for="messaje" class="text-sm after:content-['*'] after:ml-0.5 after:text-red-500">Mensaje</label>
              <textarea
              wire:model.defer="messaje"
               class="bg-transparent p-2 disabled:bg-nav-900    disabled:border-nav-900 rounded-md border-link-100 border-2    outline-none focus:shadow-md focus:shadow-link-200 w-full  placeholder:text-slate-300 dark:placeholder:text-gray-400 @error('messaje')
             dark:border-alerts-500
             @enderror" 
               name="" 
               id="messaje"
               placeholder="Escribenos todas tus dudas..." 
               cols="38" 
               rows="6"></textarea>
               @error('messaje') <span class="text-red-500">{{ $message }}</span> @enderror
           </div>
           <div class="w-full py-2 flex flex-wrap items-center justify-center gap-x-1 text-[13px] wrap-break-word">
               <p class="leading-snug">Puedes revisar el <x-ui.modales.aviso /> si tienes dudas con el manejo de tus datos personales.</p>
           </div>
           <button type="submit"" class="flex items-center justify-center gap-2 w-full rounded-md bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 px-3.5 py-2.5 mt-5 text-center text-sm font-semibold duration-150 shadow-sm uppercase cursor-pointer transition-colors">
               <i class="fa-solid fa-envelope"></i>
               Solicitar información
           </button>
       </form>
    </div>
   </div>
   
   @push('scripts')
   <script>
      Livewire.on('alertContacto', function() {
               Swal.fire({
                   title: 'Gracias',
                   text: 'Tu información ha sido enviada correctamente, en las proximas 24hr seras contactado.',
                   icon: 'success',
                   confirmButtonText: 'OK',
                   background:  "#120024",
                   color:  "#ffffff",
               });
           });
   </script>
   @endpush
   