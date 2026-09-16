<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contacto;

class ContactoController extends Controller
{
    //
    public function index()
    {
        $contactos = Contacto::latest()->get();

        return view('admin.contacto.index', compact('contactos'));

    }

    public function destroy(Contacto $contacto)
    {
        $contacto->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Mensaje eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.contacto.index');
    }
}
