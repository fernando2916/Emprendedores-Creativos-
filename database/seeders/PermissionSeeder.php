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
            'blog show',
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
            'marca index',    
            'marca create',
            'marca edit',
            'marca delete',
            
            'ver carrito',
            'descuento index',    
            'descuento create',
            'descuento edit',
            'descuento desactivar',
            'descuento delete',

            'zona index',
            'zona create',
            'zona edit',
            'zona desactivar',
            'zona delete',
            
            'cupon index',
            'cupon create',
            'cupon edit',
            'cupon desactivar',
            'cupon delete',
            
            
            'categoria index',    
            'categoria create',
            'categoria edit',
            'categoria delete',
            
            'orden index',    
            'orden create',
            'orden edit',
            'orden show',
            'orden delete',
            
            'subcategoria index',    
            'subcategoria create',
            'subcategoria edit',
            'subcategoria delete',
            
            'tag index',    
            'tag create',
            'tag edit',
            'tag delete',
            
            'atributos index',    
            'atributos create',
            'atributos edit',
            'atributos show',
            'atributos delete',
            
            'valorAtributo index',    
            'valorAtributo create',
            'valorAtributo edit',
            'valorAtributo delete',
            
            'producto index',    
            'producto create',
            'producto edit',
            'producto delete',
            
            'productoatribute index',    
            'productoatribute create',
            'productoatribute edit',
            'productoatribute delete',
            
            'productimage index',    
            'productimage create',
            'productimage edit',
            'productimage delete',
            
            'productovariante index',    
            'productovariante create',
            'productovariante edit',
            'productovariante delete',
            
            'varianteatribute index',    
            'varianteatribute create',
            'varianteatribute edit',
            'varianteatribute delete',
            
            'licencia index',    
            'licencia create',
            'licencia edit',
            'licencia delete',
            

        ];

        foreach ($permissions as $key => $value) {
            Permission::create(['name' => $value]);

        }
    }
}