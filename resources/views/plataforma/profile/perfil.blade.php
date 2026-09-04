@extends('components.layouts.principal')

@section('titulo')
    Mi perfil |
@endsection

@section('contenido')
    <div
        class="max-w-6xl mx-auto my-8 bg-cont-200 dark:bg-cont-300 m-5 dark:border-gray-200 rounded-lg shadow-sm flex flex-col md:flex-row">
        <x-navigation.nav-perfil/>

        <main class="flex-1 p-8">
            <header class="border-b border-gray-200 pb-4 mb-6 text-center">
                <h1 class="text-2xl font-bold dark:text-gray-200">Perfil público</h1>
                <p class="text-sm dark:text-gray-500">Añade información sobre ti</p>
            </header>

            <form action="{{ route('perfil.update', $user) }}" method="POST" class="space-y-6" novalidate>
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <h3 class="font-bold text-link-100 text-sm">Información básica:</h3>

                    <div>
                        <input type="text" name="nombre_completo" placeholder="Nombre"
                            value="{{ old('nombre_completo', $user->nombre_completo) }}"
                            class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400 mt-2">
                        @error('nombre_completo')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <input type="text" name="username" placeholder="Nombre de Usuario"
                            value="{{ old('username', $user->username) }}"
                            class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400 mt-2">
                        @error('username')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="relative">
                        <input type="text" name="headline"
                            value="{{ old('headline', $user->profile?->headline ?? '') }}" maxlength="60"
                            placeholder="Lic. Diseño Gráfico"
                            class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400 mt-2">
                        <p class="text-xs mt-1 text-gray-300 dark:text-gray-400">Añade un título o una descripción
                            profesional, como "Instructor en Emprendedores" o "Diseñador."</p>
                        @error('headline')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <h3 class="font-bold text-link-100 text-sm">Biografía</h3>
                    <textarea name="biografia" rows="4" maxlength="255" placeholder="Escribe tu biografía"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400 mt-2">{{ old('biografia', $user->profile?->biografia ?? '') }}</textarea>
                    <p class="text-xs text-gray-300 dark:text-gray-400">No se permiten los enlaces ni los códigos de cupón
                        en esta sección.</p>
                    @error('biografia')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-4">
                    <h3 class="font-bold text-sm">Enlaces:</h3>

                    <div>
                        <div class="flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-light-300 dark:border-nav-300 dark:bg-nav-400 bg-light-300 text-white text-sm">facebook.com/</span>
                            <input type="text" name="facebook_user"
                                value="{{ old('facebook_user', $user->profile?->facebook_user ?? '') }}"
                                placeholder="CreadoresCreativos.MX"
                                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400">
                        </div>
                        @error('facebook_user')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <div class="flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-light-300 dark:border-nav-300 dark:bg-nav-400 bg-light-300 text-white text-sm">instagram.com/</span>
                            <input type="text" name="instagram_user"
                                value="{{ old('instagram_user', $user->profile?->instagram_user ?? '') }}"
                                placeholder="Nombre de usuario"
                                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400">
                        </div>
                        @error('instagram_user')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <div class="flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-light-300 dark:border-nav-300 dark:bg-nav-400 bg-light-300 text-white text-sm">whatsapp.com/</span>
                            <input type="text" name="whatsapp_user"
                                value="{{ old('whatsapp_user', $user->profile?->whatsapp_user ?? '') }}"
                                placeholder="55-5555-5555"
                                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400">
                        </div>
                        @error('whatsapp_user')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <div class="flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-light-300 dark:border-nav-300 dark:bg-nav-400 bg-light-300 text-white text-sm">x.com/</span>
                            <input type="text" name="twitter_user"
                                value="{{ old('twitter_user', $user->profile?->twitter_user ?? '') }}"
                                placeholder="Nombre de usuario"
                                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400">
                        </div>
                        @error('twitter_user')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <div class="flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-light-300 dark:border-nav-300 dark:bg-nav-400 bg-light-300 text-white text-sm">tiktok.com/</span>
                            <input type="text" name="tiktok_user"
                                value="{{ old('tiktok_user', $user->profile?->tiktok_user ?? '') }}"
                                placeholder="Nombre de usuario"
                                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400">
                        </div>
                        @error('tiktok_user')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <div class="flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-light-300 dark:border-nav-300 dark:bg-nav-400 bg-light-300 text-white text-sm">youtube.com/</span>
                            <input type="text" name="youtube_user"
                                value="{{ old('youtube_user', $user->profile?->youtube_user ?? '') }}"
                                placeholder="Nombre de usuario"
                                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400">
                        </div>
                        @error('youtube_user')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-6 rounded text-sm transition cursor-pointer">
                        Guardar
                    </button>
                </div>
            </form>
        </main>
    </div>
@endsection
