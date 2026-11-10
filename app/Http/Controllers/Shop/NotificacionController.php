<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
public function abrir(string $notification): RedirectResponse
{
    // Solo se puede abrir una notificación de la cuenta autenticada.
    $notificacion = Auth::user()
        ->notifications()
        ->whereKey($notification)
        ->firstOrFail();

    // Marcarla como leída antes de salir hacia el destino.
    if (is_null($notificacion->read_at)) {
        $notificacion->markAsRead();
    }

    $url = $notificacion->data['url'] ?? null;

    if (! is_string($url) || blank($url)) {
        return redirect()->route('notificaciones.index');
    }

    // Extraer únicamente la ruta local.
    // Nunca redirigir directamente a un dominio externo.
    $partes = parse_url($url);
    $path = $partes['path'] ?? null;

    if (
        ! is_string($path) ||
        ! str_starts_with($path, '/') ||
        str_starts_with($path, '//') ||
        str_contains($path, '\\')
    ) {
        return redirect()->route('notificaciones.index');
    }

    $destino = $path;

    if (! empty($partes['query'])) {
        $destino .= '?' . $partes['query'];
    }

    if (! empty($partes['fragment'])) {
        $destino .= '#' . $partes['fragment'];
    }

    return redirect()->to($destino);
}
}