@extends('components.layouts.auth')

@section('titulo')
Restablecer Contraseña |
@endsection

@section('contenido')
<div class="flex flex-col gap-6">
    <x-utils.auth-header :title="__('Restablecer Contraseña')"
        :descripcion="__('Ingresa tu contraseña actual y la nueva para restablecerla')" />
    <form action="{{ route('password.confirm' , ['user' => $user->verification_id]) }}" method="POST" class="flex flex-col gap-6"
        noValidate x-data="{ cargando: false }" @submit="cargando = true">
        @csrf
        <div>
            <label for="password"
                class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Contraseña</label>
            <x-password-input id="password" name="password" model="password" placehlder="********" />

        </div>
        <div>
            <label for="password_confirmation"
                class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Confirma tu
                contraseña</label>
            <x-password-input id="password_confirmation" name="password_confirmation" model="password_confirmation"
                placehlder="********" />
        </div>
        <button type="submit" :disabled="cargando"
            class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full cursor-pointer flex items-center justify-center gap-2 dark:disabled:bg-btn-600 disabled:bg-btn-400">
            <span x-show="!cargando">
                <i class="fa-solid fa-key"></i>
                Restablecer contraseña
            </span>
            <span x-show="cargando">
                <i class="fa-solid fa-circle-notch animate-spin"></i>
            </span>
        </button>
    </form>
</div>
@endsection

@push('scripts')
@if (session('swal'))
<script>
    Swal.fire(@json(session('swal')));
</script>
@endif
@endpush