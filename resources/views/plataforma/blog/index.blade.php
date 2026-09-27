@extends('components.layouts.principal') 

@section('titulo') 
    Blog |
@endsection

@section('contenido')

<section class="pt-32 pb-16">
    <div class="max-w-350 mx-auto px-6 sm:px-10 lg:px-12 text-center visible overflow-hidden">
        <span class="inline-block px-4 py-1.5 text-xs font-mono font-semibold tracking-widest uppercase text-link-200 bg-accent-500/8 border border-link-500/20 rounded-full mb-4">
            <p>blog</p>
            </span>
            <h1 class="text-4xl sm:tex-6xl font-black mb-4 tracking-tight">
                Últimos artículos
            </h1>
            <p class="max-w-xl mx-auto text-lg">
                Novedades, consejos, tips, que te pueden ayudara entender como diseñador o como cliente.
            </p>
    </div>
</section>
<livewire:blog.lista-blog />
@endsection