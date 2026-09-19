@extends('components.layouts.admin')

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.recursos.index'), 'label' => 'Recursos', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Recurso']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div>
    <div>
      <h3 class="text-3xl font-bold">Editar Recurso</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.recursos.update', $recurso) }}" method="POST" noValidate class="space-y-3"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Nombre de recurso</label>
          <input id="name" name="nombre" value="{{ old('nombre', $recurso->nombre) }}" type="text" placeholder="Nombre del recurso" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('nombre')
          dark:border-alerts-500
          @enderror" />
          @error('nombre')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div class="relative">
          <img id="imgPreview" src="{{ $recurso->imagen ? Storage::url($recurso->imagen) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' }}" alt=""
            class="w-full aspect-video object-cover object-center" />
          <div class="absolute top-5 right-5">
            <label for="dropzone-file"
              class=" bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 p-2 rounded-lg cursor-pointer">
              Subir imagen
              <input id="dropzone-file" name="imagen" type="file" accept="image/*" class="hidden"
                onchange="preview_image(event, '#imgPreview')" />
            </label>
          </div>
        </div>

        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Categoria</label>
          <input id="name" name="categoria" value="{{ old('categoria', $recurso->categoria) }}" type="text"
            placeholder="Vector, Ilustración, Icono, Plantilla, MockUp, Fuente" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('categoria')
          dark:border-alerts-500
          @enderror">
          @error('categoria')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>        
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Categoria</label>
          <input id="name" name="formato" value="{{ old('formato', $recurso->formato) }}" type="text"
            placeholder="Vector, Ilustración, Icono, Plantilla, MockUp, Fuente" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('formato')
          dark:border-alerts-500
          @enderror">
          @error('formato')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>        

        <div>
          <p class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Descripción</p>
          <div class="" id="editor">
            {!!old('descripcion', $recurso->descripcion)!!}
          </div>
          @error('descripcion')
          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
          <textarea name="descripcion" id="contenido" class="hidden"></textarea>
        </div>

        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Precio</label>
          <input id="name" name="precio" value="{{ old('precio', $recurso->precio) }}" type="text" placeholder="$ 500.00" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('precio')
          dark:border-alerts-500
          @enderror">
          @error('precio')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

         <div>
            <label for="archivo" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Recurso</label>
            <input type="file" name="archivo" accept=".pdf,image/*,.psd,.eps,.ai
            "
                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('archivo')
          dark:border-alerts-500  @enderror">
            @error('archivo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        @if ($recurso->archivo)
        <div class="mb-2 text-sm text-gray-500">
            Archivo actual:
            <a href="{{ Storage::url($recurso->archivo) }}" target="_blank" class="text-blue-600 underline">
                {{ basename($recurso->archivo) }}
            </a>
        </div>
    @endif

        <button type="submit"
          class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full mt-5 cursor-pointer">
          Editar Recurso
        </button>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

@endpush