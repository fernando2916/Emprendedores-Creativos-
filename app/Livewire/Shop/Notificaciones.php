<?php

namespace App\Livewire\Shop;

use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Notificaciones extends Component
{
    use WithPagination;

    public function marcarComoLeida(string $id): void
    {
        $notificacion = Auth::user()
            ->notifications()
            ->whereKey($id)
            ->firstOrFail();

        if (! $notificacion->read_at) {
            $notificacion->markAsRead();
        }

        $this->actualizarContador();

        Flux::toast(
            heading: 'Notificaciones',
            text: 'La notificación se marcó como leída.',
            variant: 'success',
        );
    }

    public function abrir(string $id): void
    {
        $notificacion = Auth::user()
            ->notifications()
            ->whereKey($id)
            ->firstOrFail();

        $notificacion->markAsRead();

        $this->actualizarContador();

        $url = $notificacion->data['url']
            ?? route('notificaciones.index');

        $hostAplicacion = parse_url(config('app.url'), PHP_URL_HOST);
        $hostDestino = parse_url($url, PHP_URL_HOST);

        if ($hostDestino && $hostDestino !== $hostAplicacion) {
            $url = route('notificaciones.index');
        }

        $this->redirect($url, navigate: true);
    }

    public function marcarTodasComoLeidas(): void
    {
        Auth::user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        $this->actualizarContador();

        Flux::toast(
            heading: 'Notificaciones',
            text: 'Todas tus notificaciones quedaron marcadas como leídas.',
            variant: 'success',
        );
    }

    public function sincronizarContador(): void
    {
        $this->actualizarContador();
    }

    private function actualizarContador(): void
    {
        $cantidad = Auth::user()
            ->unreadNotifications()
            ->count();

        $this->dispatch(
            'notificaciones-contador',
            cantidad: $cantidad
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
            ->paginate(15);

        $cantidadSinLeer = Auth::user()
            ->unreadNotifications()
            ->count();

        return view('livewire.shop.notificaciones', [
            'notificaciones' => $notificaciones,
            'cantidadSinLeer' => $cantidadSinLeer,
        ])
            ->extends('components.layouts.principal')
            ->section('contenido');
    }
}