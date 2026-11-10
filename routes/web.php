<?php

use App\Http\Controllers\AvisoPrivacidadController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\DiseñoController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\GlosarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Profile\FotoPerfilController;
use App\Http\Controllers\Profile\MetodosPagoController;
use App\Http\Controllers\Profile\PerfilController;
use App\Http\Controllers\Profile\PreferenciasNotifiController;
use App\Http\Controllers\Profile\SeguridadCuentaController;
use App\Http\Controllers\Profile\SuscripcionesController;
use App\Http\Controllers\ListaDeseosController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\TerminosController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\Shop\PedidoController;
use App\Http\Controllers\Shop\MisPedidosController;
use App\Http\Controllers\Shop\NotificacionController;
use App\Http\Controllers\VacantesController;
use App\Livewire\ComentarioPost;
// use App\Livewire\Shop\Carrito;
use App\Livewire\Shop\Checkout;
use App\Livewire\Shop\Direcciones;
use App\Livewire\Shop\Notificaciones;
use App\Livewire\Admin\Envios\ZonasIndex;
use App\Livewire\Admin\Envios\FormularioZona;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/diseño-grafico', [DiseñoController::class, 'index'])->name('diseno.index');
Route::get('/proyectos/{proyect:slug}', [DiseñoController::class, 'show'])->name('diseno.show');
Route::get('/proyectos', [ProyectosController::class, 'index'])->name('proyectos.index');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/comentarios', ComentarioPost::class)->name('comentarios.store');
Route::get('/fotografia', [FotoController::class, 'index'])->name('fotografia.index');
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');

Route::get('/glosario', [GlosarioController::class, 'index'])->name('glosario.index');
Route::get('/aviso-de-privacidad', [AvisoPrivacidadController::class, 'index'])->name('aviso.index');
Route::get('/terminos-y-condiciones', [TerminosController::class, 'index'])->name('terminos.index');

Route::get('/vacantes', [VacantesController::class, 'index'])->name('vacantes.index');
Route::get('/vacantes/{vacante:identificador}', [VacantesController::class, 'show'])->name('vacante.show');
Route::post('/vacantes/{vacante:id}', [VacantesController::class, 'store'])->name('vacante.store');
Route::get('/user/{user:username}', [PerfilController::class, 'perfil'])->name('perfil.perfil');
Route::get('/recursos', [RecursoController::class, 'index'])->name('recursos.index');
Route::get('/recursos/{id}/descargar', [RecursoController::class, 'download'])->name('recursos.download');

// Tienda
Route::get('/tienda', [TiendaController::class, 'index'])->name('tienda.index');

Route::get('/carrito', [TiendaController::class, 'carrito'])->name('carrito.index');

Route::get('/envios/zonas', ZonasIndex::class)->name('zona-envio.index');
Route::get('/envios/zonas/crear', FormularioZona::class)
    ->name('zona-envio.create');

Route::get('/envios/zonas/{zona}/editar', FormularioZona::class)
    ->whereNumber('zona')
    ->name('zona-envio.edit');

Route::get('/tienda/producto/{producto:slug}', [TiendaController::class, 'show'])->name('tienda.show');



// Perfil
Route::middleware('auth')->group(function () {
    Route::get('/{user:username}/mi-perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/{user:username}/mi-perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/{user:username}/editar-foto', [FotoPerfilController::class, 'index'])->name('foto.edit');
    Route::put('/{user:username}/editar-foto', [FotoPerfilController::class, 'update'])->name('foto.update');
    Route::get('/{user:username}/editar-cuenta', [SeguridadCuentaController::class, 'index'])->name('cuenta.edit');
    Route::put('/{user:username}/editar-cuenta', [SeguridadCuentaController::class, 'update'])->name('cuenta.update');
    Route::get('/{user:username}/suscripciones', [SuscripcionesController::class, 'index'])->name('suscripciones.edit');
    Route::get('/{user:username}/editar-metodos-de-pago', [MetodosPagoController::class, 'index'])->name('metodos.edit');
    Route::get('/{user:username}/editar-preferencias-notificaciones', [PreferenciasNotifiController::class, 'index'])->name('notify.index');
    Route::get('/{user:username}/cerrar-cuenta', [PerfilController::class, 'delete'])->name('clean.delete');

    // tienda
    Route::get('/lista-deseos', [ListaDeseosController::class, 'index'])->name('lista-deseos.index');

    Route::post('/lista-deseos/{producto}', [ListaDeseosController::class, 'store'])->name('lista-deseos.store');
    
    Route::delete('/lista-deseos/{producto}', [ListaDeseosController::class, 'destroy'])->name('lista-deseos.destroy');
    Route::get('/mis-direcciones', Direcciones::class)->name('direcciones.index');
    Route::get('/checkout', Checkout::class)->name('checkout.index');
    
    Route::get('/pedido/{orden}', [PedidoController::class, 'show'])->whereNumber('orden')->name('pedido.confirmacion');
    Route::post('/pedido/{orden}/cancelar', [PedidoController::class, 'cancelar',])
            ->whereNumber('orden')
            ->name('pedido.cancelar');
    Route::get('/mis-compras', [MisPedidosController::class, 'show'])
            ->name('mis-pedidos.index');
    Route::get('/notificaciones', Notificaciones::class)
            ->name('notificaciones.index');
    Route::get('/notificaciones/{notification}/abrir', [NotificacionController::class, 'abrir'])->name('notificaciones.abrir');
});