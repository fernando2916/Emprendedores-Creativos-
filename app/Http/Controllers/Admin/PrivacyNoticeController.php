<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyNotice;
use Illuminate\Http\Request;

class PrivacyNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $privacy = PrivacyNotice::orderBy('id', 'asc')->paginate(10);

        return view('admin.legales.aviso.index', compact('privacy'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.legales.aviso.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha' => 'required|date',
            'contenido' => 'required|string',
        ], [
            'nombre.required' => 'El titulo es requerido',
            'fecha.required' => 'La fecha es requerida',
            'contenido.required' => 'El contenido es requerido',
        ]);

        $privacy = PrivacyNotice::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Aviso creado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.privacy.index', compact('privacy'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PrivacyNotice $privacyNotice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrivacyNotice $privacy)
    {
        //
        return view('admin.legales.aviso.edit', compact(
        'privacy'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrivacyNotice $privacy)
    {
        
    //
    $data = $request->validate([
    'nombre' => 'required|string|max:255',
    'fecha' => 'required|date',
    'contenido' => 'required|string',
], [
    'nombre.required' => 'El titulo es requerido',
    'fecha.required' => 'La fecha es requerida',
    'contenido.required' => 'El contenido es requerido',
]);

$privacy->update($data);

session()->flash('swal', [
    'icon' => 'success',
    'title' => 'Aviso de privacidad actualizado correctamente',
    'background' => '#120024',
    'color' => '#ffffff',
]);

return redirect()->route('admin.privacy.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrivacyNotice $privacyNotice)
    {
        //
    }
}
