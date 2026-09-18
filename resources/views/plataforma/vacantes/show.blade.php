@extends('components.layouts.principal')

@section('titulo')
Vacantes |
@endsection

@section('contenido')
<div class="p-5 space-y-5 max-w-7xl mx-auto">
  <div class="p-5">
    <h3 class="text-3xl md:text-5xl font-extrabold">
      {{ $vacante->puesto }}
    </h3>
    <div class="gap-5 mt-5 space-y-3">
        <div class="flex items-center gap-2">
            <p class="text-base">
              <i class="fa-solid fa-location-dot w-4 h-4"></i>
              {{ $vacante->modalidad }}
            </p>
        </div>
      <div class="flex items-center gap-2">
        <p class="text-base">
            <i class="fa-solid fa-building w-4 h-4"></i>
            {{ $vacante->empresa }}
        </p>
        </div>
        <div class="flex items-center gap-2">
            <p class="text-base">
              <i class="fa-solid fa-clock w-4 h-4"></i>
              {{ $vacante->horario }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <p class="text-base">
              <i class="fa-solid fa-dollar w-4 h-4"></i>
              {{ $vacante->salario }} MXN.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <p class="font-bold">
                Último día para postularse:
                <span class="font-normal">{{ $vacante->postulacion->format('d/m/Y') }}</span>
            </p>
        </div>
    </div>
  </div>

  <div class="space-y-5">
    <div class="post-content dark:bg-cont-300 bg-cont-200 rounded-md p-3 text-lg ql-editor">
      {!! $vacante->descripcion !!}
    </div>
  </div>
  <div class="w-full">
    <h3 class="text-center font-bold text-3xl mb-4">Postúlate</h3>

    <form class="space-y-3"  x-data="{ cargando: false }" action="{{ route('vacante.store', $vacante->id) }}"  method="POST" noValidate  enctype="multipart/form-data"  @submit="cargando = true">
      @csrf
        <!-- Campo nombre -->
        <div>
            <label for="nombre" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre Completo"
                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('nombre')
          dark:border-alerts-500  @enderror">
            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Campo correo -->
        <div>
            <label for="correo" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Correo</label>
            <input type="email" name="correo" placeholder="Correo Electrónico"
                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('correo')
          dark:border-alerts-500  @enderror">
            @error('correo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Campo telefono -->
        <div>
            <label for="telefono" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Teléfono (Preferente para contacto mediante WhatsApp)</label>
            <input type="tel" name="telefono" placeholder="Número de contacto"
                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('telefono')
          dark:border-alerts-500  @enderror">
            @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Campo CV -->
        <div>
            <label for="curriculum" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">CV / Hoja de vida</label>
            <input type="file" name="curriculum" accept=".pdf"
                class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('curriculum')
          dark:border-alerts-500  @enderror">
            @error('curriculum') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Botón -->
        <button type="submit" :disabled="cargando"
            class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 text-white transition-colors duration-150 rounded-md p-3 mt-5 cursor-pointer w-full">
            <span x-show="!cargando" x-cloak>
                Postularme
            </span>
            <span x-show="cargando" x-cloak>
                <i class="fa-solid fa-circle-notch animate-spin"></i>
            </span>
        </button>
    </form>
</div>
</div>
@endsection

@push('scripts')
@if (session('swal'))
<script>
    Swal.fire(@json(session('swal')));
</script>
@endif
@endpush