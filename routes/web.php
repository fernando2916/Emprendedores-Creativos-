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
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\TerminosController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\VacantesController;
use App\Livewire\ComentarioPost;
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
});