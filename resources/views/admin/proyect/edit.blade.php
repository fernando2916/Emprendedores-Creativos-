@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.proyecto.index'), 'label' => 'Proyectos', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Proyecto']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div class="">
    <div class="">
      <h3 class="text-3xl font-bold">Editar Proyecto</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.proyecto.update', $proyecto) }}" method="POST" noValidate class="space-y-3"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Titulo del
            proyecto</label>
          <input id="name" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}" type="text" placeholder="Titulo" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('titulo')
          dark:border-alerts-500
          @enderror" oninput="string_to_slug(this.value, '#slug')" />
          @error('titulo')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="slug" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Slug del
            proyecto</label>
          <input id="slug" readonly name="slug" value="{{ old('slug', $proyecto->slug) }}" type="text" placeholder="Slug" class="dark:disabled:bg-nav-900 dark:disabled:border-nav-900 disabled:bg-light-300 disabled:border-light-300 border-link-100 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('slug')
          dark:border-alerts-500
          @enderror">
          @error('slug')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <div>
         <label for="name"
            class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Imagenes</label>  
        
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Imagen principal --}}
    <div class="relative">
        <img id="imgPreviewPrincipal" src="{{ $proyecto->image_principal ? Storage::url($proyecto->image_principal) : '' }}" alt=""
            class="w-full aspect-video object-cover object-center" />
        <div class="absolute top-5 right-5">
            <label for="dropzone-principal"
                class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 p-2 rounded-lg cursor-pointer">
                Subir imagen
                <input id="dropzone-principal" name="image_principal" type="file" accept="image/*" class="hidden"
                    onchange="preview_images(event, 'imgPreviewPrincipal')" />
            </label>
        </div>
        @error('image_principal')
        <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Imagen segunda --}}
    <div class="relative">
        <img id="imgPreviewSecond" src="{{ $proyecto->image_second ? Storage::url($proyecto->image_second) : '' }}" alt=""
            class="w-full aspect-video object-cover object-center" />
        <div class="absolute top-5 right-5">
            <label for="dropzone-second"
                class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 p-2 rounded-lg cursor-pointer">
                Subir imagen
                <input id="dropzone-second" name="image_second" type="file" accept="image/*" class="hidden"
                    onchange="preview_images(event, 'imgPreviewSecond')" />
            </label>
        </div>
        @error('image_second')
        <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Imagen tercera --}}
    <div class="relative">
        <img id="imgPreviewThird" src="{{ $proyecto->image_third ? Storage::url($proyecto->image_third) : '' }}" alt=""
            class="w-full aspect-video object-cover object-center" />
        <div class="absolute top-5 right-5">
            <label for="dropzone-third"
                class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 p-2 rounded-lg cursor-pointer">
                Subir imagen
                <input id="dropzone-third" name="image_third" type="file" accept="image/*" class="hidden"
                    onchange="preview_images(event, 'imgPreviewThird')" />
            </label>
        </div>
        @error('image_third')
        <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Imagen cuarta --}}
    <div class="relative">
        <img id="imgPreviewFourth" src="{{ $proyecto->image_fourth ? Storage::url($proyecto->image_fourth) : '' }}" alt=""
            class="w-full aspect-video object-cover object-center" />
        <div class="absolute top-5 right-5">
            <label for="dropzone-fourth"
                class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 p-2 rounded-lg cursor-pointer">
                Subir imagen
                <input id="dropzone-fourth" name="image_fourth" type="file" accept="image/*" class="hidden"
                    onchange="preview_images(event, 'imgPreviewFourth')" />
            </label>
        </div>
        @error('image_fourth')
        <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
        @enderror
    </div>
          
          </div>
        </div>

        <div>
          <label for="name"
            class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Descripción</label>
          <input id="name" name="descripcion" value="{{ old('descripcion', $proyecto->descripcion) }}" type="text" placeholder="Descripcion"
            class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('descripcion')
          dark:border-alerts-500
          @enderror">
          @error('descripcion')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="name"
            class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Objetivo</label>
          <input id="name" name="objetivo" value="{{ old('objetivo', $proyecto->objetivo) }}" type="text" placeholder="Objetivo del proyecto"
            class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('objetivo')
          dark:border-alerts-500
          @enderror">
          @error('objetivo')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Cliente</label>
          <input id="name" name="cliente" value="{{ old('cliente', $proyecto->cliente) }}" type="text" placeholder="CLiente" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('cliente')
          dark:border-alerts-500
          @enderror">
          @error('marca')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        @if(session('message'))
        <p class="text-red-500 text-sm mt-2">{{ session('message') }}</p>
        @endif

        <button type="submit"
          class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full mt-5 cursor-pointer">
          Actualizar Proyecto
        </button>
      </form>
    </div>
  </div>
</div>
@endsection