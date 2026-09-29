@extends('components.layouts.admin')

@section('contenido')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
    <livewire:estadisticas-usuarios />
    <livewire:estadisticas-post />
</div>
@endsection