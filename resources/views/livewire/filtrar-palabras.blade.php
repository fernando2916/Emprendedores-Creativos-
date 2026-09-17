<div class="pt-3">
    <form action="" class="flex" wire:submit.prevent='leerDatosFormulario'>
        <input 
        type="text" 
        wire:model="titulo" 
        placeholder="Buscar palabra..." 
           class="border-link-100 focus:shadow-link-200 w-3/4 rounded-l-md border bg-transparent p-2 outline-none placeholder:text-gray-600 focus:shadow-md dark:placeholder:text-gray-400" />
           <button type="submit" class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 w-1/4 cursor-pointer rounded-r-md p-2 text-lg font-semibold text-white transition-colors duration-150">Buscar</button>
        </form>
</div>

