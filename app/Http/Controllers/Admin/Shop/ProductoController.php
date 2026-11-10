<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $productos = Producto::with([
        'brand',
        'license',
        'categoria',
        'subCategoria',
        ])->orderBy('id', 'asc')->paginate(10);

        return view('admin.shop.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.shop.productos.create');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //

        return view('admin.shop.productos.edit', compact('producto'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
        $producto->delete();

        // mensaje flash
    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Producto Eliminado correctamente',
        'background' => '#120024',
        'color' => '#ffffff',
    ]);

    return redirect()->route('admin.producto.index');
        
        
    }
}