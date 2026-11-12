<?php

namespace App\Livewire\Shop;

use App\Models\Orden;
use App\Models\Producto;
use App\Models\ProductoPregunta;
use App\Models\ProductoRespuesta;
use App\Models\ProductoReview;
use App\Models\ProductoVariante;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ProductoInteracciones extends Component
{
    // Cambiar a true cuando se implemente la pasarela de pago.
    private const REQUIERE_COMPRA_VERIFICADA = false;

    public Producto $producto;

    // Reseñas
    public int $calificacion = 5;
    public string $comentario = '';

    // Preguntas
    public string $pregunta = '';

    // Respuestas
    public string $contenidoRespuesta = '';
    public ?string $tipoRespuesta = null;
    public ?int $idRespuesta = null;

    public bool $puedeResponder = false;

    public function mount(Producto $producto): void
    {
        $this->producto = $producto;

        $this->puedeResponder = Auth::check()
            && Auth::user()->hasAnyRole([
                'Super Admin',
                'Vendedor',
                'Vendedor Instructor',
            ]);

        if (Auth::check()) {
            $miResena = $this->producto
                ->reseñas()
                ->where('user_id', Auth::id())
                ->first();

            if ($miResena) {
                $this->calificacion = $miResena->calificacion;
                $this->comentario = $miResena->comentario ?? '';
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | COMPRA VERIFICADA
    |--------------------------------------------------------------------------
    */

    private function obtenerOrdenVerificada(): ?Orden
    {
        if (! Auth::check()) {
            return null;
        }

        $variantesIds = $this->producto
            ->variantes()
            ->pluck('id');

        if ($variantesIds->isEmpty()) {
            return null;
        }

        $tipoComprable = (new ProductoVariante())->getMorphClass();

        return Orden::query()
            ->where('user_id', Auth::id())
            ->where('estado_pago', 'pagado')
            ->whereIn('estado', ['entregado', 'completado'])
            ->whereHas('items', function ($query) use (
                $variantesIds,
                $tipoComprable
            ) {
                $query
                    ->where('comprable_type', $tipoComprable)
                    ->whereIn('comprable_id', $variantesIds);
            })
            ->latest('fecha_entrega')
            ->latest('id')
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | RESEÑAS
    |--------------------------------------------------------------------------
    */

    public function guardarResena(): void
    {
        if (! Auth::check()) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        $orden = self::REQUIERE_COMPRA_VERIFICADA
            ? $this->obtenerOrdenVerificada()
            : null;

        if (self::REQUIERE_COMPRA_VERIFICADA && ! $orden) {
            Flux::toast(
                heading: 'Compra no verificada',
                text: 'Para publicar una reseña debes haber comprado este producto y tener el pedido pagado y entregado.',
                variant: 'warning',
            );

            return;
        }

        $datos = $this->validate([
            'calificacion' => ['required', 'integer', 'between:1,5'],
            'comentario' => ['nullable', 'string', 'max:3000'],
        ]);

        $resena = ProductoReview::firstOrNew([
            'producto_id' => $this->producto->id,
            'user_id' => Auth::id(),
        ]);
        
        $esNueva = ! $resena->exists;

        $resena->calificacion = $datos['calificacion'];
        $resena->comentario = trim($datos['comentario'] ?? '');
        $resena->estado = true;

        // Si se exige compra, asociamos la orden verificada.
        // Si todavía no se exige, conservamos una orden anterior si existe.
        if ($orden) {
            $resena->orden_id = $orden->id;
        }

        $resena->save();

        // Notificar únicamente cuando se crea una reseña nueva.
        // Si el cliente está editando su reseña, no enviamos aviso.
        if ($esNueva) {
            app(\App\Services\Shop\NotificadorInteraccionesProducto::class)
                ->nuevaResena($resena);
        }

        // Conservamos el contenido para que pueda editarse.
        $this->calificacion = $resena->calificacion;
        $this->comentario = $resena->comentario ?? '';

        Flux::toast(
            heading: '¡Gracias por tu opinión!',
            text: 'Tu reseña se guardó correctamente.',
            variant: 'success',
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PREGUNTAS
    |--------------------------------------------------------------------------
    */

    public function guardarPregunta(): void
    {
        if (! Auth::check()) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        $datos = $this->validate([
            'pregunta' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        $pregunta = ProductoPregunta::create([
            'producto_id' => $this->producto->id,
            'user_id' => Auth::id(),
            'contenido' => trim($datos['pregunta']),
            'estado' => true,
        ]);

        // Notificar al propietario del producto y al Super Admin.
        app(\App\Services\Shop\NotificadorInteraccionesProducto::class)
            ->nuevaPregunta($pregunta);

        $this->reset('pregunta');

        Flux::toast(
            heading: 'Pregunta publicada',
            text: 'Tu pregunta se publicó correctamente.',
            variant: 'success',
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RESPUESTAS
    |--------------------------------------------------------------------------
    */

    public function responderA(string $tipo, int $id): void
    {
        if (! Auth::check()) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        if (in_array($tipo, ['resena', 'pregunta'], true)) {
            $this->verificarPermisoRespuesta();
            $this->obtenerPublicacion($tipo, $id);
        } elseif ($tipo === 'respuesta') {
            // Los usuarios autenticados pueden continuar una conversación.
            $this->obtenerRespuesta($id);
        } else {
            abort(404);
        }

        $this->tipoRespuesta = $tipo;
        $this->idRespuesta = $id;
        $this->contenidoRespuesta = '';
    }

    public function cancelarRespuesta(): void
    {
        $this->reset([
            'contenidoRespuesta',
            'tipoRespuesta',
            'idRespuesta',
        ]);
    }

    public function guardarRespuesta(): void
    {
        if (! Auth::check()) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        $datos = $this->validate([
            'contenidoRespuesta' => [
                'required',
                'string',
                'min:2',
                'max:2000',
            ],
            'tipoRespuesta' => [
                'required',
                'in:resena,pregunta,respuesta',
            ],
            'idRespuesta' => ['required', 'integer'],
        ]);

        if (in_array($datos['tipoRespuesta'], ['resena', 'pregunta'], true)) {
            $this->verificarPermisoRespuesta();

            $publicacion = $this->obtenerPublicacion(
                $datos['tipoRespuesta'],
                $datos['idRespuesta']
            );

            $parentId = null;
        } else {
            // Responder a otra respuesta.
            $respuestaPadre = $this->obtenerRespuesta(
                $datos['idRespuesta']
            );

            $publicacion = $respuestaPadre->respondible;
            $parentId = $respuestaPadre->id;
        }

        // Guardar la respuesta.
        $respuesta = $publicacion->respuestas()->create([
            'user_id' => Auth::id(),
            'contenido' => trim($datos['contenidoRespuesta']),
            'parent_id' => $parentId,
        ]);

        // Enviar notificación al autor de la pregunta o reseña.
        app(\App\Services\Shop\NotificadorInteraccionesProducto::class)
            ->respuestaCreada($respuesta);

        $this->cancelarRespuesta();

        Flux::toast(
            heading: 'Respuesta publicada',
            text: 'Tu respuesta se publicó correctamente.',
            variant: 'success',
        );
    }

    private function verificarPermisoRespuesta(): void
    {
        abort_unless(
            Auth::check()
            && Auth::user()->hasAnyRole([
                'Super Admin',
                'Vendedor',
                'Admin',
            ]),
            403
        );
    }

    private function obtenerPublicacion(string $tipo, int $id)
    {
        if ($tipo === 'resena') {
            return ProductoReview::query()
                ->where('producto_id', $this->producto->id)
                ->where('estado', true)
                ->findOrFail($id);
        }

        if ($tipo === 'pregunta') {
            return ProductoPregunta::query()
                ->where('producto_id', $this->producto->id)
                ->where('estado', true)
                ->findOrFail($id);
        }

        abort(404);
    }

    private function obtenerRespuesta(int $id): ProductoRespuesta
    {
        return ProductoRespuesta::query()
            ->whereHasMorph(
                'respondible',
                [ProductoReview::class, ProductoPregunta::class],
                function ($query) {
                    $query->where('producto_id', $this->producto->id);
                }
            )
            ->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | VALORACIONES: ¿TE RESULTÓ ÚTIL?
    |--------------------------------------------------------------------------
    */

    public function valorar(string $tipo, int $id, bool $util): void
    {
        if (! Auth::check()) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        $publicacion = match ($tipo) {
            'resena', 'pregunta' => $this->obtenerPublicacion($tipo, $id),
            'respuesta' => $this->obtenerRespuesta($id),
            default => abort(404),
        };

        // Evitamos que el autor valore su propia publicación.
        if ((int) $publicacion->user_id === (int) Auth::id()) {
            Flux::toast(
                heading: 'No puedes valorar tu publicación',
                text: 'Puedes valorar las publicaciones de otros usuarios.',
                variant: 'warning',
            );

            return;
        }

        $publicacion->valoraciones()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['util' => $util]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | AVATAR E IDENTIDAD
    |--------------------------------------------------------------------------
    */

    public function avatarUrl(?User $user): ?string
    {
        if (! $user?->profile?->avatar) {
            return null;
        }

        return Storage::url($user->profile->avatar);
    }

    public function iniciales(?User $user): string
    {
        $nombre = trim($user?->nombre_completo ?? 'Usuario');

        $partes = preg_split('/\s+/', $nombre);

        $iniciales = collect($partes)
            ->filter()
            ->take(2)
            ->map(fn ($parte) => mb_strtoupper(mb_substr($parte, 0, 1)))
            ->implode('');

        return $iniciales ?: 'U';
    }

    public function rolUsuario(?User $user): string
    {
        if (! $user) {
            return 'Cliente';
        }

        $roles = $user->getRoleNames();

        foreach ([
            'Super Admin' => 'CEO Administrador',
            'Admin' => 'Administrador',
            'Vendedor' => 'Vendedor',
        ] as $rol => $etiqueta) {
            if ($roles->contains($rol)) {
                return $etiqueta;
            }
        }

        return $roles->first() ?? '';
    }

    /*
    |--------------------------------------------------------------------------
    | CARGA RECURSIVA DE RESPUESTAS
    |--------------------------------------------------------------------------
    */

    private function cargarRespuestasRecursivas($respuestas): void
    {
        foreach ($respuestas as $respuesta) {
            $respuesta->loadMissing([
                'user.profile',
                'user.roles',
                'valoraciones',
                'replies',
            ]);

            if ($respuesta->replies->isNotEmpty()) {
                $this->cargarRespuestasRecursivas($respuesta->replies);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $resenas = $this->producto
            ->reseñasPublicadas()
            ->with([
                'user.profile',
                'user.roles',
                'valoraciones',
                'respuestas',
            ])
            ->latest()
            ->get();

        $preguntas = $this->producto
            ->preguntas()
            ->where('estado', true)
            ->with([
                'user.profile',
                'user.roles',
                'valoraciones',
                'respuestas',
            ])
            ->latest()
            ->get();

        foreach ($resenas as $resena) {
            $this->cargarRespuestasRecursivas($resena->respuestas);
        }

        foreach ($preguntas as $pregunta) {
            $this->cargarRespuestasRecursivas($pregunta->respuestas);
        }

        $promedio = $resenas->avg('calificacion') ?? 0;

        $distribucion = [];

        for ($estrellas = 5; $estrellas >= 1; $estrellas--) {
            $cantidad = $resenas
                ->where('calificacion', $estrellas)
                ->count();

            $distribucion[$estrellas] = [
                'cantidad' => $cantidad,
                'porcentaje' => $resenas->count() > 0
                    ? ($cantidad / $resenas->count()) * 100
                    : 0,
            ];
        }

        $miResena = Auth::check()
            ? $resenas->firstWhere('user_id', Auth::id())
                ?? $this->producto->reseñas()
                    ->where('user_id', Auth::id())
                    ->first()
            : null;

        return view('livewire.shop.producto-interacciones', [
            'resenas' => $resenas,
            'preguntas' => $preguntas,
            'promedio' => round($promedio, 1),
            'totalResenas' => $resenas->count(),
            'distribucion' => $distribucion,
            'ordenVerificada' => self::REQUIERE_COMPRA_VERIFICADA
                ? $this->obtenerOrdenVerificada()
                : null,
            'requiereCompraVerificada' => self::REQUIERE_COMPRA_VERIFICADA,
            'miResena' => $miResena,
        ]);
    }
}