@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.blogs.index'), 'label' => 'Blog', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Post']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div class="">
    <div class="">
      <h3 class="text-3xl font-bold">Editar Post</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" noValidate class="space-y-3"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Titulo del
            Post</label>
          <input id="name" name="titulo" value="{{ old('titulo', $blog->titulo) }}" type="text" placeholder="Titulo" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('titulo')
          dark:border-alerts-500
          @enderror" oninput="string_to_slug(this.value, '#slug')" />
          @error('titulo')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div class="relative">
          <img id="imgPreview" src="{{ $blog->imagen ? Storage::url($blog->imagen) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' }}" alt=""
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
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Descripción
            Corta</label>
          <input id="name" name="descripcion_corta" value="{{ old('descripcion_corta', $blog->descripcion_corta) }}" type="text"
            placeholder="descripcion_corta" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('descripcion_corta')
          dark:border-alerts-500
          @enderror">
          @error('descripcion_corta')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="slug" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Slug</label>
          <input id="slug" readonly name="slug" value="{{ old('slug', $blog->slug) }}" type="text" placeholder="Slug" class="dark:disabled:bg-nav-900 dark:disabled:border-nav-900 disabled:bg-light-300 disabled:border-light-300 border-link-100 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('slug')
          dark:border-alerts-500
          @enderror">
          @error('slug')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <p class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Contenido</p>
          <div class="" id="editor">
            {!!old('contenido', $blog->contenido)!!}
          </div>
          @error('contenido')
          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
          <textarea name="contenido" id="contenido" class="hidden"></textarea>
        </div>

        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Tiempo de
            lectura</label>
          <input id="name" name="tiempo_de_lectura" value="{{ old('tiempo_de_lectura', $blog->tiempo_de_lectura) }}" type="text"
            placeholder="tiempo_de_lectura" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('tiempo_de_lectura')
          dark:border-alerts-500
          @enderror">
          @error('tiempo_de_lectura')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Estado</label>
          <input id="name" name="estado" value="{{ old('estado', $blog->estado) }}" type="text" placeholder="Publicado" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('estado')
          dark:border-alerts-500
          @enderror">
          @error('estado')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="category_id" class="block mb-2 text-sm font-medium text-white">Seleciona una categoria</label>
          <select name="categoria_posts_id" id="category_id"
            class="border border-link-300 text-gray-900 text-sm rounded-lg focus:ring-link-500 focus:border-link-500 block w-full p-2.5 dark:bg-gray-800 dark:border-link-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-link-500 dark:focus:border-link-500">
            <option selected disabled>Selecciona una categoria</option>
            @foreach ($categories as $category)
           <option value="{{ $category->id }}"
            @if ($blog->categoria_posts_id == $category->id) selected @endif>
            {{ $category->nombre }}
        </option>
            @endforeach
          </select>
          @error('categoria_posts_id')
          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        @if(session('message'))
        <p class="text-red-500 text-sm mt-2">{{ session('message') }}</p>
        @endif

        <button type="submit"
          class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full mt-5 cursor-pointer">
          Actualizar Post
        </button>
      </form>
    </div>
  </div>
</div>
@endsection

