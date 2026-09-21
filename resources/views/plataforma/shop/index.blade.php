@extends('components.layouts.principal')

@section('titulo')
Tienda |
@endsection

@section('contenido')
{{-- Contador promocion --}}
{{-- Banner Slider --}}
{{-- navegacion --}}
<div class="bg-nav-900 p-3 items-center justify-center mx-auto flex">
    <x-navigation.tienda/>
</div>
{{-- Licencias slider --}}
{{-- Lo mas vendido --}}
{{-- Marcas --}}
{{-- Temporada --}}
{{-- lo mas nuevo --}}
{{-- información relevante --}}
{{-- reseñas generales --}}
<div class="text-5xl">
    Tienda...
</div>
@endsection