@extends('components.layouts.principal')

@section('titulo')
   Perfil Público |
@endsection

@section('contenido')
<div class="p-5 w-full">
    <div class="p-5 bg-cont-200 dark:bg-cont-300 rounded-md">
        <div class="flex items-center justify-center mx-auto">
            <img src="{{ $user->profile?->avatar
            ? Storage::url($user->profile->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->nombre_completo) }}"
            alt="Foto de {{ $user->nombre_completo }}"
            class="w-42 h-42 rounded-full object-cover">
        </div>
        <div class="flex flex-col items-center justify-center mt-5">
            <p class="text-4xl font-bold">

                {{ $user->nombre_completo }}
            </p>
            <p class="text-2xl font-semibold">
                
                {{ $user->username }}
            </p>
            <p class="text-xl text-link-100">
                {{ $user->profile->headline }}

            </p>
        </div>
        <div class="flex flex-col items-center justify-center mx-auto mt-5">
            <p class="text-2xl font-bold">
                Biografia
            </p>
            <div class="">
                {{ $user->profile->biografia }}
            </div>
        </div>
        <div class="flex items-center justify-center mx-auto mt-5 space-x-2 md:space-x-5">
            {{-- Facebook --}}
    @if ($user->profile?->facebook_user)
        <a
            href="https://www.facebook.com/{{ $user->profile->facebook_user }}"
            target="_blank"
            rel="noopener noreferrer"
            class="w-14 h-14 flex items-center justify-center border-2 border-link-100 rounded-md text-link-100 hover:bg-link-100 hover:text-white transition"
        >
            <i class="fa-brands fa-facebook-f text-xl"></i>
        </a>
    @endif

    {{-- Instagram --}}
    @if ($user->profile?->instagram_user)
        <a
            href="https://www.instagram.com/{{ $user->profile->instagram_user }}"
            target="_blank"
            rel="noopener noreferrer"
            class="w-14 h-14 flex items-center justify-center border-2 border-link-100 rounded-md text-link-100 hover:bg-link-100 hover:text-white transition"
        >
            <i class="fa-brands fa-instagram text-xl"></i>
        </a>
    @endif


    {{-- WhatsApp --}}
    @if ($user->profile?->whatsapp_user)
        <a
            href="https://wa.me/52{{ $user->profile->whatsapp_user }}/"
            target="_blank"
            rel="noopener noreferrer"
            class="w-14 h-14 flex items-center justify-center border-2 border-link-100 rounded-md text-link-100 hover:bg-link-100 hover:text-white transition"
        >
            <i class="fa-brands fa-whatsapp text-xl"></i>
        </a>
    @endif


    {{-- X / Twitter --}}
    @if ($user->profile?->twitter_user)
        <a
            href="https://x.com/{{ $user->profile->twitter_user }}"
            target="_blank"
            rel="noopener noreferrer"
            class="w-14 h-14 flex items-center justify-center border-2 border-link-100 rounded-md text-link-100 hover:bg-link-100 hover:text-white transition"
        >
            <i class="fa-brands fa-x-twitter text-xl"></i>
        </a>
    @endif


    {{-- TikTok --}}
    @if ($user->profile?->tiktok_user)
        <a
            href="https://www.tiktok.com/{{ $user->profile->tiktok_user }}"
            target="_blank"
            rel="noopener noreferrer"
            class="w-14 h-14 flex items-center justify-center border-2 border-link-100 rounded-md text-link-100 hover:bg-link-100 hover:text-white transition"
        >
            <i class="fa-brands fa-tiktok text-xl"></i>
        </a>
    @endif


    {{-- YouTube --}}
    @if ($user->profile?->youtube_user)
        <a
            href="https://www.youtube.com/{{ $user->profile->youtube_user }}"
            target="_blank"
            rel="noopener noreferrer"
            class="w-14 h-14 flex items-center justify-center border-2 border-link-100 rounded-md text-link-100 hover:bg-link-100 hover:text-white transition"
        >
            <i class="fa-brands fa-youtube text-xl"></i>
        </a>
    @endif
        </div>
    </div>

</div>
@endsection