@extends('components.layouts.admin')

@section('contenido')
<x-ui.bredcrumb :items="[
    ['url' => route('admin.vacante.index'), 'label' => 'Vacantes', 'navigate' => true],
    ['url' => '', 'label' => 'Candidatos | Vacante']  {{-- Último elemento desactivado --}}
]" />

<section class="pt-3">
   <div class="py-12 w-full mx-auto">
          <div class="max-w-7xl sm:px-6 lg:px-8 mx-auto">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-light-300 dark:bg-cont-100 border-b border-gray-300">
                <h1 class="text-2xl font-bold text-center my-10">
                  Candidatos Vacante: {{ $vacante->puesto }}
                </h1>
                <div class="md:flex md:justify-center p-5">
                  <ul class="divide-y divide-gray-300 w-full">
                    @forelse ($vacante->candidatos as $candidato )
                      <li class="p-3 flex items-center">
                        <div class="flex-1">
                          <p class="text-xl font-medium capitalize">{{ $candidato->nombre }}</p>
                          <p class="text-lg font-medium text-slate-300">{{ $candidato->telefono }}</p>
                          <p class="text-sm text-slate-200">{{ $candidato->correo }}</p>
                          <p class="text-sm text-slate-200">
                           Día que se postulo:  {{ $candidato->created_at->diffForHumans() }}

                          </p>
                        </div>
                        <div>
                          <a href="{{ asset('storage/' . $candidato->curriculum) }}" class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 text-white transition-colors duration-150 rounded-md p-3"
                          target="_blank"
                          rel="noreferrer noopener"
                            >
                            Ver CV
                          </a>
                        </div>
                      </li>
                    @empty
                      <p class="">No hay candidatos aún.</p>
                    @endforelse
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
</section>

@endsection

@push('scripts')
<script>
  document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        Swal.fire({
                  title: "¿Estás seguro?",
                  text: "¡No podrás revertir esto!",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Sí, eliminar",
                  cancelButtonText: "Cancelar",
                  background: "#120024",
                  color: "#ffffff",
                }).then((result) => {
                  if(result.isConfirmed) {
                    form.submit();
                  }
                })
      })
    })
</script>
@endpush