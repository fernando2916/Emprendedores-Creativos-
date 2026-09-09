@extends('components.layouts.admin')

@section('contenido')
    <div class="w-full flex justify-between items-center max-w-7xl mx-auto">
        <p class="text-xl font-semibold">
            Mensajes de contacto
        </p>
    </div>

    <section class="pt-3">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @forelse ($contactos as $contacto)
                    <div class="p-5 bg-light-300 rounded-lg border-link-100 border-2 dark:bg-cont-100 space-y-3">
                        <div>
                            <p class="font-bold">Solicitante:
                            </p>
                            {{ $contacto->name }}
                        </div>
                        <div>
                            <p class="font-bold">Solicitante:
                            </p>
                            {{ $contacto->company }}
                        </div>
                        <div class="">
                            <p class="font-bold">Detalles de la cotización:</p>
                            {{ $contacto->messaje }}
                        </div>
                        <div class="">
                            <p class="font-bold">
                                Medios de contacto:
                            </p>
                            <p class="">Correo:
                                <span class="">
                                    {{ $contacto->email }}
                                </span>
                            </p>
                            <p class=""> WhatsApp:
                                <span class="">
                                    {{ $contacto->phone }}
                                </span>
                            </p>
                        </div>

                        <p class="">{{ $contacto->created_at->diffForHumans() }}</p>
                        <form class="delete-form" action="{{ route('admin.contacto.destroy', $contacto) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-2 bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 dark:hover:bg-btn-600 transition-colors duration-150 rounded-md cursor-pointer w-full">
                                Mensaje Atendido
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="">No hay mensajes por ahora.</p>
                @endforelse
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
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            })
        })
    </script>
@endpush
