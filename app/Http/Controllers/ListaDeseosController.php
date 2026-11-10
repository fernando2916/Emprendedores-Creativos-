<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ListaDeseosController extends Controller
{
    public function index()
    {
        return view('plataforma.shop.listaDeseos.index');
    }
    
    //
    public function store(Producto $producto): RedirectResponse
    {
        $usuario = Auth::user();

        $yaExiste = $usuario->listaDeseos()
            ->where('producto_id', $producto->id)
            ->exists();

        if (!$yaExiste) {
            $usuario->listaDeseos()->attach($producto->id);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Producto agregado a tu lista de deseos',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return back();
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        Auth::user()
            ->listaDeseos()
            ->detach($producto->id);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Producto eliminado de tu lista de deseos',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return back();
    }
}