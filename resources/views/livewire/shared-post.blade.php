<div class="space-y-2">

    <div class="flex gap-2">
        <!-- Facebook -->
        <a 
            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}"
            target="_blank" 
            wire:click.prevent="incrementShare"
            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
            <i class="fa-brands fa-facebook"></i>
        </a>

        <!-- Twitter -->
        <a 
            href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}"
            target="_blank" 
            wire:click.prevent="incrementShare"
            class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
        >
            <i class="fa-brands fa-x-twitter"></i>
        </a>

        <!-- WhatsApp -->
        <a 
            href="https://api.whatsapp.com/send?text={{ urlencode(route('blog.show', $blog->slug)) }}"
            target="_blank"
            wire:click.prevent="incrementShare"
            class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600"
        >
           <i class="fa-brands fa-whatsapp"></i>
        </a>
        <div 
            x-data="{ copied: false }"
            class="relative"
        >
            <button
                x-on:click="
                    navigator.clipboard.writeText('{{ route('blog.show', $blog->slug) }}');
                    copied = true;
                    $wire.incrementShare();
                    setTimeout(() => copied = false, 2000);
                "
                class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 cursor-pointer"
            >
            <i class="fa-solid fa-copy"></i>
            </button>

            <span 
                x-show="copied"
                x-transition
                class="absolute -top-6 left-0 text-xs bg-black text-white px-2 py-1 rounded"
            >
                ¡Copiado!
            </span>
        </div>
    </div>
</div>
