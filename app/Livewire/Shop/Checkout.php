<?php

namespace App\Livewire\Shop;

use App\Models\Carrito as CarritoModel;
use App\Models\Direccion;
use App\Models\ProductoVariante;
use App\Services\Shop\CalculadoraPrecios;
use App\Services\Shop\CarritoService;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Shop\CalculadoraEnvio;
use App\Services\Shop\CalculadoraCupones;
use Illuminate\Support\Collection;
use App\Models\CarritoItem;
use App\Models\Cupon;
use App\Models\CuponUso;
// use App\Models\Orden;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use App\Models\User;
// use App\Services\Shop\NotificadorPedidos;
use App\Models\CheckoutIntento;
use App\Models\CheckoutIntentoItem;
use App\Services\Shop\DisponibilidadInventarioService;
use Livewire\Component;

class Checkout extends Component
{
    public ?int $direccionId = null;
    public string $tipoEntrega = 'domicilio';
    public string $codigoCupon = '';

    public string $mensajeCupon = '';

    public string $tipoMensajeCupon = 'info';

    public function mount()
    {
        $usuario = Auth::user();

        $servicio = app(CarritoService::class);

        // Compatibilidad con artículos anteriores que pudieran quedar
        // en la sesión antes de migrar a la base de datos.
        $servicio->sincronizarSesion($usuario);

        $carrito = $servicio->obtenerOCrear($usuario);
        $carrito->loadMissing('cupon');

        $this->codigoCupon = $carrito->cupon?->codigo ?? '';

        if (! $carrito->items()->exists()) {
            return $this->redirectRoute('carrito.index', navigate: true);
        }

        // Recuperar la modalidad que quedó guardada.
        $this->tipoEntrega = $carrito->tipo_entrega ?: 'domicilio';
        
        if ($this->tipoEntrega === 'recoger_tienda') {
            $this->direccionId = null;
        
            if ($carrito->direccion_id !== null) {
                $carrito->direccion_id = null;
                $carrito->save();
            }
        
            return;
        }
        
        // En modalidad domicilio, recuperar la selección anterior.
        $direccionAnterior = $usuario->direcciones()
            ->whereKey($carrito->direccion_id)
            ->first();
        
        $direccionPredeterminada = $usuario->direcciones()
            ->where('predeterminada', true)
            ->first();
        
        $direccionInicial = $direccionAnterior
            ?? $direccionPredeterminada
            ?? $usuario->direcciones()->orderBy('id')->first();
        
        $this->direccionId = $direccionInicial?->id;
        
        // Persistir la selección inicial en la base de datos.
        $carrito->direccion_id = $this->direccionId;
        $carrito->save();
    }

    /**
     * Guardar la dirección elegida en el carrito.
     */
    public function updatedDireccionId($valor): void
    {
        if ($this->tipoEntrega !== 'domicilio') {
            return;
        }

        $usuario = Auth::user();

        $direccion = $valor
            ? $usuario->direcciones()->find((int) $valor)
            : null;

        if (! $direccion) {
            $this->direccionId = null;

            Flux::toast(
                heading: 'Dirección no válida',
                text: 'Selecciona una de tus direcciones guardadas.',
                variant: 'warning',
            );

            return;
        }

        $carrito = app(\App\Services\Shop\CarritoService::class)
            ->obtenerOCrear($usuario);

        // Asignación directa para dejar persistido el valor.
        $carrito->direccion_id = $direccion->id;
        $carrito->save();

        Flux::toast(
            heading: 'Dirección de entrega',
            text: 'La dirección seleccionada se guardó correctamente.',
            variant: 'success',
        );
    }

    public function updatedTipoEntrega($valor): void
    {
        if (! in_array($valor, ['domicilio', 'recoger_tienda'], true)) {
            $this->tipoEntrega = 'domicilio';

            return;
        }

        $usuario = Auth::user();

        $carrito = app(\App\Services\Shop\CarritoService::class)
            ->obtenerOCrear($usuario);

        $this->tipoEntrega = $valor;
        $carrito->tipo_entrega = $valor;

        if ($valor === 'recoger_tienda') {
            $this->direccionId = null;
            $carrito->direccion_id = null;
        } else {
            $direccion = $usuario->direcciones()
                ->whereKey($this->direccionId)
                ->first()
                ?? $usuario->direcciones()
                    ->where('predeterminada', true)
                    ->first()
                ?? $usuario->direcciones()->orderBy('id')->first();

            $this->direccionId = $direccion?->id;
            $carrito->direccion_id = $this->direccionId;
        }

        $carrito->save();
    }

        /**
     * Aplica un cupón al carrito persistente.
     */
    public function aplicarCupon(): void
    {
        $usuario = Auth::user();

        if (blank($this->codigoCupon)) {
            $this->mensajeCupon = 'Escribe un código de cupón.';
            $this->tipoMensajeCupon = 'error';

            return;
        }

        $carrito = app(CarritoService::class)
            ->obtenerOCrear($usuario);

        // Por ahora no se permite aplicar cupones si existen
        // tipos de artículos cuyo checkout todavía no está implementado.
        $hayTiposPendientes = $carrito->items()
            ->where('comprable_type', '!=', ProductoVariante::class)
            ->exists();

        if ($hayTiposPendientes) {
            $this->mensajeCupon =
                'Por ahora no se pueden aplicar cupones cuando el carrito contiene artículos cuyo proceso de compra está pendiente.';

            $this->tipoMensajeCupon = 'error';

            return;
        }

        $lineasCupon = $this->lineasParaCalcularCupon($carrito);

        if ($lineasCupon->isEmpty()) {
            $this->mensajeCupon =
                'No hay productos disponibles para calcular el cupón.';

            $this->tipoMensajeCupon = 'error';

            return;
        }

        $resultado = app(CalculadoraCupones::class)
            ->validarYCalcular(
                $this->codigoCupon,
                $usuario,
                $lineasCupon
            );

        if (! $resultado['valido']) {
            $this->mensajeCupon = $resultado['mensaje'];
            $this->tipoMensajeCupon = 'error';

            Flux::toast(
                heading: 'Cupón no aplicado',
                text: $resultado['mensaje'],
                variant: 'warning',
            );

            return;
        }

        // Solo sustituimos el cupón anterior si el nuevo es válido.
        $carrito->cupon_id = $resultado['cupon']->id;
        $carrito->save();

        $this->codigoCupon = $resultado['cupon']->codigo;
        $this->mensajeCupon = '';
        $this->tipoMensajeCupon = 'success';

        Flux::toast(
            heading: 'Cupón aplicado',
            text: 'El descuento se actualizó en el resumen de tu compra.',
            variant: 'success',
        );
    }

    /**
     * Quita el cupón guardado en el carrito.
     */
    public function quitarCupon(): void
    {
        $carrito = app(CarritoService::class)
            ->obtenerOCrear(Auth::user());

        $carrito->cupon_id = null;
        $carrito->save();

        $this->codigoCupon = '';
        $this->mensajeCupon = '';
        $this->tipoMensajeCupon = 'info';

        Flux::toast(
            heading: 'Cupón eliminado',
            text: 'El descuento del cupón se ha retirado de tu compra.',
            variant: 'success',
        );
    }

        /**
         * Construye las líneas con los precios que ya incluyen
         * los descuentos automáticos.
         */
    private function lineasParaCalcularCupon(
            CarritoModel $carrito
        ): Collection {
            $lineas = $carrito->items()
                ->with('comprable')
                ->get();

            $lineas->loadMorph('comprable', [
                ProductoVariante::class => [
                    'producto',
                ],
            ]);

            $calculadora = app(CalculadoraPrecios::class);

            return $lineas
                ->map(function ($linea) use ($calculadora) {
                    $variante = $linea->comprable;

                    if (
                        ! $variante instanceof ProductoVariante ||
                        ! $variante->producto
                    ) {
                        return null;
                    }

                    $precio = $calculadora->calcular(
                        $variante->producto,
                        $variante
                    );

                    return [
                        'modelo' => $variante,
                        'cantidad' => (int) $linea->cantidad,
                        'precio_unitario' => (float) $precio['precio_final'],
                    ];
                })
                ->filter()
                ->values();
    }
    
    /**
    * Crea un intento de compra y guarda una copia histórica
    * de los artículos. No crea órdenes ni modifica el inventario.
    */
    public function confirmarPedido()
    {
        $usuario = Auth::user();

        if (! $usuario) {
            return $this->redirectRoute('login');
        }

        try {
            app(CarritoService::class)->sincronizarSesion($usuario);

            $resultado = DB::transaction(function () use ($usuario) {

                /*
                |--------------------------------------------------------------------------
                | 1. Bloquear el carrito y sus artículos
                |--------------------------------------------------------------------------
                */

                $carrito = CarritoModel::query()
                    ->where('user_id', $usuario->id)
                    ->lockForUpdate()
                    ->first();

                if (! $carrito) {
                    return ['error' => 'No encontramos tu carrito.'];
                }

                $lineasCarrito = CarritoItem::query()
                    ->where('carrito_id', $carrito->id)
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get();

                if ($lineasCarrito->isEmpty()) {
                    return ['error' => 'Tu carrito está vacío.'];
                }

                $tipoEntrega = $carrito->tipo_entrega ?: 'domicilio';

                if (! in_array($tipoEntrega, ['domicilio', 'recoger_tienda'], true)) {
                    return ['error' => 'La modalidad de entrega no es válida.'];
                }

                /*
                |--------------------------------------------------------------------------
                | 2. Consultar productos sin bloquear ni descontar inventario
                |--------------------------------------------------------------------------
                |
                | Dos compradores pueden crear intentos para las mismas unidades.
                | La asignación real del stock ocurrirá después de confirmar el pago.
                */

                if ($lineasCarrito->contains(
                    fn ($linea) => $linea->comprable_type !== ProductoVariante::class
                )) {
                    return [
                        'error' => 'Tu carrito contiene artículos cuyo proceso de compra todavía no está habilitado.',
                    ];
                }

                $idsVariantes = $lineasCarrito
                    ->pluck('comprable_id')
                    ->unique()
                    ->values();

                $variantes = ProductoVariante::query()
                    ->whereIn('id', $idsVariantes)
                    ->with([
                        'producto.images',
                        'valores.attribute',
                    ])
                    ->get()
                    ->keyBy('id');

                $calculadoraPrecios = app(CalculadoraPrecios::class);
                $lineasProcesadas = collect();

                foreach ($lineasCarrito as $linea) {

                    $variante = $variantes->get((int) $linea->comprable_id);

                    if (! $variante || ! $variante->producto) {
                        return [
                            'error' => 'Uno de los productos de tu carrito ya no está disponible.',
                        ];
                    }

                    $producto = $variante->producto;
                    $cantidad = (int) $linea->cantidad;

                    if (
                        $cantidad < 1 ||
                        ! $variante->estado ||
                        ! $producto->estado
                    ) {
                        return [
                            'error' => 'Uno de los productos de tu carrito está desactivado o tiene una cantidad inválida.',
                        ];
                    }

                    // No se comprueba ni se reserva stock en esta etapa.
                    $precio = $calculadoraPrecios->calcular(
                        $producto,
                        $variante
                    );

                    $precioOriginal = round(
                        (float) $precio['precio_original'],
                        2
                    );

                    $precioFinal = round(
                        (float) $precio['precio_final'],
                        2
                    );

                    if ($precioOriginal < 0 || $precioFinal < 0) {
                        return [
                            'error' => 'No se pudo validar el precio de uno de los productos.',
                        ];
                    }

                    $imagen = $producto->images
                        ->firstWhere('principal', true)
                        ?? $producto->images->first();

                    $valores = $variante->valores
                        ->map(fn ($valor) => [
                            'atributo' => $valor->attribute?->nombre,
                            'valor' => $valor->valor,
                        ])
                        ->values()
                        ->all();

                    $textoValores = collect($valores)
                        ->pluck('valor')
                        ->filter()
                        ->implode(' / ');

                    $lineasProcesadas->push([
                        'variante' => $variante,
                        'producto' => $producto,
                        'cantidad' => $cantidad,
                        'nombre_articulo' => $producto->nombre .
                            ($textoValores !== '' ? ' - ' . $textoValores : ''),
                        'sku' => $variante->sku,
                        'imagen' => $imagen?->imagen,
                        'valores' => $valores,
                        'precio_original_unitario' => $precioOriginal,
                        'precio_unitario' => $precioFinal,
                        'subtotal_original' => round($precioOriginal * $cantidad, 2),
                        'subtotal' => round($precioFinal * $cantidad, 2),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | 3. Calcular subtotales y promociones
                |--------------------------------------------------------------------------
                */

                $subtotalOriginal = round(
                    $lineasProcesadas->sum('subtotal_original'),
                    2
                );

                $subtotal = round(
                    $lineasProcesadas->sum('subtotal'),
                    2
                );

                $descuentoPromociones = round(
                    max(0, $subtotalOriginal - $subtotal),
                    2
                );

                /*
                |--------------------------------------------------------------------------
                | 4. Validar el cupón bajo bloqueo
                |--------------------------------------------------------------------------
                */

                $cupon = null;
                $descuentoCupon = 0.0;

                $lineasParaCupon = $lineasProcesadas->map(
                    fn ($item) => [
                        'modelo' => $item['variante'],
                        'cantidad' => $item['cantidad'],
                        'precio_unitario' => $item['precio_unitario'],
                    ]
                );

                if ($carrito->cupon_id) {

                    $cupon = Cupon::query()
                        ->whereKey($carrito->cupon_id)
                        ->lockForUpdate()
                        ->first();

                    if (! $cupon) {
                        return [
                            'error' => 'El cupón de tu carrito ya no está disponible. Quítalo para continuar.',
                        ];
                    }

                    $resultadoCupon = app(CalculadoraCupones::class)
                        ->calcularCupon(
                            $cupon,
                            $usuario,
                            $lineasParaCupon
                        );

                    if (! $resultadoCupon['valido']) {
                        return [
                            'error' => 'El cupón ya no es válido: ' .
                                $resultadoCupon['mensaje'] .
                                ' Quítalo del carrito o revisa sus condiciones.',
                        ];
                    }

                    $descuentoCupon = round(
                        (float) $resultadoCupon['descuento'],
                        2
                    );
                }

                $subtotalConCupon = round(
                    max(0, $subtotal - $descuentoCupon),
                    2
                );

                /*
                |--------------------------------------------------------------------------
                | 5. Validar dirección y costo de envío
                |--------------------------------------------------------------------------
                */

                $direccion = null;

                $resultadoEnvio = [
                    'disponible' => true,
                    'zona' => null,
                    'costo_envio' => 0,
                    'mensaje' => '',
                ];

                if ($tipoEntrega === 'domicilio') {

                    $direccion = Direccion::query()
                        ->where('user_id', $usuario->id)
                        ->whereKey($carrito->direccion_id)
                        ->first();

                    if (! $direccion) {
                        return [
                            'error' => 'Selecciona una dirección válida antes de continuar.',
                        ];
                    }

                    $resultadoEnvio = app(CalculadoraEnvio::class)
                        ->calcular(
                            (string) $direccion->codigo_postal,
                            (float) $subtotalConCupon
                        );

                    if (! $resultadoEnvio['disponible']) {
                        return [
                            'error' => $resultadoEnvio['mensaje']
                                ?: 'No hay cobertura de envío para la dirección seleccionada.',
                        ];
                    }
                }

                $costoEnvio = round(
                    (float) $resultadoEnvio['costo_envio'],
                    2
                );

                $total = round(
                    $subtotalConCupon + $costoEnvio,
                    2
                );

                /*
                |--------------------------------------------------------------------------
                | 6. Guardar snapshot de entrega
                |--------------------------------------------------------------------------
                */

                $direccionSnapshot = $direccion
                    ? [
                        'alias' => $direccion->alias,
                        'destinatario' => $direccion->destinatario,
                        'telefono_contacto' => $direccion->telefono_contacto,
                        'calle' => $direccion->calle,
                        'numero_exterior' => $direccion->numero_exterior,
                        'numero_interior' => $direccion->numero_interior,
                        'codigo_postal' => $direccion->codigo_postal,
                        'colonia' => $direccion->colonia,
                        'municipio' => $direccion->municipio,
                        'estado' => $direccion->estado,
                        'pais' => $direccion->pais,
                        'referencias' => $direccion->referencias,
                    ]
                    : null;

                $zona = $resultadoEnvio['zona'] ?? null;

                /*
                |--------------------------------------------------------------------------
                | 7. Crear el intento de compra
                |--------------------------------------------------------------------------
                */

                $intento = CheckoutIntento::create([
                    'referencia_externa' => (string) Str::uuid(),
                    'user_id' => $usuario->id,
                    'cupon_id' => $cupon?->id,
                    'estado' => 'pendiente',
                    'metodo_pago' => 'mercado_pago',
                    'cupon_codigo' => $cupon?->codigo,
                    'mercadopago_idempotency_key' => (string) Str::uuid(),
                    'tipo_entrega' => $tipoEntrega,
                    'direccion_entrega' => $direccionSnapshot,
                    'zona_envio' => is_object($zona)
                        ? ($zona->nombre ?? null)
                        : null,
                    'subtotal_original' => $subtotalOriginal,
                    'descuento_promociones' => $descuentoPromociones,
                    'descuento_cupon' => $descuentoCupon,
                    'subtotal' => $subtotal,
                    'costo_envio' => $costoEnvio,
                    'total' => $total,
                    'moneda' => 'MXN',
                    'fecha_expiracion' => now()->addMinutes(
                        max(1, (int) config('tienda.reserva_minutos_orden', 30))
                    ),
                ]);

                /*
                |--------------------------------------------------------------------------
                | 8. Guardar los artículos como snapshot
                |--------------------------------------------------------------------------
                */

                foreach ($lineasProcesadas as $item) {

                    $intento->items()->create([
                        'comprable_type' => ProductoVariante::class,
                        'comprable_id' => $item['variante']->id,
                        'nombre_articulo' => $item['nombre_articulo'],
                        'sku' => $item['sku'],
                        'imagen' => $item['imagen'],
                        'datos_articulo' => [
                            'producto_id' => $item['producto']->id,
                            'categoria_id' => $item['producto']->categoria_id,
                            'valores' => $item['valores'],
                            'precio_original_unitario' =>
                                $item['precio_original_unitario'],
                            'precio_unitario' => $item['precio_unitario'],
                        ],
                        'cantidad' => $item['cantidad'],
                        'precio_original_unitario' =>
                            $item['precio_original_unitario'],
                        'precio_unitario' => $item['precio_unitario'],
                        'subtotal_original' => $item['subtotal_original'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | 9. Registrar el uso reservado del cupón
                |--------------------------------------------------------------------------
                |
                | Esto reserva únicamente el uso del cupón, nunca el inventario.
                */

                if ($cupon) {
                    CuponUso::create([
                        'cupon_id' => $cupon->id,
                        'user_id' => $usuario->id,
                        'checkout_intento_id' => $intento->id,
                        'estado' => 'reservado',
                        'usado_en' => null,
                    ]);
                }

                return [
                    'intento_id' => $intento->id,
                    'referencia' => $intento->referencia_externa,
                    'total' => $intento->total,
                ];

            }, 3);

        } catch (\Throwable $e) {

            report($e);

            Flux::toast(
                heading: 'No se pudo preparar la compra',
                text: 'Ocurrió un problema al guardar el intento. No se modificó el inventario; inténtalo nuevamente.',
                variant: 'warning',
            );

            return;
        }

        if (isset($resultado['error'])) {
            Flux::toast(
                heading: 'No se puede continuar',
                text: $resultado['error'],
                variant: 'warning',
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 10. Redirigir al checkout de Mercado Pago
        |--------------------------------------------------------------------------
        |
        | El controlador utilizará el intento recién creado para generar
        | o recuperar el checkout externo.
        |
        | No se crea una orden ni se modifica el inventario.
        */
        
        return $this->redirectRoute(
            'checkout.intento.pagar',
            [
                'intento' => $resultado['intento_id'],
            ],
            navigate: false
        );
    }

    public function render(): View
    {
        $usuario = Auth::user();

        $direcciones = $usuario->direcciones()
            ->orderByDesc('predeterminada')
            ->orderByDesc('id')
            ->get();

        $carrito = $usuario->carrito;

        $lineas = $carrito
            ? $carrito->items()
                ->with('comprable')
                ->get()
            : collect();

        // En esta etapa el checkout admite productos físicos.
        $lineas->loadMorph('comprable', [
            ProductoVariante::class => [
                'producto.images',
                'valores.attribute',
            ],
        ]);

        $calculadora = app(CalculadoraPrecios::class);

        $items = $lineas
            ->filter(fn ($linea) =>
                $linea->comprable instanceof ProductoVariante
                && $linea->comprable->producto !== null
            )
            ->map(function ($linea) use ($calculadora) {
                $variante = $linea->comprable;
                $producto = $variante->producto;
                $cantidad = (int) $linea->cantidad;

                $precio = $calculadora->calcular(
                    $producto,
                    $variante
                );

                $imagen = $producto->images
                    ->firstWhere('principal', true)
                    ?? $producto->images->first();

                return [
                    'variante' => $variante,
                    'producto' => $producto,
                    'imagen' => $imagen,
                    'cantidad' => $cantidad,
                    'precio_original' => $precio['precio_original'],
                    'precio_final' => $precio['precio_final'],
                    'ahorro' => $precio['ahorro'],
                    'descuento_aplicado' => $precio['aplicado'],
                    'subtotal_original' => round(
                        $precio['precio_original'] * $cantidad,
                        2
                    ),
                    'subtotal' => round(
                        $precio['precio_final'] * $cantidad,
                        2
                    ),
                    'disponible' =>
                    (bool) $variante->estado
                    && (bool) $producto->estado
                    && app(DisponibilidadInventarioService::class)
                        ->puedeSatisfacer($variante, $cantidad),
                ];
            })
            ->values();

        $totalOriginal = round($items->sum('subtotal_original'), 2);
        $total = round($items->sum('subtotal'), 2);

        $direccionSeleccionada = $this->tipoEntrega === 'domicilio'
        && $this->direccionId
            ? $direcciones->firstWhere('id', $this->direccionId)
            : null;

        $requiereDireccion = $lineas->contains(
            fn ($linea) =>
                $linea->comprable_type === ProductoVariante::class
        );

        $tiposPendientes = $lineas->contains(
            fn ($linea) =>
                $linea->comprable_type !== ProductoVariante::class
        );

        /*
        |--------------------------------------------------------------------------
        | Cálculo del cupón
        |--------------------------------------------------------------------------
        */

        $resultadoCupon = [
            'valido' => false,
            'aplicado' => false,
            'mensaje' => '',
            'cupon' => null,
            'codigo' => null,
            'subtotal_carrito' => $total,
            'subtotal_elegible' => 0.0,
            'descuento' => 0.0,
            'subtotal_final' => $total,
        ];

        if ($carrito) {
            $carrito->loadMissing('cupon');
        }

        if ($carrito?->cupon) {
            if ($tiposPendientes) {
                $resultadoCupon = [
                    'valido' => false,
                    'aplicado' => false,
                    'mensaje' => 'No se puede recalcular el cupón hasta habilitar el proceso de compra de todos los artículos.',
                    'cupon' => $carrito->cupon,
                    'codigo' => $carrito->cupon->codigo,
                    'subtotal_carrito' => $total,
                    'subtotal_elegible' => 0.0,
                    'descuento' => 0.0,
                    'subtotal_final' => $total,
                ];
            } else {
                $lineasParaCupon = $items->map(
                    fn ($item) => [
                        'modelo' => $item['variante'],
                        'cantidad' => $item['cantidad'],
                        'precio_unitario' => $item['precio_final'],
                    ]
                );

                $resultadoCupon = app(CalculadoraCupones::class)
                    ->calcularCupon(
                        $carrito->cupon,
                        $usuario,
                        $lineasParaCupon
                    );
            }
        }

        // Si el cupón ya no es válido, no se descuenta nada.
        $descuentoCupon = $resultadoCupon['valido']
            ? (float) $resultadoCupon['descuento']
            : 0.0;

        $totalConCupon = round(
            max(0, $total - $descuentoCupon),
            2
        );
        /*
        |--------------------------------------------------------------------------
        | Cálculo del costo de envío
        |--------------------------------------------------------------------------
        */

        $resultadoEnvio = [
            'disponible' => false,
            'zona' => null,
            'tarifa_base' => null,
            'costo_envio' => null,
            'envio_gratis' => false,
            'monto_minimo_envio_gratis' => null,
            'monto_faltante_envio_gratis' => null,
            'mensaje' => '',
        ];

        // Si hay tipos de artículos pendientes de implementar,
        // todavía no podemos determinar el total completo.
        if ($tiposPendientes) {
            $resultadoEnvio['mensaje'] =
                'El carrito contiene artículos cuyo proceso de compra todavía no está habilitado.';
        }

        // El checkout actual está preparado para productos físicos.
        elseif ($items->isEmpty()) {
            $resultadoEnvio['mensaje'] =
                'No hay productos físicos disponibles para calcular el envío.';
        }

        // Recoger en tienda no tiene costo de envío.
        elseif ($this->tipoEntrega === 'recoger_tienda') {
            $resultadoEnvio = [
                'disponible' => true,
                'zona' => null,
                'tarifa_base' => 0,
                'costo_envio' => 0,
                'envio_gratis' => false,
                'monto_minimo_envio_gratis' => null,
                'monto_faltante_envio_gratis' => null,
                'mensaje' => 'La recogida en tienda no genera costo de envío.',
            ];
        }

        // Para envío a domicilio necesitamos una dirección.
        elseif (! $direccionSeleccionada) {
            $resultadoEnvio['mensaje'] =
                'Selecciona una dirección de entrega para calcular el envío.';
        }

        // Consultar la tarifa de la zona correspondiente.
        else {
            $resultadoEnvio = app(CalculadoraEnvio::class)->calcular(
                (string) $direccionSeleccionada->codigo_postal,
                (float) $totalConCupon
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Total con envío
        |--------------------------------------------------------------------------
        |
        | Si el código postal no tiene cobertura, no mostramos un total
        | definitivo inventando el costo del envío.
        */

        $totalFinal = $resultadoEnvio['disponible']
            ? round($totalConCupon + $resultadoEnvio['costo_envio'], 2)
            : null;

            return view('livewire.shop.checkout', [
                'direcciones' => $direcciones,
                'direccionSeleccionada' => $direccionSeleccionada,
                'items' => $items,
                'totalOriginal' => $totalOriginal,
                'total' => $total,
                'ahorroTotal' => round($totalOriginal - $total, 2),
                'requiereDireccion' => $requiereDireccion,
                'tiposPendientes' => $tiposPendientes,
                'tipoEntrega' => $this->tipoEntrega,
                'resultadoEnvio' => $resultadoEnvio,
                'totalFinal' => $totalFinal,
                'resultadoCupon' => $resultadoCupon,
                'descuentoCupon' => $descuentoCupon,
                'totalConCupon' => $totalConCupon,
            ])
                ->extends('components.layouts.principal')
                ->section('contenido');
    }
}