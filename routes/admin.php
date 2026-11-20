<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BoletinController;
use App\Http\Controllers\Admin\CandidatosController;
use App\Http\Controllers\Admin\CategoriaPostController;
use App\Http\Controllers\Admin\ContactoController;
use App\Http\Controllers\Admin\CotizacionDesingController;
use App\Http\Controllers\Admin\CotizacionFotoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GlosarioController;
use App\Http\Controllers\Admin\OpDesingController;
use App\Http\Controllers\Admin\PaqueteFotoController;
use App\Http\Controllers\Admin\PermisionController;
use App\Http\Controllers\Admin\PlansDesingController;
use App\Http\Controllers\Admin\PortafolioFotoController;
use App\Http\Controllers\Admin\ProyectController;
use App\Http\Controllers\Admin\RecursoController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TestimonioFotoController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VacanteController;
use App\Http\Controllers\Admin\Shop\AttributeValueController;
use App\Http\Controllers\Admin\Shop\BrandController;
use App\Http\Controllers\Admin\Shop\CategoriaController;
use App\Http\Controllers\Admin\Shop\SubCategoriaController;
use App\Http\Controllers\Admin\Shop\LicenseController;
use App\Http\Controllers\Admin\Shop\ProductoController;
use App\Http\Controllers\Admin\Shop\ProductoAttributeController;
use App\Http\Controllers\Admin\Shop\TagController;

use App\Livewire\Admin\Descuentos\Index as DescuentoIndex;
use App\Livewire\Admin\Descuentos\Formulario as FormularioDescuento;
use App\Livewire\Admin\Cupones\Index as CuponesIndex;
use App\Livewire\Admin\Cupones\Formulario as FormularioCupon;
use App\Livewire\Admin\Ordenes\Index as OrdenesIndex;
use App\Livewire\Admin\Ordenes\Detalle as DetalleOrden;
use App\Livewire\Admin\Pagos\IntentosIndex;

use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('/users', UsersController::class)->names('admin.users');

Route::resource('/roles', RoleController::class)->names('admin.roles');
Route::resource('/permissions', PermisionController::class)->names('admin.permissions');

Route::resource('/banners', BannerController::class)->names('admin.banner');
Route::resource('/boletin', BoletinController::class)->names('admin.boletin');
Route::resource('/categories', CategoriaPostController::class)->names('admin.categories');
Route::resource('/blogs', BlogController::class)->names('admin.blogs');
Route::resource('/planes', PlansDesingController::class)->names('admin.plans');
Route::resource('/cotizaciones/diseño', CotizacionDesingController::class)->names('admin.cotizacion')
    ->parameters([
        'diseño' => 'cotizacion',
    ]);
Route::resource('/proyectos', ProyectController::class)->names('admin.proyecto');
Route::resource('/opiniones', OpDesingController::class)->names('admin.opinion');
Route::resource('/testimonios', TestimonioFotoController::class)->names('admin.testimonio');
Route::resource('/sesiones', PortafolioFotoController::class)->names('admin.sesion');
Route::resource('/paquetes', PaqueteFotoController::class)->names('admin.paquete');
Route::resource('/cotizaciones/foto', CotizacionFotoController::class)->names('admin.foto');
Route::resource('/contacto', ContactoController::class)->names('admin.contacto');
Route::resource('/glosario', GlosarioController::class)->names('admin.glosario');
Route::resource('/vacantes', VacanteController::class)->names('admin.vacante');
Route::get('/candidatos/{vacante}', [CandidatosController::class, 'index'])->name('candidatos.index');
Route::resource('/recursos', RecursoController::class)->names('admin.recursos');

// Tienda
Route::resource('/marcas', BrandController::class)->names('admin.brand')
->parameters([
        'marcas' => 'brand',
    ]);;
    
Route::get('/cupones', CuponesIndex::class)
    ->name('cupon.index');

Route::get('/cupones/crear', FormularioCupon::class)
    ->name('cupon.create');

Route::get('/cupones/{cupon}/editar', FormularioCupon::class)
    ->whereNumber('cupon')
    ->name('cupon.edit');

// Gestión de pedidos
Route::get('/ordenes', OrdenesIndex::class)
        ->name('orden.index');
    
Route::get('/ordenes/{orden}', DetalleOrden::class)
        ->whereNumber('orden')
        ->name('orden.show');

// Historial y administración de pagos
Route::get('/pagos/intentos', IntentosIndex::class)
    ->name('pago.intentos.index');
        
Route::resource('/licencias', LicenseController::class)->names('admin.licencia');
Route::resource('/categorias', CategoriaController::class)->names('admin.categoria');
Route::resource('/subcategorias', SubCategoriaController::class)->names('admin.subcategoria');
Route::resource('/etiquetas', TagController::class)->names('admin.etiqueta');
Route::resource('/atributos', ProductoAttributeController::class)->names('admin.atributo');
Route::resource('/atributos/{productoAttribute}/valores', AttributeValueController::class)->parameters([
    'valores' => 'valor'
])->names('admin.atributo.valor');
Route::resource('/productos', ProductoController::class)->names('admin.producto');

Route::get('/descuento', DescuentoIndex::class)->name('descuento.index');
Route::get('/descuento/crear', FormularioDescuento::class)->name('descuento.create');
Route::get('/descuento/{descuento}/editar', FormularioDescuento::class)->name('descuento.edit');