@extends('components.layouts.principal')

@section('titulo')
Carrito |
@endsection

@section('contenido')
<section class="pt-32 pb-16">
    <div class="max-w-350 mx-auto px-6 sm:px-10 lg:px-12 text-center visible overflow-hidden">
        <span class="inline-block px-4 py-1.5 text-xs font-mono font-semibold tracking-widest uppercase text-link-200 bg-accent-500/8 border border-link-500/20 rounded-full mb-4">
            <p>Carrito de compras</p>
            </span>
            <h1 class="text-4xl sm:tex-6xl font-black mb-4 tracking-tight">
                Mi carrito
            </h1>
            <p class="max-w-xl mx-auto text-lg">
                Revisa tus productos antes de continuar.
            </p>
    </div>
</section>

    <livewire:shop.carrito />

@endsection