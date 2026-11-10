@extends('components.layouts.admin')


@section('contenido')

<div class="mx-auto max-w-7xl">

    <div class="mb-5">

        <div class="flex items-center gap-2 mb-1">

            <a
                href="{{ route('admin.producto.index') }}"
                wire:navigate
                class="text-gray-500 hover:text-link-200"
            >
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <h1 class="text-2xl font-bold">
                Nuevo producto
            </h1>
            

        </div>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Registra un nuevo producto para la tienda.
        </p>

    </div>

    <livewire:shop.product-form />

</div>

@endsection