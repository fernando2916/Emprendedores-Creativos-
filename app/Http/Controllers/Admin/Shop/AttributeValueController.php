<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\AttributeValue;
use App\Models\ProductoAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductoAttribute $productoAttribute)
    {
        //
        $valores = $productoAttribute->values()->orderBy('id', 'asc')->paginate(15);
        
        return view('admin.shop.atributos.valores.index', compact('valores','productoAttribute' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductoAttribute $productoAttribute)
    {
        //
        return view('admin.shop.atributos.valores.create', compact('productoAttribute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ProductoAttribute $productoAttribute)
    {
        //
        $datos = $request->validate([
        'valor' => [
            'required',
            'string',
            'max:255',
        ],

        'codigo' => [
            'nullable',
            'string',
            'max:20',
        ],
    ]);

    $datos['producto_attribute_id'] = $productoAttribute->id;
    $datos['slug'] = Str::slug($datos['valor']);

    $existe = AttributeValue::where(
            'producto_attribute_id',
            $productoAttribute->id
        )
        ->where('slug', $datos['slug'])
        ->exists();

    if ($existe) {
        return back()
            ->withInput()
            ->withErrors([
                'valor' => 'Este valor ya existe para este atributo.',
            ]);
    }

    $productoAttribute->values()->create($datos);

    // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Valor creada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.atributo.valor.index', $productoAttribute);
        
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
    public function edit( ProductoAttribute $productoAttribute, AttributeValue $valor)
    {
        //
        return view(
            'admin.shop.atributos.valores.edit',
            compact('productoAttribute', 'valor')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductoAttribute $productoAttribute, AttributeValue $valor)
    {
        //
        $datos = $request->validate([
            'valor' => [
                'required',
                'string',
                'max:255',
            ],

            'codigo' => [
                'nullable',
                'string',
                'max:20',
            ],
        ]);

        $datos['slug'] = Str::slug($datos['valor']);

        $existe = AttributeValue::where(
                'producto_attribute_id',
                $productoAttribute->id
            )
            ->where('slug', $datos['slug'])
            ->where('id', '!=', $valor->id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'valor' => 'Este valor ya existe para este atributo.',
                ]);
        }

        $valor->update($datos);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Valor editado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.atributo.valor.index', $productoAttribute);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductoAttribute $productoAttribute, AttributeValue $valor)
    {
        //
        $valor->delete();
        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Valor eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.atributo.valor.index', $productoAttribute);
    }
}