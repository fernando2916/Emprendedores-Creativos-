<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();

        return view('admin.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'string',
            'descripcion' => 'string',
            'banner' => 'nullable|image|mimes:jpeg,png',
            'enlace' => 'required|string',
        ], [
            'titulo.string' => 'El titulo es requerido.',
            'descripcion.string' => 'La descripción es requerida.',
            'banner.required' => 'La imagen es requerida.',
            'enlace.required' => 'El enlace es requerido.',
        ]);

        if ($request->hasFile('banner')) {

            $data['banner'] = Storage::put('banners', $request->banner);
        }

        $banner = Banner::create($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Banner creado correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.banner.edit', compact('banner'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        //
        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        //
        $data = $request->validate([
            'titulo' => 'string',
            'descripcion' => 'string',
            'banner' => 'image|mimes:jpeg,png',
            'enlace' => 'string',
        ], [
            'titulo.required' => 'El titulo es requerido.',
            'descripcion.required' => 'La descripción es requerida.',
            'banner.required' => 'La imagen es requerida.',
            'enlace.required' => 'El enlace es requerido.',
        ]);

        if ($request->hasFile('banner')) {

            if ($banner->banner) {
                Storage::delete($banner->banner);
            }

            $data['banner'] = Storage::put('banners', $request->banner);
        }

        $banner->update($data);

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Banner actualizado correctamente.',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        //
        $banner->delete();

        // mensaje flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Banner Eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.banner.index');
    }
}
