@extends('components.layouts.principal')

@section('titulo')
Proyectos |
@endsection

@section('contenido')
<div class="">
    <section class="pt-32 pb-16">
        <div class="max-w-350 mx-auto px-6 sm:px-10 text-center visible">
            <span class="inline-block px-4 py-1.5 text-xs font-mono font-semibold tracking-widest uppercase text-link-200 bg-accent-500/8 border border-link-500/20 rounded-full mb-4">
            <p>Proyectos</p>
            </span>
            <h1 class="text-4xl sm:text-6xl font-black gradient-text mb-4 tracking-tight">
                Trabajo destacado
            </h1>
            <p class="text-darl-400 max-w-xl mx-auto text-lg">
                Una coleccion de poryectos que se han realizado en nuestra agencia.
            </p>
        </div>
    </section>
    <section class="pb-24">
        @forelse ($proyects as $proyecto )
        <div class="max-w-350 mx-auto px-6 sm:px-10 lg:px-12">
            <div class="mt-24 visible">
                <div class="overflow-hidden relative rounded-3xl hover:translate-y-1 transition-transform duration-500">
                    <a href="{{ route('diseno.show', $proyecto->slug) }}" wire:navigate class="">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                            <div class="relative aspect-video lg:aspect-auto overflow-hidden">
                                <img src={{ $proyecto->image_principal ? Storage::url($proyecto->image_principal) : '' }} alt="{{ $proyecto->titulo }}" class="relative aspect-video lg:aspect-auto overflow-hidden">
                                <div class="absolute inset-0 bg-linear-to-t from-light-200/60 via-transparent to-transparent lg:bg-none"></div>
                            </div>
                            <div class="p-8 lg:p-10 flex-flex-col justify-center bg-cont-200 dark:bg-cont-400">
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-2.5 py-0.5 text-2xs font-mono font-semibold text-link-200 bg-link-500/8 border border-link-500/20 rounded-full">
                                    Categoria
                                    </span>
                                </div>
                                <h2 class="text-2xl font-bold text-dark-100 mb-3">{{ $proyecto->titulo }}</h2>
                                <p class="leading-relaxed mb-6">
                                    {{ $proyecto->descripcion }}
                                </p>
                                <ul class="space-y-2 mb-6"></ul>
                                <div class="flex flex-wrap gap.1.5 mb-6">
                                    <span class="px-2.5 py-1 text-[11px] font-mono font-semiboldtext-link-200 bg-link-500/8 border border-link-500/20 rounded-full">
                                        {{ $proyecto->cliente }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    <a href="" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-dark-200 rounded-full bg-link-100/5 border border-link-200 hover:bg-link-100/20 hover:text-dark-100 transition-all duration-200">
                                        <i class="fa-solid fa-circle-info"></i>
                                        Detalles del proyecto
                                    </a>
                                    <a href="" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-dark-200 rounded-full bg-link-100/5 border border-link-200 hover:bg-link-100/20 hover:text-dark-100 transition-all duration-200">
                                        <i class="fa-solid fa-globe"></i>
                                        Sitio en vivo
                                    </a>
                                </div>                        
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @empty
            <div class=" max-w-7xl mx-auto">
                <h2 class="text-2xl text-center p-5 font-semibold justify-center flex mx-auto">Aún no hay proyectos que mostrar.</h2>
            </div>
        @endforelse
    </section>
    <section class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="p-8 rounded-3xl sm:p-12 lg:p-16 mb-16 relative overflow-hidden bg-cont-200 dark:bg-cont-300">
            <div class="relative grid lg:grid-cols-[1.5fr_1fr] gap-10 items-center text-center lg:text-start">
                <div>
                    <span class="inline-block px-3 py-1 text-2xs font-mono font-bold tracking-widest uppercase text-link-200 bg-cont-300/8 border border-link-500/20 rounded-full mb-5">
                        Vamos a conectarnos
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-dark-100 tracking-tight leading-[1.1] mb-4">¿Tienes un proyecto en mente?</h2>
                    <p class="text-dark-400 text-base sm:text-lg leading-relaxed max-w-xl mx-auto lg:mx-0">Estamos abiertos a trabajos pequeños y a trabajos corporativos. Construyamos algo grandioso juntos.</p>
                </div>
                <div class="flex flex-col sm:flex-row lg:flex-col gap-3">
                    <a href="{{ route('contacto.index') }}" wire:navigate class="group flex items-center justify-center gap-2 px-6 py-4 rounded-2xl bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 text-white font-bold text-sm shadow-lg transition-all">
                        <i class="fa-solid fa-envelope"></i>
                        Contáctanos 
                        <i class="fa-solid fa-square-arrow-up-right"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=524612012308" target="_blank" class="group flex items-center justify-center gap-2 px-6 py-4 rounded-2xl border border-green-500/30 bg-green-500/10 hover:bg-green-500/20 text-green-300 font-bold text-sm shadw-lg transition-all">
                        <i class="fa-brands fa-whatsapp"></i>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection