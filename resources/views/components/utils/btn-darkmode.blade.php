<div x-data="darkMode()" x-init="init()">
    <button
        @click="toggle"
        class="rounded-full px-2 py-1 text-white hover:bg-light-200 dark:hover:bg-btn-400 transition"
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