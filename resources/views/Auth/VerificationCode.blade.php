@extends('components.layouts.auth')

@section('titulo')
Verificar Cuenta |
@endsection

@section('contenido')
<div class="flex flex-col gap-6">
  <x-utils.auth-header :title="__('Verificar Cuenta')"
      :descripcion="__('Ingresa el código de verificación enviado a tu correo electrónico')" />
  <div>
    <form 
      action="{{ route('verify', ['user' => $user->verification_id]) }}"
      method="post"
      novalidate
      class="flex flex-col gap-4"
      x-data="{ cargando: false }"
      @submit="cargando = true"
    >
    @csrf
     <div class="flex justify-between w-full">
            @for ($i = 0; $i < 6; $i++)
            <input
            type="text"
            name="otp[]"
            maxlength="1"
            class="w-12 h-11 text-center text-xl font-bold border border-link-300 focus:outline-none rounded-md bg-transparent dark:text-white dark:border-link-600 dark:focus:border-link-100"
            pattern="[0-9]*"
            inputmode="numeric"
            oninput="handleInput(event, {{ $i }})"
            onkeydown="handleBackspace(event, {{ $i }})"
            id="otp-{{ $i }}"
            />
                
            @endfor
           </div>
            @error(session('message'))
               <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
           @enderror
           @if(session('message'))
               <p class="bg-red text-red-500 text-sm mt-2">{{ session('message') }}</p>
           @endif
            <input type="hidden" name="code" id="code">
             <button type="submit" :disabled="cargando"
                class="w-full dark:bg-btn-400 transition-colors duration-150 bg-btn-200 hover:bg-btn-400 dark:text-white py-2 px-4 rounded-lg dark:hover:bg-btn-600 mb-4 cursor-pointer dark:disabled:bg-btn-600 disabled:bg-btn-400">
                <span x-show="!cargando" x-cloak>
                    <i class="fa-solid fa-user-check"></i>
                    Verificar Cuenta
                </span>
                <span x-show="cargando" x-cloak>
                    <i class="fa-solid fa-circle-notch animate-spin"></i>
                </span>
            </button>
    </form>
     <div class="text-center">
            <p class="text-lg font-medium">
                Puedes solicitar un nuevo código en
                <span id="t-restante">90 seg.</span>
            </p>
            <form action="{{ route('new.code', ['user' => $user->verification_id]) }}" method="post" x-data="{cargando: false}" @submit="cargando = true">
                @csrf
                <button id="resend-button" type="submit" :disabled="cargando"
                    class="text-link-200 dark:text-link-100 hidden  disabled:text-link-500 cursor-pointer pt-3">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-hashtag"></i>
                        Reenviar código
                    </span>
                </button>

            </form>
        </div>
  </div>    
</div>

@endsection

@push('scripts')
<script>
let mostarTiempo = document.getElementById('t-restante');

let timer = 90;
let tiempo = null;

function tiempoRestante() {

    tiempo = setInterval(() =>{
        timer--;
        mostarTiempo.innerHTML = `${timer} seg.`
        if(timer == 0){
            clearInterval(tiempo);
            document.getElementById('resend-button').classList.remove('hidden');
            mostarTiempo.innerHTML = '';
        }
        
    },1000);
}

tiempoRestante();
</script>
<script>
    function handleInput(e, index) {
        const input = e.target;
        input.value = input.value.replace(/[^0-9]/g, '').slice(0, 1);
        if (input.value && index < 5) {
            document.getElementById(`otp-${index + 1}`).focus();
        }
        updateHiddenCode();
    }

    function handleBackspace(e, index) {
        if (e.key === 'Backspace' && !e.target.value && index > 0) {
            document.getElementById(`otp-${index - 1}`).focus();
        }
    }

    function updateHiddenCode() {
        const inputs = document.querySelectorAll('input[name="otp[]"]');
        const code = Array.from(inputs).map(i => i.value).join('');
        document.getElementById('code').value = code;
    }
</script>
@if (session('swal'))
<script>
    Swal.fire(@json(session('swal')));
</script>
@endif
@endpush
