@extends('components.layouts.admin')

@section('contenido')
<div class="w-full flex justify-between items-center max-w-7xl mx-auto">
  <p class="text-xl font-semibold">
    Terminos y condiciones
  </p>
  @can('terminsCon create')

  <a href="{{ route('admin.terminos.create') }}" wire:navigate>
    <button
      class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 cursor-pointer">
      <i class="fa-solid fa-pen"></i>
      Crear Terminos
    </button>
  </a>
  @endcan
</div>

<section class="pt-3">
  <div class="mx-auto max-w-7xl">
    <!-- Start coding here -->
    <div class="bg-light-200 dark:bg-cont-100 relative shadow-md rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="uppercase bg-light-100 dark:bg-gray-700 dark:text-gray-200">
            <tr>
              <th scope="col" class="px-4 py-3">Id</th>
              <th scope="col" class="px-4 py-3">Titulo</th>
              <th scope="col" class="px-4 py-3">Fecha</th>
              <th scope="col" class="px-4 py-3">Contenido</th>
              <th scope="col" class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($terms as $term )
            <tr class="border-b dark:border-gray-700 ">
              <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap dark:text-white">
                {{ $term->id }}
                </th>
              <td class="px-4 py-3">
                <p class="line-clamp-2">
                  {{ $term->titulo }}
                </p>
              </td>
              <td class="px-4 py-3">{{ $term->fecha }}</td>
              <td class="px-4 py-3">{{ $term->contenido }}</td>
              <td class="px-4 py-3 flex items-center justify-start">
                <div class="flex items-center gap-2">
                  @can('terminsCon edit')

                  <a href="{{ route('admin.terminos.edit', $term) }}">
                    <button
                      class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                  </a>
                  @endcan
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

@endsection
