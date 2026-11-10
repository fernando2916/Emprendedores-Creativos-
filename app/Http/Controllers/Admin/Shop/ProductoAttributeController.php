<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\ProductoAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductoAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $atributos = ProductoAttribute::withCount('values')->orderBy('id', 'asc')->paginate(10);

        // dd($atributos->first()->values_count);
        return view('admin.shop.atributos.index', compact('atributos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.shop.atributos.create');
        }
        
        /**
         * Store a newly created resource in storage.
        */
        public function store(Request $request)
        {
            //
            $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:producto_attributes,nombre',
            ],

            'tipo' => [
                'required',
                'in:select,color,text',
            ],

            'estado' => [
                'required',
                'boolean',
            ],
        ]);

        $datos['slug'] = Str::slug($datos['nombre']);

        $atributo = ProductoAttribute::create($datos);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Atributo creado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.atributo.edit', $atributo);
        }
        
        /**
         * Display the specified resource.
        */
        public function show(string $id)
        {
        //
        }
        
        /**
         * Show the form for editing the specified resource.
        */
        public function edit(ProductoAttribute $atributo)
        {
        //
        return view('admin.shop.atributos.edit', compact('atributo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductoAttribute $atributo)
    {
        //
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:producto_attributes,nombre,' . $atributo->id,
            ],

            'tipo' => [
                'required',
                'in:select,color,text',
            ],

            'estado' => [
                'required',
                'boolean',
            ],
        ]);

        $datos['slug'] = Str::slug($datos['nombre']);

        $atributo->update($datos);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Atributo Editado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.atributo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductoAttribute $atributo)
    {
        //
        $atributo->delete();

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Atributo eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.atributo.index');
    }
}