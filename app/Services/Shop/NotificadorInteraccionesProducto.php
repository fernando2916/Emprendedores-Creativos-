<?php

namespace App\Services\Shop;

use App\Models\Producto;
use App\Models\ProductoPregunta;
use App\Models\ProductoRespuesta;
use App\Models\ProductoReview;
use App\Models\User;
use App\Notifications\NotificacionInteraccionProducto;

class NotificadorInteraccionesProducto
{
    /*
    |--------------------------------------------------------------------------
    | NUEVA PREGUNTA
    |--------------------------------------------------------------------------
    */

    public function nuevaPregunta(ProductoPregunta $pregunta): void
    {
        $pregunta->loadMissing([
            'user',
            'producto.propietario',
        ]);

        $producto = $pregunta->producto;
        $autor = $pregunta->user;

        if (! $producto || ! $autor) {
            return;
        }

        $nombreUsuario = $autor->nombre_completo ?: 'Un usuario';

        $this->notificarPropietarioYAdministradores(
            producto: $producto,
            autor: $autor,
            titulo: 'Nueva pregunta en tu producto',
            mensaje: "{$nombreUsuario} publicó una pregunta sobre el producto {$producto->nombre}.",
            icono: 'fa-circle-question',
            tipo: 'nueva_pregunta',
            datos: [
                'pregunta_id' => $pregunta->id,
            ],
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NUEVA RESEÑA
    |--------------------------------------------------------------------------
    */

    public function nuevaResena(ProductoReview $resena): void
    {
        $resena->loadMissing([
            'user',
            'producto.propietario',
        ]);

        $producto = $resena->producto;
        $autor = $resena->user;

        if (! $producto || ! $autor) {
            return;
        }

        $nombreUsuario = $autor->nombre_completo ?: 'Un usuario';

        $this->notificarPropietarioYAdministradores(
            producto: $producto,
            autor: $autor,
            titulo: 'Nueva reseña en tu producto',
            mensaje: "{$nombreUsuario} publicó una reseña sobre el producto {$producto->nombre}.",
            icono: 'fa-star',
            tipo: 'nueva_resena',
            datos: [
                'resena_id' => $resena->id,
                'calificacion' => $resena->calificacion,
            ],
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NOTIFICAR AL PROPIETARIO Y SUPER ADMIN
    |--------------------------------------------------------------------------
    */

    private function notificarPropietarioYAdministradores(
        Producto $producto,
        User $autor,
        string $titulo,
        string $mensaje,
        string $icono,
        string $tipo,
        array $datos = [],
    ): void {
        // Obtenemos al propietario del producto.
        $propietario = $producto->propietario;

        // Obtenemos a todos los usuarios Super Admin.
        $administradores = User::role('Super Admin')->get();

        // Unimos los destinatarios y evitamos duplicados.
        $destinatarios = collect([$propietario])
            ->merge($administradores)
            ->filter()
            ->unique('id')
            // No notificamos al usuario que publicó.
            ->reject(fn (User $usuario) => $usuario->is($autor));

        foreach ($destinatarios as $destinatario) {
            $destinatario->notify(
                new NotificacionInteraccionProducto(
                    titulo: $titulo,
                    mensaje: $mensaje,
                    url: route('tienda.show', [
                        'producto' => $producto->slug,
                    ]),
                    icono: $icono,
                    datos: array_merge([
                        'tipo' => $tipo,
                        'producto_id' => $producto->id,
                        'autor_id' => $autor->id,
                    ], $datos),
                )
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RESPUESTA A PREGUNTA O RESEÑA
    |--------------------------------------------------------------------------
    */

    public function respuestaCreada(ProductoRespuesta $respuesta): void
    {
        $respuesta->loadMissing([
            'user',
            'respondible',
        ]);

        $publicacion = $respuesta->respondible;

        if (
            ! $publicacion instanceof ProductoPregunta &&
            ! $publicacion instanceof ProductoReview
        ) {
            return;
        }

        $publicacion->loadMissing([
            'user',
            'producto',
        ]);

        $destinatario = $publicacion->user;
        $autorRespuesta = $respuesta->user;
        $producto = $publicacion->producto;

        if (! $destinatario || ! $autorRespuesta || ! $producto) {
            return;
        }

        // No notificar al usuario que responde su propia publicación.
        if ($destinatario->is($autorRespuesta)) {
            return;
        }

        $esResena = $publicacion instanceof ProductoReview;

        $titulo = $esResena
            ? 'Respondieron tu reseña'
            : 'Respondieron tu pregunta';

        $tipoPublicacion = $esResena ? 'reseña' : 'pregunta';

        $nombreUsuario = $autorRespuesta->nombre_completo ?: 'Un usuario';

        $mensaje = "{$nombreUsuario} respondió a tu {$tipoPublicacion} sobre el producto {$producto->nombre}.";

        $icono = $esResena ? 'fa-star' : 'fa-circle-question';

        $destinatario->notify(
            new NotificacionInteraccionProducto(
                titulo: $titulo,
                mensaje: $mensaje,
                url: route('tienda.show', [
                    'producto' => $producto->slug,
                ]),
                icono: $icono,
                datos: [
                    'tipo' => 'respuesta_producto',
                    'producto_id' => $producto->id,
                    'respuesta_id' => $respuesta->id,
                    'publicacion_id' => $publicacion->id,
                    'publicacion_tipo' => $tipoPublicacion,
                    'respondio_user_id' => $autorRespuesta->id,
                ],
            )
        );
    }
}