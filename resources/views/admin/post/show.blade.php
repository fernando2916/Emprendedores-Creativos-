@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.blogs.index'), 'label' => 'Blog', 'navigate' => true],
    ['url' => '', 'label' => 'Ver Post']  {{-- Último elemento desactivado --}}
]" />

@push('css')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@endpush

<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div class="relative">
    <img id="imgPreview"
      src="{{ $blog->imagen ? Storage::url($blog->imagen) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' }}"
      alt="" class="w-full aspect-video object-cover object-center" />
      <p class="absolute left-2 -bottom-5 rounded-lg p-2 mx-auto bg-categoria-200">{{ $blog->categoriaPost->nombre }}</p>
  </div>
  <div class="mt-5 grid grid-cols-2 w-full mx-auto">
    <p class="">{{$blog->titulo}}</p>
    <p class="place-content-end">{{$blog->tiempo_de_lectura}} min</p>
  </div>
  <div class="">
    <p class="">{{$blog->autor->nombre_completo}}</p>
  </div>

  <div class="">{{ $blog->descripcion_corta }}</div>

  <div class="p-3 bg-light-200 rounded-lg ql-editor">
    {!! $blog->contenido !!}
  </div>
</div>

<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg mt-5">
  <p class="">Comentarios</p>
</div>
@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
  const quill = new Quill('#editor', {
  modules: {
    toolbar: [
      [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
      ['bold', 'italic', 'underline'],
      [{ 'color': [] }, { 'background': [] }],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
      ['blockquote', 'code-block'],
      ['image'],
    ],
  },
  theme: 'snow', // or 'bubble'
});

  quill.on('text-change', function() {
    document.querySelector('#contenido').value = quill.root.innerHTML;
  })
</script>

@endpush