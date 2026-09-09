<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boletin;

class BoletinController extends Controller
{
    //
    public function index()
    {
        $boletines = Boletin::orderBy('id', 'asc')->paginate(10);

        return view('admin.contacto.boletin.index', compact('boletines'));
    }

    public function destroy(Boletin $boletin)
    {
        $boletin->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Correo eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.boletin.index');
    }
}
