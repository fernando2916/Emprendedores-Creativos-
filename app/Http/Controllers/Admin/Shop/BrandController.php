<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $brands = Brand::orderBy('id', 'asc')->paginate(10);
        return view('admin.shop.marca.index', compact('brands')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.shop.marca.create'); 

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos = $request->validate([
        'nombre' => 'required|string',
        'imagen' => 'required|image|mimes:jpeg,png',
    ], [
        'nombre' => 'El nombre es requerido.',
        'imagen' => 'La imagen es requerida.',
    ]);

    if ($request->hasFile('imagen')) {

        $datos['imagen'] = Storage::put('tienda/marcas', $request->imagen);
    }

    $brand = Brand::create($datos);

    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Marca creada correctamente',
        'background' => '#120024',
        'color' => '#ffffff',
    ]);

    return redirect()->route('admin.brand.edit', compact('brand'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
        return view('admin.shop.marca.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
        $datos = $request->validate([
        'nombre' => 'required|string',
        'imagen' => 'nullable|image|mimes:jpeg,png',
    ], [
        'nombre' => 'El nombre es requerido.',
        'imagen' => 'La imagen es requerida.',
    ]);

    if ($request->hasFile('imagen')) {

        $datos['imagen'] = Storage::put('tienda/marcas', $request->imagen);
    }


    $brand->update($datos);

    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Marca actualizada correctamente',
        'background' => '#120024',
        'color' => '#ffffff',
    ]);

    return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
        $brand->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Marca eliminada correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.brand.index');
    }
}