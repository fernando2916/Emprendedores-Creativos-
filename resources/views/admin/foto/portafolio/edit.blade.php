@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.sesion.index'), 'label' => 'Portafolio', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Foto']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div class="">
    <div class="">
      <h3 class="text-3xl font-bold">Editar Foto</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.sesion.store', $sesione) }}" method="POST" noValidate class="space-y-3"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="relative">
          <img id="imgPreview" src="{{ $sesione->imagen_foto ? Storage::url($sesione->imagen_foto) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' }}" alt=""
            class="w-full aspect-video object-cover object-center" />
          <div class="absolute top-5 right-5">
            <label for="dropzone-file"
              class=" bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 p-2 rounded-lg cursor-pointer">
              Subir imagen
              <input id="dropzone-file" name="imagen_foto" type="file" accept="image/*" class="hidden"
                onchange="preview_image(event, '#imgPreview')" />
            </label>
          </div>
        </div>

        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Tipo</label>
          <input id="name" name="tipo" value="{{ old('tipo', $sesione->tipo) }}" type="text" placeholder="Retrato, Estudio" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('tipo')
          dark:border-alerts-500
          @enderror">
          @error('tipo')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <button type="submit"
          class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full mt-5 cursor-pointer">
          Editar Foto
        </button>
      </form>
    </div>
  </div>
</div>
@endsection