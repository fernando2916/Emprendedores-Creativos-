<?php

namespace App\Livewire\Shop;

use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificacionesMenu extends Component
{
    public int $cantidadSinLeer = 0;

    public function mount(): void
    {
        $this->sincronizarContador();
    }

    /**
     * Actualiza el contador de notificaciones no leídas.
     * Se ejecuta periódicamente desde wire:poll.
     */
    public function sincronizarContador(): void
    {
        $cantidad = Auth::user()
            ->unreadNotifications()
            ->count();

        if ($cantidad !== $this->cantidadSinLeer) {
            $this->cantidadSinLeer = $cantidad;

            $this->dispatch(
                'notificaciones-contador',
                cantidad: $cantidad
            );
        }
    }

    /**
     * Marca una notificación propia como leída y abre su destino.
     */
    public function abrir(string $id): void
    {
        $notificacion = Auth::user()
            ->notifications()
            ->whereKey($id)
            ->firstOrFail();

        $notificacion->markAsRead();

        $this->sincronizarContador();

        $url = $notificacion->data['url']
            ?? route('notificaciones.index');

        // Las URLs se generan desde nuestra aplicación.
        $hostAplicacion = parse_url(config('app.url'), PHP_URL_HOST);
        $hostDestino = parse_url($url, PHP_URL_HOST);

        if ($hostDestino && $hostDestino !== $hostAplicacion) {
            $url = route('notificaciones.index');
        }

        $this->redirect($url, navigate: true);
    }

    public function marcarComoLeida(string $id): void
    {
        $notificacion = Auth::user()
            ->notifications()
            ->whereKey($id)
            ->firstOrFail();

        if (is_null($notificacion->read_at)) {
            $notificacion->markAsRead();
        }

        $this->sincronizarContador();
    }
    /**
     * Marca todas las notificaciones propias como leídas.
     */
    public function marcarTodasComoLeidas(): void
    {
        Auth::user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        $this->cantidadSinLeer = 0;

        $this->dispatch(
            'notificaciones-contador',
            cantidad: 0
        );

        Flux::toast(
            heading: 'Notificaciones',
            text: 'Todas tus notificaciones quedaron marcadas como leídas.',
            variant: 'success',
        );
    }

    public function render()
    {
        $limite = now()->subMinutes(5);

        $notificaciones = Auth::user()
            ->notifications()
            ->where(function ($query) use ($limite) {
                $query
                    ->whereNull('read_at')
                    ->orWhere('read_at', '>=', $limite);
            })
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.shop.notificaciones-menu', [
            'notificaciones' => $notificaciones,
        ]);
    }
}