<?php

namespace App\Livewire\Shop;

use App\Models\Direccion;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Flux\Flux;


class Direcciones extends Component
{
    public ?int $direccionId = null;

    public ?string $alias = null;

    public string $destinatario = '';

    public string $telefono_contacto = '';

    public string $calle = '';

    public string $numero_exterior = '';

    public ?string $numero_interior = null;

    public string $codigo_postal = '';

    public string $colonia = '';

    public string $municipio = '';

    public string $estado = '';

    public string $pais = 'México';

    public ?string $referencias = null;

    public bool $predeterminada = false;

    public bool $mostrarFormulario = false;

    public array $coloniasDisponibles = [];

    public string $mensajeCodigoPostal = '';

    /**
     * Abrir formulario de creación.
     */
    public function nueva(): void
    {
        $this->limpiarFormulario();

        $this->predeterminada = ! Auth::user()
            ->direcciones()
            ->exists();

        $this->mostrarFormulario = true;
    }

    /**
     * Cargar una dirección para editar.
     */
    public function editar(int $id): void
    {
        $direccion = Auth::user()
            ->direcciones()
            ->findOrFail($id);

        $this->limpiarFormulario();

        $this->direccionId = $direccion->id;
        $this->alias = $direccion->alias;
        $this->destinatario = $direccion->destinatario;
        $this->telefono_contacto = $direccion->telefono_contacto;
        $this->calle = $direccion->calle;
        $this->numero_exterior = $direccion->numero_exterior;
        $this->numero_interior = $direccion->numero_interior;
        $this->codigo_postal = $direccion->codigo_postal;
        $this->colonia = $direccion->colonia;
        $this->municipio = $direccion->municipio;
        $this->estado = $direccion->estado;
        $this->pais = $direccion->pais;
        $this->referencias = $direccion->referencias;
        $this->predeterminada = $direccion->predeterminada;

        $this->mostrarFormulario = true;
    }

    
    /**
     * Consultar las colonias cuando se completa el código postal.
     */
    public function updatedCodigoPostal(): void
    {
            $this->codigo_postal = preg_replace(
            '/\D/',
            '',
            $this->codigo_postal
        ) ?? '';

        $this->coloniasDisponibles = [];
        $this->mensajeCodigoPostal = '';

        if (strlen($this->codigo_postal) !== 5) {
            return;
        }

        $codigo = $this->codigo_postal;

        // Limpiar los datos de la búsqueda anterior.
        $this->colonia = '';
        $this->municipio = '';
        $this->estado = '';

        $token = config('services.postalia.token');

        if (! is_string($token) || trim($token) === '') {
            $this->mensajeCodigoPostal =
                'La consulta postal no está configurada. '
                . 'Puedes capturar los datos de la localidad manualmente.';

            return;
        }

        try {
            $baseUrl = rtrim(
                config('services.postalia.base_url'),
                '/'
            );

            /*
            * Guardamos la respuesta durante siete días para no
            * consumir una petición por cada visita o modificación.
            */
            $payload = Cache::remember(
                "postalia:codigo-postal:{$codigo}",
                now()->addDays(7),
                function () use ($baseUrl, $token, $codigo) {
                    $respuesta = Http::acceptJson()
                        ->withToken($token)
                        ->connectTimeout(3)
                        ->timeout(8)
                        ->get(
                            $baseUrl . '/' . rawurlencode($codigo)
                        );

                    $respuesta->throw();

                    return $respuesta->json();
                }
            );

            // Admitimos tanto una respuesta directa como una envuelta en data.
            $datos = $payload['data'] ?? $payload;

            $codigoRespuesta = preg_replace(
                '/\D/',
                '',
                (string) ($datos['codigo_postal'] ?? $codigo)
            );

            if ($codigoRespuesta !== $codigo) {
                $this->mensajeCodigoPostal =
                    'La respuesta del servicio no coincide con el código postal. '
                    . 'Puedes introducir la localidad manualmente.';

                return;
            }

            $municipioGeneral = (string) ($datos['municipio'] ?? '');
            $estadoGeneral = (string) ($datos['estado'] ?? '');

            $colonias = $datos['colonias']
                ?? $datos['asentamientos']
                ?? [];

            /*
            * Postalia documenta colonias como una lista de nombres.
            * También admitimos objetos por si el proveedor incorpora
            * información adicional en la respuesta.
            */
            $this->coloniasDisponibles = collect($colonias)
                ->map(function ($colonia) use (
                    $municipioGeneral,
                    $estadoGeneral
                ) {
                    if (is_string($colonia)) {
                        return [
                            'nombre' => trim($colonia),
                            'tipo' => '',
                            'municipio' => $municipioGeneral,
                            'estado' => $estadoGeneral,
                        ];
                    }

                    if (! is_array($colonia)) {
                        return null;
                    }

                    return [
                        'nombre' => trim((string) (
                            $colonia['nombre']
                            ?? $colonia['colonia']
                            ?? $colonia['asentamiento']
                            ?? ''
                        )),

                        'tipo' => (string) (
                            $colonia['tipo']
                            ?? $colonia['tipo_asentamiento']
                            ?? ''
                        ),

                        'municipio' => (string) (
                            $colonia['municipio']
                            ?? $municipioGeneral
                        ),

                        'estado' => (string) (
                            $colonia['estado']
                            ?? $estadoGeneral
                        ),
                    ];
                })
                ->filter(fn ($colonia) =>
                    is_array($colonia)
                    && $colonia['nombre'] !== ''
                )
                ->unique(fn ($colonia) => mb_strtolower(
                    $colonia['nombre'] . '|'
                    . $colonia['municipio'] . '|'
                    . $colonia['estado']
                ))
                ->values()
                ->all();

            if (count($this->coloniasDisponibles) === 0) {
                $this->mensajeCodigoPostal =
                    'No encontramos colonias para este código postal. '
                    . 'Puedes capturar los datos de la localidad manualmente.';

                return;
            }

            $primeraColonia = $this->coloniasDisponibles[0];

            $this->municipio = $primeraColonia['municipio'];
            $this->estado = $primeraColonia['estado'];

            if (count($this->coloniasDisponibles) === 1) {
                $this->colonia = $primeraColonia['nombre'];
            } else {
                $this->mensajeCodigoPostal =
                    'Selecciona la colonia correspondiente a tu dirección.';
            }
        } catch (\Illuminate\Http\Client\RequestException $e) {
            report($e);

            $codigoHttp = $e->response->status();

            $this->mensajeCodigoPostal = match ($codigoHttp) {
                401, 403 =>
                    'El servicio postal rechazó la autenticación. '
                    . 'Verifica el token de Postalia.',

                429 =>
                    'Se alcanzó el límite de consultas postales. '
                    . 'Inténtalo más tarde o captura los datos manualmente.',

                404 =>
                    'No se encontró información para ese código postal.',

                default =>
                    'No fue posible consultar el catálogo postal. '
                    . 'Puedes introducir los datos manualmente.',
            };
        } catch (\Throwable $e) {
            report($e);

            $this->mensajeCodigoPostal =
                'No fue posible consultar el catálogo postal en este momento. '
                . 'Puedes introducir los datos manualmente.';
        }
    }

    /**
     * Actualizar municipio y estado al seleccionar colonia.
     */
    public function updatedColonia(): void
    {
        $seleccionada = collect($this->coloniasDisponibles)
            ->first(
                fn ($registro) => $registro['nombre'] === $this->colonia
            );

        if (! $seleccionada) {
            return;
        }

        $this->municipio = $seleccionada['municipio'];
        $this->estado = $seleccionada['estado'];

        $this->mensajeCodigoPostal = '';
    }

    /**
     * Guardar una dirección nueva o actualizar una existente.
     */
    public function guardar(): void
    {
        $datos = $this->validate([
            'alias' => ['nullable', 'string', 'max:60'],

            'destinatario' => ['required', 'string', 'max:150'],

            'telefono_contacto' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\s().-]{10,20}$/',
            ],

            'calle' => ['required', 'string', 'max:150'],

            'numero_exterior' => ['required', 'string', 'max:30'],

            'numero_interior' => ['nullable', 'string', 'max:30'],

            'codigo_postal' => [
                'required',
                'regex:/^\d{5}$/',
            ],

            'colonia' => ['required', 'string', 'max:150'],

            'municipio' => ['required', 'string', 'max:150'],

            'estado' => ['required', 'string', 'max:100'],

            'pais' => ['required', 'string', 'max:60'],

            'referencias' => ['nullable', 'string', 'max:2000'],

            'predeterminada' => ['boolean'],
        ], [
            'destinatario.required' => 'Ingresa el nombre de quien recibirá el paquete.',
            'telefono_contacto.required' => 'Ingresa un teléfono de contacto.',
            'telefono_contacto.regex' => 'Ingresa un teléfono válido.',
            'calle.required' => 'Ingresa la calle.',
            'numero_exterior.required' => 'Ingresa el número exterior.',
            'codigo_postal.required' => 'Ingresa el código postal.',
            'codigo_postal.regex' => 'El código postal debe tener cinco dígitos.',
            'colonia.required' => 'Selecciona o escribe la colonia.',
            'municipio.required' => 'Ingresa el municipio o alcaldía.',
            'estado.required' => 'Ingresa el estado.',
        ]);

        $usuario = Auth::user();
        $id = $this->direccionId;
        $esEdicion = $id !== null;

        DB::transaction(function () use (
            $usuario,
            $datos,
            $id
        ) {
            $direccion = $id
                ? $usuario->direcciones()->findOrFail($id)
                : new Direccion();

            $debeSerPredeterminada =
                (bool) $datos['predeterminada']
                || ! $usuario->direcciones()->exists();

            if ($debeSerPredeterminada) {
                $usuario->direcciones()->update([
                    'predeterminada' => false,
                ]);
            }

            $datos['predeterminada'] = $debeSerPredeterminada;

            $direccion->fill($datos);

            $usuario->direcciones()->save($direccion);
        });

        $this->limpiarFormulario();

        Flux::toast(
            heading: 'Mis direcciones',
            text: $esEdicion
                ? 'Dirección actualizada correctamente.'
                : 'Dirección guardada correctamente.',
            variant: 'success',
        );
    }

    /**
     * Marcar una dirección como predeterminada.
     */
    public function marcarPredeterminada(int $id): void
    {
        $usuario = Auth::user();

        DB::transaction(function () use ($usuario, $id) {
            $direccion = $usuario->direcciones()->findOrFail($id);

            $usuario->direcciones()->update([
                'predeterminada' => false,
            ]);

            $direccion->update([
                'predeterminada' => true,
            ]);
        });

        Flux::toast(
            heading: 'Mis direcciones',
            text: 'Dirección predeterminada actualizada.',
            variant: 'success',
        );
    }

    /**
     * Eliminar una dirección propia.
     */
    public function eliminar(int $id): void
    {
        $usuario = Auth::user();

        $direccion = $usuario->direcciones()->findOrFail($id);
        $eraPredeterminada = $direccion->predeterminada;

        DB::transaction(function () use (
            $usuario,
            $direccion,
            $eraPredeterminada
        ) {
            $direccion->delete();

            if ($eraPredeterminada) {
                $siguiente = $usuario->direcciones()
                    ->orderBy('id')
                    ->first();

                $siguiente?->update([
                    'predeterminada' => true,
                ]);
            }
        });

        Flux::toast(
            heading: 'Mis direcciones',
            text: 'Dirección eliminada correctamente.',
            variant: 'success',
        );
    }

    public function cancelar(): void
    {
        $this->limpiarFormulario();
    }

    private function limpiarFormulario(): void
    {
        $this->reset([
            'direccionId',
            'alias',
            'destinatario',
            'telefono_contacto',
            'calle',
            'numero_exterior',
            'numero_interior',
            'codigo_postal',
            'colonia',
            'municipio',
            'estado',
            'referencias',
            'predeterminada',
            'coloniasDisponibles',
            'mensajeCodigoPostal',
        ]);

        $this->pais = 'México';
        $this->mostrarFormulario = false;

        $this->resetValidation();
    }

    
    public function render(): View
    {
        return view('livewire.shop.direcciones', [
            'direcciones' => Auth::user()
                ->direcciones()
                ->orderByDesc('predeterminada')
                ->orderByDesc('id')
                ->get(),
        ])
            ->extends('components.layouts.principal')
            ->section('contenido');
    }
    
}