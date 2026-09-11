<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BoletinController;
use App\Http\Controllers\Admin\CategoriaPostController;
use App\Http\Controllers\Admin\CotizacionDesingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OpDesingController;
use App\Http\Controllers\Admin\PlansDesingController;
use App\Http\Controllers\Admin\PrivacyNoticeController;
use App\Http\Controllers\Admin\ProyectController;
use App\Http\Controllers\Admin\TerminosController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('/aviso-privacidad', PrivacyNoticeController::class)->names('admin.privacy')
    ->parameters([
        'aviso-privacidad' => 'privacy',
    ]);
Route::resource('/terminos-condiciones', TerminosController::class)->names('admin.terminos')
    ->parameters([
        'terminos-condiciones' => 'terminos',
    ]);
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
