<div>
    <section class="pb-24">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="space-y-8 mb-12">
                <div class="max-w-md mx-auto animate-on-scroll visible flex gap-2">
                    <div class="relative group">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5"></i>
                        <lable for="BuscarBlog" class="hidden"></lable>
                        <input
                        wire:model.live.debounce.400ms="busqueda" 
                        id="BuscarBlog" 
                        placeholder="Buscar artículos..." 
                        type="text" 
                        class="w-full pl-12 pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all">                       
                    </div>
                    {{-- Categorías --}}
                    <div class="">
                
                        <select
                            wire:model.live="categoria"
                            class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
                        >
                
                            <option value="">
                                Todo
                            </option>
                
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                
                        </select>
                
                    </div>
                </div>
            </div>
        </div>
        {{-- Indicador de carga --}}
    <div wire:loading class="text-center mx-auto flex justify-center w-full mb-6">
        <i class="fa-solid fa-circle-notch animate-spin"></i>
        <span>Buscando...</span>
    </div>
    {{-- Resultados --}}
    <div wire:loading.remove>

        @if ($busqueda)
            <div class="mb-6 text-center mx-auto">
                <h2 class="text-xl font-bold">
                    Resultados para:
                    <span class="text-purple-600">
                        "{{ $busqueda }}"
                    </span>
                </h2>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-6 sm:px-8">
        
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse ($blogs as $blog)

                <a wire:navigate href={{ route('blog.show', $blog->slug) }}
                    class="mb-4 block overflow-hidden rounded-lg">
                    <article class="dark:bg-cont-100 bg-light-200 text-white">
                        <div>
                            <img src={{ $blog->imagen ? Storage::url($blog->imagen) : '' }} alt="{{ $blog->titulo }}"
                                class=" aspect-video w-full object-cover " />
                        </div>
                        <div class="space-y-3 p-4 mt-2">
                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                <span
                                    class="bg-categoria-400 dark:bg-categoria-200 rounded-md px-2 py-1 text-2xs font-semibold">
                                    {{ $blog->categoriaPost->nombre }}
                                </span>
                                <div class="flex items-center gap-1 text-sm">
                                    <i class="fa-solid fa-calendar"></i>
                                    {{ $blog->created_at->diffForHumans() }}
                                </div>
                                <div class="flex items-center justify-center gap-3 text-sm">
                                    <div class="flex items-center gap-1">
                                        <i class="fa-solid fa-eye"></i>
                                        <p>Lectura de {{ $blog->tiempo_de_lectura }} min.</p>
                                    </div>
                                </div>
                            </div>

                            <h3 class="hover:text-link-400 dark:hover:text-link-200 mb-2 text-2xl font-semibold">
                                {{ $blog->titulo }}
                            </h3>
                            <div class="">
                                <p class="line-clamp-2 leading-relaxed mb-5 text-justify text-sm text-slate-200 dark:text-slate-300">
                                    {{ $blog->descripcion_corta }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center justify-center gap-3">
                                    <div class="flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-thumbs-up"></i>
                                        <p>{{ $blog->likes->count() }}</p>
                                    </div>
                                    <div class="flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-comment"></i>
                                        <livewire:contador-comentarios :post="$blog" />
                                    </div>
                                </div>
                                <div class="flex items-center justify-center gap-3 text-sm">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $blog->autor->profile?->avatar
                                            ? Storage::url($blog->autor->profile->avatar)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($blog->autor->nombre_completo) }}"
                                            alt="Foto de {{ $blog->autor->nombre_completo }}"
                                            class="w-6 h-6 rounded-full object-cover">
                                        <p class="text-[10.5px]">

                                            {{ $blog->autor->nombre_completo }}
                                        </p>
                                        </p>
                                    </div>                                            
                                </div>
                            </div>
                        </div>
                    </article>
                </a>

                @empty

                    <div class="col-span-full text-center py-12">

                        <i class="fa-solid fa-magnifying-glass
                                text-4xl text-gray-400 mb-4"></i>

                        <h3 class="text-xl font-bold">
                            No encontramos artículos
                        </h3>

                        <p class="text-gray-500 mt-2">
                            Intenta con otro término de búsqueda.
                        </p>

                    </div>

                @endforelse

            </div>
        </div>

        {{-- Paginación --}}
        <div class="mt-8">
            {{ $blogs->links() }}
        </div>

    </div>
    </section>
</div>
