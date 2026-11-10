<div x-data="darkMode()" x-init="init()">
    <button
        @click="toggle"
        class="inline-flex  text-white m-3 md:m-0 hover:cursor-pointer"
        :title="isDarkMode ? 'Cambiar a claro' : 'Cambiar a oscuro'"
    >
        <template x-if="!isDarkMode" class="text-lg p-1.5">
            <i class="fa-solid fa-moon"></i>
        </template>
        <template x-if="isDarkMode" class="text-lg p-1.5">
            <i class="fa-solid fa-sun"></i>
        </template>
    </button>
</div>