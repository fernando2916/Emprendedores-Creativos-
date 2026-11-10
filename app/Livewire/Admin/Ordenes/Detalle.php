<?php

namespace App\Livewire\Admin\Ordenes;

use App\Models\Orden;
use App\Services\Shop\CancelarOrdenService;
use DomainException;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Shop\NotificadorPedidos;
use Livewire\Component;
use Throwable;

class Detalle extends Component
{
    public Orden $orden;

    public string $estadoNuevo = '';
    
    public string $paqueteria = '';

    public string $numeroGuia = '';

    public string $urlRastreo = '';

    public string $notasAdmin = '';

    public function mount(Orden $orden): void
    {
        $this->orden = $orden->load([
            'usuario',
            'items',
        ]);

        // Seleccionar automáticamente el siguiente estado permitido.
        $this->estadoNuevo = $this->transicionesPermitidas($this->orden)[0]
            ?? $this->orden->estado;

        $this->cargarDatosSeguimiento();
    }

    /**
     * Actualiza el estado siguiendo el flujo permitido.
     */
    public function actualizarEstado(): void
    {   
        try {
            $estadoAnterior = $this->orden->estado;
            DB::transaction(function () {

                $orden = Orden::query()
                    ->whereKey($this->orden->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $transiciones = $this->transicionesPermitidas($orden);

                if (! in_array($this->estadoNuevo, $transiciones, true)) {
                    throw new DomainException(
                        'La transición solicitada no está permitida para este pedido.'
                    );
                }

                // Para recoger en tienda o para una entrega a domicilio,
                // la fecha se registra cuando el pedido llega al cliente.
                if (
                    $this->estadoNuevo === 'entregado' &&
                    ! $orden->fecha_entrega
                ) {
                    $orden->fecha_entrega = now();
                }

                // No permitir completar un pedido sin pago confirmado.
                if (
                    $this->estadoNuevo === 'completado' &&
                    $orden->estado_pago !== 'pagado'
                ) {
                    throw new DomainException(
                        'No puedes completar un pedido que todavía tiene el pago pendiente.'
                    );
                }

                // Registrar la fecha cuando el pedido pasa a enviado.
                if (
                    $orden->tipo_entrega === 'domicilio' &&
                    $this->estadoNuevo === 'enviado'
                ) {
                    if (
                        blank($orden->paqueteria) ||
                        blank($orden->numero_guia)
                    ) {
                        throw new DomainException(
                            'Primero guarda la paquetería y el número de guía antes de marcar el pedido como enviado.'
                        );
                    }

                    // Registrar solamente la primera fecha de envío.
                    if (is_null($orden->fecha_envio)) {
                        $orden->fecha_envio = now();
                    }
                }

                $orden->estado = $this->estadoNuevo;
                $orden->save();
            });

            $this->actualizarModelo();

            // Notificar al cliente únicamente cuando cambió el estado.
            if ($estadoAnterior !== $this->orden->estado) {

                try {

                    app(NotificadorPedidos::class)
                        ->estadoActualizado($this->orden);

                } catch (\Throwable $e) {

                    report($e);

                    logger()->error(
                        'Error al notificar el cambio de estado del pedido.',
                        [
                            'orden_id' => $this->orden->id,
                            'estado' => $this->orden->estado,
                            'error' => $e->getMessage(),
                        ]
                    );
                }
            }
            
            Flux::toast(
                heading: 'Estado actualizado',
                text: 'El estado del pedido se actualizó correctamente.',
                variant: 'success',
            );

        } catch (DomainException $e) {

            Flux::toast(
                heading: 'No se pudo actualizar',
                text: $e->getMessage(),
                variant: 'warning',
            );

            $this->actualizarModelo();

        } catch (Throwable $e) {

            report($e);

            Flux::toast(
                heading: 'Error al actualizar',
                text: 'Ocurrió un problema al modificar el pedido.',
                variant: 'danger',
            );

            $this->actualizarModelo();
        }
    }

    /**
     * Cancela desde el panel administrativo.
     * La ruta administrativa debe estar protegida por el middleware
     * que ya utilizas para tus demás pantallas de administración.
     */
    public function cancelarPedido(CancelarOrdenService $servicio): void
    {
        try {
            $servicio->cancelar(
                $this->orden,
                (int) Auth::id(),
                true
            );

            $this->actualizarModelo();

            Flux::toast(
                heading: 'Pedido cancelado',
                text: 'Se liberaron las existencias y el cupón reservado, si correspondía.',
                variant: 'success',
            );

        } catch (DomainException $e) {

            $this->actualizarModelo();

            Flux::toast(
                heading: 'No se pudo cancelar',
                text: $e->getMessage(),
                variant: 'warning',
            );

        } catch (Throwable $e) {

            report($e);

            Flux::toast(
                heading: 'Error al cancelar',
                text: 'No fue posible cancelar el pedido.',
                variant: 'danger',
            );
        }
    }

    private function cargarDatosSeguimiento(): void
    {
        $this->paqueteria = $this->orden->paqueteria ?? '';

        $this->numeroGuia = $this->orden->numero_guia ?? '';

        $this->urlRastreo = $this->orden->url_rastreo ?? '';

        $this->notasAdmin = $this->orden->notas_admin ?? '';
    }

    public function guardarSeguimiento(): void
    {
        if ($this->orden->estado === 'cancelado') {
            Flux::toast(
                heading: 'Pedido cancelado',
                text: 'No puedes modificar el seguimiento de un pedido cancelado.',
                variant: 'warning',
            );

            return;
        }

        $datos = $this->validate([
            'paqueteria' => ['nullable', 'string', 'max:100'],
            'numeroGuia' => ['nullable', 'string', 'max:150'],
            'urlRastreo' => ['nullable', 'url', 'max:2048'],
            'notasAdmin' => ['nullable', 'string', 'max:5000'],
        ], [], [
            'paqueteria' => 'paquetería',
            'numeroGuia' => 'número de guía',
            'urlRastreo' => 'enlace de rastreo',
            'notasAdmin' => 'notas administrativas',
        ]);

        $this->orden->update([
            'paqueteria' => filled($datos['paqueteria'])
                ? trim($datos['paqueteria'])
                : null,

            'numero_guia' => filled($datos['numeroGuia'])
                ? trim($datos['numeroGuia'])
                : null,

            'url_rastreo' => filled($datos['urlRastreo'])
                ? trim($datos['urlRastreo'])
                : null,

            'notas_admin' => filled($datos['notasAdmin'])
                ? trim($datos['notasAdmin'])
                : null,
        ]);

        $this->orden->refresh();

        $this->cargarDatosSeguimiento();

        Flux::toast(
            heading: 'Seguimiento actualizado',
            text: 'Los datos de entrega se guardaron correctamente.',
            variant: 'success',
        );
    }

    /**
     * Define el orden de avance de un pedido.
     */
    private function transicionesPermitidas(Orden $orden): array
    {
        return match ($orden->estado) {
            'pendiente' => ['procesando'],

            'procesando' => ['en_preparacion'],

            'en_preparacion' => $orden->tipo_entrega === 'recoger_tienda'
                ? ['listo_para_recoger']
                : ['enviado'],

            'listo_para_recoger' => ['entregado'],

            'enviado' => ['entregado'],

            'entregado' => $orden->estado_pago === 'pagado'
                ? ['completado']
                : [],

            default => [],
        };
    }

    private function actualizarModelo(): void
    {
            $this->orden = Orden::with([
            'usuario',
            'items',
        ])->findOrFail($this->orden->id);

        // Después de actualizar el estado, seleccionar el siguiente paso.
        $this->estadoNuevo = $this->transicionesPermitidas($this->orden)[0]
            ?? $this->orden->estado;

        $this->cargarDatosSeguimiento();
    }

    public function render(): View
    {
        return view('livewire.admin.ordenes.detalle', [
            'estadosDisponibles' => $this->transicionesPermitidas(
                $this->orden
            ),
        ])
            ->extends('components.layouts.admin')
            ->section('contenido');
    }
}