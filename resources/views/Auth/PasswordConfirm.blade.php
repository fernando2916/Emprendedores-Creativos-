@extends('components.layouts.auth')

@section('titulo')
Restablecer Contraseña |
@endsection

@section('contenido')
<div class="flex flex-col gap-6">
    <x-utils.auth-header :title="__('Restablecer Contraseña')"
        :descripcion="__('Se ha enviado a tu correo, dale click al enlace para poder actualizar tu contraseña.')" />
 
</div>
@endsection

