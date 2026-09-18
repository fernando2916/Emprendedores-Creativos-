@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.vacante.index'), 'label' => 'Vacantes', 'navigate' => true],
    ['url' => '', 'label' => 'Editar Vacante']  {{-- Último elemento desactivado --}}
]" />


<div class="bg-light-200 dark:bg-cont-100 p-5 rounded-lg">
  <div>
    <div>
      <h3 class="text-3xl font-bold">Editar Vacante</h3>
    </div>
    <div class="mt-5">
      <form action="{{ route('admin.vacante.update', $vacante) }}" method="POST" noValidate class="space-y-3">
        @method('PUT')        
        @csrf
        <div>
          <label for="name" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Titulo del
            Puesto</label>
          <input id="name" name="puesto" value="{{ old('puesto', $vacante->puesto) }}" type="text" placeholder="Puesto " class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('puesto')
          dark:border-alerts-500
          @enderror" />
          @error('puesto')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="modalidad" class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Modalidad
          </label>
          <input id="modalidad" name="modalidad" value="{{ old('modalidad' , $vacante->modalidad) }}" type="text"
            placeholder="Presencial, HomeOffice, Hibrido" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('modalidad')
          dark:border-alerts-500
          @enderror">
          @error('modalidad')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="horario"
            class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Horario</label>
          <input id="horario" name="horario" value="{{ old('horario', $vacante->horario) }}" type="text" placeholder="Horario laboral"
            class="dark:disabled:bg-nav-900 dark:disabled:border-nav-900 disabled:bg-light-300 disabled:border-light-300 border-link-100 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('horario')
          dark:border-alerts-500
          @enderror">
          @error('horario')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="empresa"
            class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Empresa</label>
          <input id="empresa" name="empresa" value="{{ old('empresa', $vacante->empresa) }}" type="text" placeholder="Empresa"
            class="dark:disabled:bg-nav-900 dark:disabled:border-nav-900 disabled:bg-light-300 disabled:border-light-300 border-link-100 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('empresa')
          dark:border-alerts-500
          @enderror">
          @error('empresa')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <p class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Descripcion del puesto</p>
          <div class="" id="editor">
            {!!old('descripcion', $vacante->descripcion)  !!}
          </div>
          @error('descripcion')
          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
          <textarea name="descripcion" id="contenido" class="hidden"></textarea>
        </div>

        <div>
          <label for="salario"
            class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Salario</label>
          <input id="salario" name="salario" value="{{ old('salario', $vacante->salario) }}" type="text" placeholder="Salario del empleo"
            class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('salario')
          dark:border-alerts-500
          @enderror">
          @error('salario')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="postulacion"
            class="font-medium mb-2 after:ml-0.5 after:text-red-500 after:content-['*']">Último día para postularse</label>
          <input id="postulacion" name="postulacion" value="{{ old('postulacion', $vacante->postulacion) }}" type="date"
            placeholder="Ultimo dia para pstularse" class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2 @error('postulacion')
          dark:border-alerts-500
          @enderror">
          @error('postulacion')

          <p class="text-sm font-semibold text-alerts-500">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit"
          class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 w-full mt-5 cursor-pointer">
          Editar Vacante
        </button>
      </form>
    </div>
  </div>
</div>
@endsection