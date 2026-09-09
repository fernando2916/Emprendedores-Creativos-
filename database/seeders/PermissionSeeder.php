<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'ver panel',

            'usuarios index',
            'usuarios create',
            'usuarios edit',
            'usuarios delete',

            'roles index',
            'roles create',
            'roles edit',
            'roles delete',

            'permisos index',
            'permisos create',
            'permisos edit',
            'permisos delete',

            'ver promo',

            'banner index',
            'banner create',
            'banner edit',
            'banner delete',

            'aviso index',
            'aviso create',
            'aviso edit',
            'aviso delete',

            'ver blog',
            'blog index',
            'blog create',
            'blog edit',
            'blog delete',

            'categoria post index',
            'categoria post create',
            'categoria post edit',
            'categoria post delete',

            'ver diseño',
            'cotizacion desing index',

            'plan desing index',
            'plan desing create',
            'plan desing edit',
            'plan desing delete',

            'proyectos index',
            'proyectos create',
            'proyectos edit',
            'proyectos delete',

            'opinion desing index',
            'opinion desing create',
            'opinion desing edit',
            'opinion desing delete',

            'ver foto',

            'paquete foto index',
            'paquete foto create',
            'paquete foto edit',
            'paquete foto delete',

            'cotizacion foto index',
            'cotizacion foto create',
            'cotizacion foto edit',
            'cotizacion foto delete',

            'sesiones foto index',
            'sesiones foto create',
            'sesiones foto edit',
            'sesiones foto delete',

            'testimonio foto index',
            'testimonio foto create',
            'testimonio foto edit',
            'testimonio foto delete',

            'ver empresa',
            'contacto index',
            'boletin index',

            'ver legales',
            'avisoPriv index',
            'avisoPriv create',
            'avisoPriv edit',

            'terminsCon index',
            'terminsCon create',
            'terminsCon edit',

            'vacante index',
            'vacante create',
            'vacante edit',
            'vacante delete',

            'ver glosario',
            'glosario index',
            'glosario create',
            'glosario edit',
            'glosario delete',

            'ver recursos',
            'recurso index',
            'recurso create',
            'recurso edit',
            'recurso delete',

            'ver curso',
            'curso index',
            'curso create',
            'curso edit',
            'curso delete',

            'categoria curso index',
            'categoria curso create',
            'categoria curso edit',
            'categoria curso delete',

            'subCategoria curso index',
            'subCategoria curso create',
            'subCategoria curso edit',
            'subCategoria curso delete',

            'especialidad curso index',
            'especialidad curso create',
            'especialidad curso edit',
            'especialidad curso delete',

            'ver tienda',

            'producto index',
            'producto create',
            'producto edit',
            'producto show',

        ];

        foreach ($permissions as $key => $value) {
            Permission::create(['name' => $value]);

        }
    }
}
