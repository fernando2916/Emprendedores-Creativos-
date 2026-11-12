<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Producto;

class TiendaController extends Controller
{
    //
    public function index()
{
    $banners = Banner::all();

    $marcas = Brand::latest()->get();

    return view('plataforma.shop.index', [
        'banners' => $banners,
        'marcas' => $marcas,
    ]);
}

public function show(Producto $producto)
{
    $producto->load([
        'images',
        'brand',
        'license',
        'categoria',
        'tags',
        'subCategoria',
        'atributos',
        'variantes.valores.attribute',

        // Reseñas publicadas
        'reseñasPublicadas:id,producto_id,calificacion',
    ]);

    // IDs de las etiquetas del producto actual.
    $tagsIds = $producto->tags->modelKeys();

    // Buscar productos que compartan al menos un criterio.
    $consultaRelacionados = Producto::query()
        ->where('estado', true)
        ->where('id', '!=', $producto->id)
        ->where(function ($query) use ($producto, $tagsIds) {

            if ($producto->sub_categoria_id) {
                $query->orWhere(
                    'sub_categoria_id',
                    $producto->sub_categoria_id
                );
            }

            if ($producto->categoria_id) {
                $query->orWhere(
                    'categoria_id',
                    $producto->categoria_id
                );
            }

            if ($producto->brand_id) {
                $query->orWhere(
                    'brand_id',
                    $producto->brand_id
                );
            }

            if ($producto->license_id) {
                $query->orWhere(
                    'license_id',
                    $producto->license_id
                );
            }

            if (!empty($tagsIds)) {
                $query->orWhereHas('tags', function ($tags) use ($tagsIds) {
                    $tags->whereIn('tags.id', $tagsIds);
                });
            }
        })
        ->with([
            'images',
            'categoria',
            'subCategoria',
            'tags',
            'variantes' => function ($query) {
                $query->where('estado', true);
            },
            'reseñasPublicadas',
        ]);

    // Contar las etiquetas que comparte cada producto.
    if (!empty($tagsIds)) {
        $consultaRelacionados->withCount([
            'tags as tags_compartidos_count' => function ($query) use ($tagsIds) {
                $query->whereIn('tags.id', $tagsIds);
            },
        ]);
    }

    // Priorizar las coincidencias más relevantes.
    $consultaRelacionados->orderByRaw(
        '
        (CASE WHEN sub_categoria_id = ? THEN 100 ELSE 0 END) +
        (CASE WHEN categoria_id = ? THEN 50 ELSE 0 END) +
        (CASE WHEN brand_id = ? THEN 30 ELSE 0 END) +
        (CASE WHEN license_id = ? THEN 20 ELSE 0 END)
        DESC
        ',
        [
            $producto->sub_categoria_id,
            $producto->categoria_id,
            $producto->brand_id,
            $producto->license_id,
        ]
    );

    if (!empty($tagsIds)) {
        $consultaRelacionados->orderByDesc('tags_compartidos_count');
    }

    $productosRelacionados = $consultaRelacionados
        ->limit(8)
        ->get();

    return view('plataforma.shop.show', compact(
        'producto',
        'productosRelacionados'
    ));
}

    public function carrito()
    {
        return view('plataforma.shop.carrito.index');
    }
}