@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.banner.index'), 'label' => 'Diapositivas', 'navigate' => true],
    ['url' => '', 'label' => 'Crear Diapositiva']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div class="">
    <div class="">
      <h3 class="text-3xl font-bold">Crear Diapositiva</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.banner.store') }}" method="POST" noValidate class="space-y-3" enctype="multipart/form-data"
        >
        @csrf

         <div class="relative">
          <img id="imgPreview" src="https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg" alt=""
            class="w-full aspect-video object-cover object-center" />
          <div class="absolute top-5 right-5">
            <label for="dropzone-file"
              class=" bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 p-2 rounded-lg cursor-pointer">
              Subir imagen
              <input id="dropzone-file" name="banner" type="file" accept="image/*" class="hidden"
                onchange="preview_image(event, '#imgPreview')" />
            </label>
          </div>
        </div>
    
        <button type="submit"
          class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full mt-5 cursor-pointer">
          Crear Diapositiva
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
