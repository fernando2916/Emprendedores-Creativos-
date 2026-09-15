@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.testimonio.index'), 'label' => 'Testimonios', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Testimonio']  {{-- Último elemento desactivado --}}
]" />

<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
    <div class="">
        <div class="">
            <h3 class="text-3xl font-bold">Editar Testimonio</h3>
        </div>
        <div class="">
            <form action="{{ route('admin.testimonio.update', $testimonio) }}" method="POST" noValidate>
                @csrf
                @method('PUT')
                <div>
                    <label for="name"
                        class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Testimonio</label>
                    <input id="name" name="testimonio" value="{{ old('testimonio', $testimonio->testimonio) }}" type="text" placeholder="Testimonio" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400 mt-2 @error('testimonio')
          dark:border-alerts-500
          @enderror">
                    @error('testimonio')

                    <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
                    @enderror
                </div>
                @if(session('message'))
                <p class="text-red-500 text-sm mt-2">{{ session('message') }}</p>
                @endif

                </div>
                <div>
                    <label for="name"
                        class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Autor</label>
                    <input id="name" name="autor" value="{{ old('autor', $testimonio->autor) }}" type="text" placeholder="Autor del testimonio" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400 mt-2 @error('mensaje')
          dark:border-alerts-500
          @enderror">
                    @error('autor')

                    <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
                    @enderror
                </div>
                @if(session('message'))
                <p class="text-red-500 text-sm mt-2">{{ session('message') }}</p>
                @endif

                </div>
                <div>
                    <label for="name"
                        class="text-sm font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Red Social</label>
                    <input id="name" name="red_social" value="{{ old('red_social', $testimonio->red_social) }}" type="text" placeholder="Facebook, X-Twitter, Instagram" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-900 dark:placeholder:text-slate-400 mt-2 @error('red_social')
          dark:border-alerts-500
          @enderror">
                    @error('red_social')

                    <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
                    @enderror
                </div>
                @if(session('message'))
                <p class="text-red-500 text-sm mt-2">{{ session('message') }}</p>
                @endif

                </div>

                <button type="submit"
                    class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full cursor-pointer">Actualizar
                    testimonio</button>
            </form>
        </div>
    </div>
</div>
@endsection