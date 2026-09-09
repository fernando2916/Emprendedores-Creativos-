<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BoletinController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PrivacyNoticeController;
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
