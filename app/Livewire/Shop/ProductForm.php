<?php

namespace App\Livewire\Shop;

use App\Models\Brand;
use App\Models\Categoria;
use App\Models\SubCategoria;
use App\Models\License;
use App\Models\Producto;
use App\Models\ProductoImage;
use App\Models\ProductoAttribute;
use App\Models\ProductoVariante;
use App\Models\AttributeValue;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Component;

class ProductForm extends Component
{
    use WithFileUploads;
    
    public ?Producto $producto = null;

    public ?int $propietario_id = null;

    public $vendedores = [];

    public $nombre = '';
    public $descripcion = '';
    public $brand_id = null;
    public $license_id = null;
    public $categoria_id = null;
    public $sub_categoria_id = null;
    public $estado = true;
    public $destacado = false;
    public $tags = [];
    public $subcategorias = [];
    

    /*
    |--------------------------------------------------------------------------
    | Atributos
    |--------------------------------------------------------------------------
    */

    // Ids de los atributos selecionados
    public array $atributosSeleccionados = [];
    
    // Valores seleccionados por attributo
    public array $valoresSeleccionados = [];
    // Variantes
    public array $variantes = [];
    public array $imagenesvariantes = [];

    public bool $editorInicializado = false;

    public $imagenes = [];

    public $imagenesExistentes = [];

    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */
    public function mount(?Producto $producto = null): void
    {
        abort_unless(
            Auth::check() && Auth::user()->hasAnyRole([
                'Super Admin',
                'Vendedor',
                'Admin',
            ]),
            403
        );

        $esSuperAdmin = Auth::user()->hasRole('Super Admin');

        // Cargar vendedores disponibles para el Super Admin.
        if ($esSuperAdmin) {
            $this->vendedores = User::role([
                'Vendedor',
                'Admin',
            ])
                ->orderBy('nombre_completo')
                ->get();
        }

        // Si es un producto nuevo.
        if (!$producto?->exists) {
            if (!$esSuperAdmin) {
                $this->propietario_id = Auth::id();
            }

            return;
        }

        // Un vendedor solamente puede editar sus propios productos.
        if (!$esSuperAdmin) {
            abort_unless(
                (int) $producto->user_id === (int) Auth::id(),
                403
            );

            $this->propietario_id = Auth::id();
        } else {
            $this->propietario_id = $producto->user_id
                ? (int) $producto->user_id
                : null;
        }

        $this->producto = $producto;

        $this->imagenesExistentes = $producto->images()
            ->orderBy('orden')
            ->get();

        // Información general.
        $this->nombre = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->brand_id = $producto->brand_id;
        $this->license_id = $producto->license_id;
        $this->categoria_id = $producto->categoria_id;
        $this->sub_categoria_id = $producto->sub_categoria_id;
        $this->estado = $producto->estado;
        $this->destacado = $producto->destacado;

        // Tags.
        $this->tags = $producto->tags()
            ->pluck('tags.id')
            ->toArray();

        // Subcategorías.
        $this->cargarSubcategorias();

        // Atributos.
        $this->atributosSeleccionados = $producto->atributos()
            ->pluck('producto_attributes.id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        // Variantes existentes.
        $variantesGuardadas = $producto->variantes()
            ->with('valores')
            ->get();

        $this->valoresSeleccionados = [];

        foreach ($variantesGuardadas as $variante) {
            foreach ($variante->valores as $valor) {
                $atributoId = (int) $valor->producto_attribute_id;
                $valorId = (int) $valor->id;

                $this->valoresSeleccionados[$atributoId][$valorId] = true;
            }
        }

        $this->generarVariantes();

        // Recuperar SKU, precio, stock y estado.
        foreach ($variantesGuardadas as $varianteGuardada) {
            $ids = $varianteGuardada->valores
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->sort()
                ->values()
                ->implode('-');

            foreach ($this->variantes as $indice => $variante) {
                $idsActuales = collect($variante['valores'])
                    ->pluck('valor_id')
                    ->map(fn ($id) => (int) $id)
                    ->sort()
                    ->values()
                    ->implode('-');

                if ($ids === $idsActuales) {
                    $this->variantes[$indice]['sku'] = $varianteGuardada->sku;
                    $this->variantes[$indice]['precio'] = $varianteGuardada->precio;
                    $this->variantes[$indice]['stock'] = $varianteGuardada->stock;
                    $this->variantes[$indice]['estado'] = $varianteGuardada->estado;

                    break;
                }
            }
        }

        $this->dispatch(
            'producto-editor-cargar',
            descripcion: $this->descripcion
        );
    }

    /*
    ----------------------------------------------------------------
    | Generar variantes
    ----------------------------------------------------------------
    */
    public function generarVariantes()
    {
        $grupos = [];

        foreach ($this->valoresSeleccionados as $atributoId => $valores) {

            if (!is_array($valores)) {
                continue;
            }

            $grupo = [];

            foreach ($valores as $valorId => $seleccionado) {

                if (!$seleccionado) {
                    continue;
                }

                $grupo[] = [
                    'atributo_id' => (int) $atributoId,
                    'valor_id' => (int) $valorId,
                ];
            }

            if (!empty($grupo)) {
                $grupos[] = $grupo;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | No hay valores seleccionados
        |--------------------------------------------------------------------------
        */

        if (empty($grupos)) {
            $this->variantes = [];
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Generar combinaciones
        |--------------------------------------------------------------------------
        */

        $combinaciones = [[]];

        foreach ($grupos as $grupo) {

            $nuevasCombinaciones = [];

            foreach ($combinaciones as $combinacion) {

                foreach ($grupo as $valor) {

                    $nuevasCombinaciones[] = [
                        ...$combinacion,
                        $valor,
                    ];
                }
            }

            $combinaciones = $nuevasCombinaciones;
        }

        /*
        |--------------------------------------------------------------------------
        | Crear variantes
        |--------------------------------------------------------------------------
        */

            $this->variantes = collect($combinaciones)
                ->map(function ($combinacion) {

                    return [
                        'id' => null,
                        
                        'valores' => $combinacion,

                        'sku' => '',

                        'precio' => '',

                        'stock' => 0,

                        'estado' => true,
                    ];
                })
                ->values()
                ->toArray();
    }
    
    /*
    ----------------------------------------------------------------
    | Cuando cambia la categoria
    ----------------------------------------------------------------
    */

    public function updatedCategoriaId()
    {
        $this->sub_categoria_id = null;

        $this->cargarSubcategorias();
    }

    public function cargarSubcategorias()
    {
        if (!$this->categoria_id) {

            $this->subcategorias = [];

            return;
        }

        $this->subcategorias = SubCategoria::where(
            'categoria_id',
            $this->categoria_id
        )
        ->orderBy('nombre')
        ->get();
    }

    /*
    ----------------------------------------------------------------
    | Cuando cambia un atribute
    ----------------------------------------------------------------
    */

    public function updatedAtributosSeleccionados()
    {
            foreach ($this->atributosSeleccionados as $atributoId) {

            if (
                !isset($this->valoresSeleccionados[$atributoId]) ||
                !is_array($this->valoresSeleccionados[$atributoId])
            ) {
                $this->valoresSeleccionados[$atributoId] = [];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Eliminar atributos que ya no están seleccionados
        |--------------------------------------------------------------------------
        */

        foreach (
            $this->valoresSeleccionados
            as $atributoId => $valores
        ) {

            if (
                !in_array(
                    (int) $atributoId,
                    array_map(
                        'intval',
                        $this->atributosSeleccionados
                    )
                )
            ) {
                unset(
                    $this->valoresSeleccionados[$atributoId]
                );
            }
        }


        $this->generarVariantes();
    }
    
    
    public function updatedValoresSeleccionados()
    {
        $this->generarVariantes();
    }

    /*
    |--------------------------------------------------------------------------
    | Guardar
    |--------------------------------------------------------------------------
    */

        public function guardar()
    {
        $datos = $this->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'descripcion' => [
                'nullable',
                'string',
            ],

            'brand_id' => [
                'nullable',
                'exists:brands,id',
            ],

            'license_id' => [
                'nullable',
                'exists:licenses,id',
            ],

            'categoria_id' => [
                'required',
                'exists:categorias,id',
            ],

            'sub_categoria_id' => [
                'required',
                'exists:sub_categorias,id',
            ],

            'estado' => [
                'boolean',
            ],

            'destacado' => [
                'boolean',
            ],

            'tags' => [
                'array',
            ],

            'tags.*' => [
                'exists:tags,id',
            ],

            'atributosSeleccionados' => 'array',

            /*
            |--------------------------------------------------------------------------
            | Variantes
            |--------------------------------------------------------------------------
            */
    
            'variantes' => [
                'array',
            ],
    
            'variantes.*.sku' => [
                'required',
                'string',
                'max:255',
            ],
    
            'variantes.*.precio' => [
                'required',
                'numeric',
                'min:0',
            ],
    
            'variantes.*.stock' => [
                'required',
                'integer',
                'min:0',
            ],
    
            'variantes.*.estado' => [
                'boolean',
            ],
    
            'variantes.*.valores' => [
                'required',
                'array',
                'min:1',
            ],
    
            'variantes.*.valores.*.atributo_id' => [
                'required',
                'exists:producto_attributes,id',
            ],
    
            'variantes.*.valores.*.valor_id' => [
                'required',
                'exists:attribute_values,id',
            ],
            
            'imagenes' => ['array'],
                'imagenes.*' => [
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:10240',
                ],
        ]);

                // Definir el propietario del producto.
        if (Auth::user()->hasRole('Super Admin')) {

            $propietarioValidado = $this->validate([
                'propietario_id' => [
                    'required',
                    'integer',
                    'exists:users,id',
                ],
            ]);

            $nuevoPropietario = User::role([
                'Vendedor',
                'Admin',
            ])->find($propietarioValidado['propietario_id']);

            if (!$nuevoPropietario) {
                $this->addError(
                    'propietario_id',
                    'Selecciona un usuario que tenga el rol de vendedor.'
                );

                return;
            }

            $datos['user_id'] = $nuevoPropietario->id;

        } elseif (Auth::user()->hasAnyRole([
            'Vendedor',
            'Admin',
        ])) {

            // El vendedor siempre será propietario de su producto.
            $datos['user_id'] = Auth::id();

        } else {
            abort(403);
        }

        $datos['slug'] = Str::slug($datos['nombre']);

        unset($datos['tags']);
        unset($datos['atributosSeleccionados']);
        unset($datos['variantes']);

        DB::transaction(function () use ($datos) {
               
            /*
            |--------------------------------------------------------------------------
            | Guardar producto
            |--------------------------------------------------------------------------
            */

            if ($this->producto?->exists) {

                $productoActual = Producto::findOrFail($this->producto->id);
            
                // Un vendedor no puede modificar productos ajenos.
                if (!Auth::user()->hasRole('Super Admin')) {
                    abort_unless(
                        (int) $productoActual->user_id === (int) Auth::id(),
                        403
                    );
                }
            
                $this->producto = $productoActual;
            
                $this->producto->update($datos);
            
            } else {
            
                $this->producto = Producto::create($datos);
            }


            /*
            |--------------------------------------------------------------------------
            | Tags
            |--------------------------------------------------------------------------
            */

            $this->producto->tags()->sync($this->tags);


            /*
            |--------------------------------------------------------------------------
            | Atributos
            |--------------------------------------------------------------------------
            */

            $this->producto->atributos()->sync(
                $this->atributosSeleccionados
            );


            /*
            |--------------------------------------------------------------------------
            | Eliminar variantes anteriores
            |--------------------------------------------------------------------------
            */

            $this->producto->variantes()->delete();


            /*
            |--------------------------------------------------------------------------
            | Crear nuevas variantes
            |--------------------------------------------------------------------------
            */

            foreach ($this->variantes as $variante) {

                $nuevaVariante = $this->producto->variantes()->create([
                    'sku' => $variante['sku'],
                    'precio' => $variante['precio'],
                    'stock' => $variante['stock'],
                    'estado' => $variante['estado'] ?? true,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Obtener IDs de los valores
                |--------------------------------------------------------------------------
                */

                $valoresIds = collect($variante['valores'])
                    ->pluck('valor_id')
                    ->map(fn ($id) => (int) $id)
                    ->toArray();


                /*
                |--------------------------------------------------------------------------
                | Relacionar valores con la variante
                |--------------------------------------------------------------------------
                */

                $nuevaVariante->valores()->sync($valoresIds);
                }
        });
        
        if (!empty($this->imagenes)) {

            $ordenActual = $this->producto->images()->max('orden') ?? 0;

            $tienePrincipal = $this->producto->images()
                ->where('principal', true)
                ->exists();

            foreach ($this->imagenes as $index => $imagen) {

                $ruta = $imagen->store(
                    'productos',
                    'public'
                );

                $this->producto->images()->create([
                    'producto_variante_id' => null,
                    'imagen' => $ruta,
                    'orden' => $ordenActual + $index + 1,
                    'principal' => !$tienePrincipal && $index === 0,
                ]);
            }
        }
 
        $titulo = $this->producto->wasRecentlyCreated
            ? 'Producto creado correctamente'
            : 'Producto actualizado correctamente';

        session()->flash('swal', [
            'icon' => 'success',
            'title' => $titulo,
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.producto.index');
    }

    public function eliminarImagenTemporal($index)
    {
        if (isset($this->imagenes[$index])) {
            unset($this->imagenes[$index]);

            $this->imagenes = array_values($this->imagenes);
        }
    }

    public function eliminarImagen($imagenId)
    {
        $imagen = ProductoImage::where('id', $imagenId)
            ->where('producto_id', $this->producto->id)
            ->first();

        if (!$imagen) {
            return;
        }

        $eraPrincipal = $imagen->principal;

        if (
            $imagen->imagen &&
            Storage::disk('public')->exists($imagen->imagen)
        ) {
            Storage::disk('public')->delete($imagen->imagen);
        }

        $imagen->delete();

        // Si eliminamos la principal,
        // asignamos como principal la primera imagen restante.
        if ($eraPrincipal) {

            $nuevaPrincipal = ProductoImage::where(
                'producto_id',
                $this->producto->id
            )
                ->orderBy('orden')
                ->first();

            if ($nuevaPrincipal) {
                $nuevaPrincipal->update([
                    'principal' => true,
                ]);
            }
        }

        $this->producto->load('images');

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Imagen eliminada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);
    }

    public function hacerPrincipal($imagenId)
    {
        $imagen = ProductoImage::where('id', $imagenId)
            ->where('producto_id', $this->producto->id)
            ->first();

        if (!$imagen) {
            return;
        }

        // Todas las imágenes dejan de ser principales
        ProductoImage::where('producto_id', $this->producto->id)
            ->update([
                'principal' => false,
            ]);

        // La seleccionada pasa a ser principal
        $imagen->update([
            'principal' => true,
        ]);

        // Recargar relación
        $this->producto->load('images');

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Imagen principal actualizada',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);
    }

    public function actualizarOrdenImagen($imagenId, $posicion)
    {
        if (!$this->producto) {
            return;
        }

        $imagen = ProductoImage::where('id', $imagenId)
            ->where('producto_id', $this->producto->id)
            ->first();

        if (!$imagen) {
            return;
        }

        $imagenes = ProductoImage::where('producto_id', $this->producto->id)
            ->orderBy('orden')
            ->get();

        // Quitar la imagen de su posición actual
        $imagenes = $imagenes
            ->reject(fn ($item) => $item->id == $imagenId)
            ->values();

        // Insertarla en la nueva posición
        $imagenes->splice($posicion, 0, [$imagen]);

        // Guardar el nuevo orden
        foreach ($imagenes as $index => $item) {
            $item->update([
                'orden' => $index + 1,
            ]);
        }

        $this->producto->load('images');
    }
   

    public function render()
    {
        return view('livewire.shop.product-form', [
        'brands' => Brand::orderBy('nombre')->get(),

        'licenses' => License::orderBy('nombre')->get(),

        'categorias' => Categoria::orderBy('nombre')->get(),

        'tagsDisponibles' => Tag::orderBy('nombre')->get(),
        
        'atributos' => ProductoAttribute::where('estado', true)
        ->with('values')
        ->orderBy('nombre')
        ->get(),
        
        ]);
    }

    public function rendered()
    {
        if (
            $this->producto?->exists &&
            !$this->editorInicializado
        ) {

            $this->editorInicializado = true;

            $this->dispatch(
                'producto-editor-cargar',
                descripcion: $this->descripcion
            );
        }
    }
}