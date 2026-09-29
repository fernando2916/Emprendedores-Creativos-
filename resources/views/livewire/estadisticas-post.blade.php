<div class="bg-gray-800 text-white p-6 rounded-2xl shadow-lg flex justify-between items-center w-full">
    <div>
        <h3 class="text-xl font-bold">Total Publicaciones</h3>
        <p class="text-2xl font-bold mt-1">{{ $total }}</p>

        <div class="mt-5 flex gap-2">
            <span class="px-3 py-1 text-2xs lg:text-xs rounded-full bg-green-700 text-green-100 font-semibold">
                Publicados {{ $publicado }}
            </span>
            <span class="px-3 py-1 text-2xs lg:text-xs rounded-full border border-blue-400 text-blue-400 font-semibold">
                Borradores {{ $borrador }}
            </span>
        </div>
    </div>

    <div class="relative w-20 h-20">
        <svg class="w-full h-full transform -rotate-90">
            <circle cx="40" cy="40" r="36" stroke="currentColor" stroke-width="6" class="text-gray-700 fill-none"/>
            <circle 
                cx="40" 
                cy="40" 
                r="36" 
                stroke="currentColor" 
                stroke-width="6"
                stroke-linecap="round"
                class="text-blue-500 fill-none transition-all duration-500"
                stroke-dasharray="{{ 2 * 3.1416 * 36 }}"
                stroke-dashoffset="{{ 2 * 3.1416 * 36 * (1 - $procentajePublicados / 100) }}"
            />
        </svg>

        <span class="absolute inset-0 flex items-center justify-center text-xs font-bold text-blue-500">
            {{ $procentajePublicados }}%
        </span>
    </div>
</div>