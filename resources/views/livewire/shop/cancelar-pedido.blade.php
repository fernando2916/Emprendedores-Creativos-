@if (
    $orden->estado === 'pendiente'
    && $orden->estado_pago === 'pendiente'
)
    <div class="mb-3 text-center">

        <button
            type="button"
            x-on:click.prevent="
                Swal.fire({
                    title: '¿Cancelar pedido?',
                    text: 'Se liberarán las existencias reservadas y el cupón asociado. Esta acción no se puede deshacer.',
                    icon: 'warning',
                    background: '#120024',
                    color: '#ffffff',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#4b5563',
                    confirmButtonText: 'Sí, cancelar pedido',
                    cancelButtonText: 'No, regresar',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.cancelar();
                    }
                })
            "
            wire:loading.attr="disabled"
            wire:target="cancelar"
            class="inline-flex items-center justify-center gap-2 rounded-md border border-red-300 px-6 py-3 font-semibold text-red-700 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-red-800 dark:text-red-300 dark:hover:bg-red-900/20 cursor-pointer"
        >
            <i class="fa-solid fa-xmark"></i>
            Cancelar pedido
        </button>

    </div>
@endif
