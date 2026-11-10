<?php

namespace App\Livewire\Shop;

use App\Models\Brand;
use App\Models\Categoria;
use App\Models\SubCategoria;
use App\Models\Tag;
use App\Models\Producto;
use App\Models\License;
use Livewire\Component;
use Livewire\WithPagination;

class ProductosListado extends Component
{
    use WithPagination;
    public string $busqueda = '';

    public string $orden = 'caracteristicas';

    public array $categoriasSeleccionadas = [];

    public array $marcasSeleccionadas = [];
    
    public array $etiquetasSeleccionadas = [];
    public array $subcategoriasSeleccionadas = [];
    public array $licenciaSeleccionadas = [];


    public function updatedBusqueda()
    {
        $this->resetPage();
    }

    public function updatedOrden()
    {
        $this->resetPage();
    }

    public function updatedCategoriasSeleccionadas()
    {
        $this->resetPage();

        // Si no hay categorías seleccionadas,
        // limpiamos también las subcategorías.
        if (empty($this->categoriasSeleccionadas)) {
            $this->subcategoriasSeleccionadas = [];
    
            return;
        }

        // Obtener las subcategorías que pertenecen
        // a las categorías actualmente seleccionadas.
        $subcategoriasDisponibles = SubCategoria::whereIn(
            'categoria_id',
            $this->categoriasSeleccionadas
        )
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        // Conservar únicamente las subcategorías
        // que todavía pertenecen a las categorías seleccionadas.
        $this->subcategoriasSeleccionadas = array_values(
            array_intersect(
                array_map('intval', $this->subcategoriasSeleccionadas),
                $subcategoriasDisponibles
            )
        );
    }
    
    public function updatedSubcategoriasSeleccionadas()
    {
        $this->resetPage();
    }

    public function updatedMarcasSeleccionadas()
    {
        $this->resetPage();
    }
    public function updatedlicenciaSeleccionadas()
    {
        $this->resetPage();
    }
    
    public function updatedEtiquetasSeleccionadas()
    {
        $this->resetPage();
    }

    public function quitarCategoria($id)
    {
            $this->categoriasSeleccionadas = array_values(
            array_filter(
                $this->categoriasSeleccionadas,
                function ($categoriaId) use ($id) {
                    return (int) $categoriaId !== (int) $id;
                }
            )
        );

        $this->updatedCategoriasSeleccionadas();
    }

    public function quitarSubcategoria($id)
    {
            $this->subcategoriasSeleccionadas = array_values(
            array_filter(
                $this->subcategoriasSeleccionadas,
                function ($subcategoriaId) use ($id) {
                    return (int) $subcategoriaId !== (int) $id;
                }
            )
        );

        $this->resetPage();
    }

    public function quitarMarca($id)
    {
            $this->marcasSeleccionadas = array_values(
            array_filter(
                $this->marcasSeleccionadas,
                function ($marcaId) use ($id) {
                    return (int) $marcaId !== (int) $id;
                }
            )
        );

        $this->resetPage();
    }
    
    public function quitarLicencia($id)
    {
            $this->licenciaSeleccionadas = array_values(
            array_filter(
                $this->licenciaSeleccionadas,
                function ($licenseId) use ($id) {
                    return (int) $licenseId !== (int) $id;
                }
            )
        );

        $this->resetPage();
    }

    public function quitarEtiqueta($id)
    {
        $this->etiquetasSeleccionadas = array_values(
        array_filter(
            $this->etiquetasSeleccionadas,
            function ($etiquetaId) use ($id) {
                return (int) $etiquetaId !== (int) $id;
            }
        )
    );

    $this->resetPage();
    }


    public function limpiarFiltros()
    {
        
        $this->reset([
            'busqueda',
            'orden',
            'categoriasSeleccionadas',
            'subcategoriasSeleccionadas',
            'etiquetasSeleccionadas',
            'marcasSeleccionadas',  
            'licenciaSeleccionadas',  
        ]);

        $this->orden = 'caracteristicas';

        $this->resetPage();
    }

    public function render()
    {
        $query = Producto::query()
            ->with([
                'images',
                'categoria',
                'subCategoria',
                'tags',
                'license',
                'variantes',
                'reseñas',
            ])
            ->where('estado', true);

        /*
        |--------------------------------------------------------------------------
        | BÚSQUEDA
        |--------------------------------------------------------------------------
        */

        if (trim($this->busqueda) !== '') {

            $busqueda = trim($this->busqueda);

            $query->where(function ($q) use ($busqueda) {

                $q->where('nombre', 'like', '%' . $busqueda . '%')
                    ->orWhere('descripcion', 'like', '%' . $busqueda . '%');

            });
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORÍAS
        |--------------------------------------------------------------------------
        */

        if (!empty($this->categoriasSeleccionadas)) {

            $query->whereIn(
                'categoria_id',
                $this->categoriasSeleccionadas
            );
        }
        /*
        |--------------------------------------------------------------------------
        | CATEGORÍAS
        |--------------------------------------------------------------------------
        */

        if (!empty($this->subcategoriasSeleccionadas)) {

            $query->whereIn(
                'sub_categoria_id',
                $this->subcategoriasSeleccionadas
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MARCAS
        |--------------------------------------------------------------------------
        */
        
        if (!empty($this->marcasSeleccionadas)) {
        
        $query->whereIn(
        'brand_id',
        $this->marcasSeleccionadas
        );
        }
        /*
        |--------------------------------------------------------------------------
        | LICENCIAS
        |--------------------------------------------------------------------------
        */
        
        if (!empty($this->licenciaSeleccionadas)) {
        
        $query->whereIn(
        'license_id',
        $this->licenciaSeleccionadas
        );
        }
        
        /*
        |--------------------------------------------------------------------------
        | ETIQUETAS
        |--------------------------------------------------------------------------
        */
        
        if (!empty($this->etiquetasSeleccionadas)) {

                $query->whereHas('tags', function ($q) {
                $q->whereIn('tags.id', $this->etiquetasSeleccionadas);
            });
        }
        /*
        /*
        |--------------------------------------------------------------------------
        | ORDEN
        |--------------------------------------------------------------------------
        */

        switch ($this->orden) {

            case 'precio-menor':

                $query->withMin('variantes', 'precio')
                    ->orderBy('variantes_min_precio', 'asc');

                break;

            case 'precio-mayor':

                $query->withMax('variantes', 'precio')
                    ->orderByDesc('variantes_max_precio');

                break;

            case 'nombre':

                $query->orderBy('nombre', 'asc');

                break;

            default:

                $query->latest();

                break;
        }

        $productos = $query
            ->paginate(9);

            $categorias = Categoria::withCount([
                    'productos' => function ($query) {
                        $query->where('estado', true);
                    }
                ])
                    ->orderBy('nombre', 'asc')
                    ->get();


                $subcategorias = collect();

                if (!empty($this->categoriasSeleccionadas)) {
                    $subcategorias = SubCategoria::withCount([
                        'productos' => function ($query) {
                            $query->where('estado', true);
                        }
                    ])
                        ->whereIn(
                            'categoria_id',
                            $this->categoriasSeleccionadas
                        )
                        ->orderBy('nombre', 'asc')
                        ->get();
                }


                $marcas = Brand::withCount([
                    'products' => function ($query) {
                        $query->where('estado', true);
                    }
                ])
                    ->orderBy('nombre', 'asc')
                    ->get();
                    
                $licencias = License::withCount([
                    'products' => function ($query) {
                        $query->where('estado', true);
                    }
                ])
                    ->orderBy('nombre', 'asc')
                    ->get();


                $etiquetas = Tag::withCount([
                    'productos' => function ($query) {
                        $query->where('estado', true);
                    }
                ])
                    ->orderBy('nombre', 'asc')
                    ->get();

        return view('livewire.shop.productos-listado', [
            'productos' => $productos,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias,
            'marcas' => $marcas,
            'licencias' => $licencias,
            'etiquetas' => $etiquetas,
        ]);
    }
}