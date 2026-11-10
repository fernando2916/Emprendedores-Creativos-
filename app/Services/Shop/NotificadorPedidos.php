<?php

namespace App\Services\Shop;

use App\Models\Orden;
use App\Models\User;
use App\Notifications\NotificationPedido;

class NotificadorPedidos
{
    /**
     * Usuarios que recibirán las notificaciones
     * relacionadas con la operación de la tienda.
     *
     * Se utiliza Spatie para identificar los roles.
     * Un usuario con varios roles recibe una sola notificación.
     */
    private function administradoresTienda()
    {
        return User::query()
            ->whereHas('roles', function ($query) {
                $query->whereRaw(
                    'LOWER(name) IN (?, ?, ?)',
                    [
                        'super admin',
                        'vendedor',
                        'vendedor instructor',
                    ]
                );
            })
            ->get();
    }

    /**
     * Nuevo pedido:
     * - Notifica al cliente.
     * - Notifica a Super Admin, Vendedor y Vendedor Instructor.
     */
    public function nuevoPedido(Orden $orden): void
    {
        $orden->loadMissing('usuario');

        // 1. Notificación para el cliente.
        if ($orden->usuario) {
            $orden->usuario->notify(
                new NotificationPedido(
                    tipo: 'pedido_recibido',
                    titulo: '¡Recibimos tu pedido!',
                    mensaje: "Tu pedido {$orden->numero} quedó registrado correctamente.",
                    url: route('pedido.confirmacion', [
                        'orden' => $orden->id,
                    ]),
                    icono: 'fa-box-open',
                    ordenId: $orden->id,
                    numeroOrden: $orden->numero,
                    estado: $orden->estado,
                )
            );
        }

        // 2. Notificaciones para el equipo de la tienda.
        foreach ($this->administradoresTienda() as $usuario) {
            $usuario->notify(
                new NotificationPedido(
                    tipo: 'nuevo_pedido',
                    titulo: 'Nuevo pedido recibido',
                    mensaje: "Se registró el pedido {$orden->numero} por $" .
                        number_format((float) $orden->total, 2) . ' MXN.',
                    url: route('orden.show', [
                        'orden' => $orden->id,
                    ]),
                    icono: 'fa-cart-shopping',
                    ordenId: $orden->id,
                    numeroOrden: $orden->numero,
                    estado: $orden->estado,
                )
            );
        }
    }

    /**
     * Notifica al cliente cuando cambia el estado del pedido.
     */
    public function estadoActualizado(Orden $orden): void
    {
        $orden->loadMissing('usuario');

        if (! $orden->usuario) {
            return;
        }

        $informacion = match ($orden->estado) {

            'procesando' => [
                'pedido_actualizado',
                'Tu pedido está en proceso',
                'Estamos comenzando a procesar tu pedido.',
                'fa-gears',
            ],

            'en_preparacion' => [
                'pedido_actualizado',
                'Tu pedido está en preparación',
                'Estamos preparando los artículos de tu pedido.',
                'fa-box',
            ],

            'enviado' => [
                'pedido_enviado',
                '¡Tu pedido fue enviado!',
                'Tu pedido fue enviado' .
                    ($orden->paqueteria
                        ? ' por ' . $orden->paqueteria
                        : '') .
                    '. Número de guía: ' .
                    ($orden->numero_guia ?: 'No disponible') . '.',
                'fa-truck-fast',
            ],

            'listo_para_recoger' => [
                'pedido_listo_recoger',
                '¡Tu pedido está listo para recoger!',
                'Ya puedes acudir al punto de entrega para recoger tu pedido.',
                'fa-store',
            ],

            'entregado' => [
                'pedido_actualizado',
                'Tu pedido fue entregado',
                'Tu pedido aparece como entregado. ¡Gracias por tu compra!',
                'fa-house-circle-check',
            ],

            'completado' => [
                'pedido_actualizado',
                'Tu pedido fue completado',
                'Tu pedido se completó correctamente.',
                'fa-circle-check',
            ],

            default => [
                'pedido_actualizado',
                'Tu pedido fue actualizado',
                "El estado de tu pedido cambió a {$orden->estado}.",
                'fa-bell',
            ],
        };

        [
            $tipo,
            $titulo,
            $mensaje,
            $icono
        ] = $informacion;

        $orden->usuario->notify(
            new NotificationPedido(
                tipo: $tipo,
                titulo: $titulo,
                mensaje: $mensaje,
                url: route('pedido.confirmacion', [
                    'orden' => $orden->id,
                ]),
                icono: $icono,
                ordenId: $orden->id,
                numeroOrden: $orden->numero,
                estado: $orden->estado,
            )
        );
    }

    /**
     * Notifica al cliente y al equipo de la tienda
     * cuando un pedido es cancelado.
     *
     * También funciona para cancelaciones automáticas
     * por expiración de la reserva.
     */
    public function pedidoCancelado(Orden $orden): void
    {
        $orden->loadMissing('usuario');

        // 1. Notificación al cliente.
        if ($orden->usuario) {
            $orden->usuario->notify(
                new NotificationPedido(
                    tipo: 'pedido_cancelado',
                    titulo: 'Tu pedido fue cancelado',
                    mensaje: "El pedido {$orden->numero} fue cancelado y sus reservas se liberaron.",
                    url: route('pedido.confirmacion', [
                        'orden' => $orden->id,
                    ]),
                    icono: 'fa-ban',
                    ordenId: $orden->id,
                    numeroOrden: $orden->numero,
                    estado: $orden->estado,
                )
            );
        }

        // 2. Avisar al equipo de la tienda.
        foreach ($this->administradoresTienda() as $usuario) {
            $usuario->notify(
                new NotificationPedido(
                    tipo: 'pedido_cancelado_admin',
                    titulo: 'Pedido cancelado',
                    mensaje: "El pedido {$orden->numero} fue cancelado.",
                    url: route('orden.show', [
                        'orden' => $orden->id,
                    ]),
                    icono: 'fa-ban',
                    ordenId: $orden->id,
                    numeroOrden: $orden->numero,
                    estado: $orden->estado,
                )
            );
        }
    }
}