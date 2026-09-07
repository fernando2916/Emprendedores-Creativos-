<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PrivacyNoticeController;
use App\Http\Controllers\Admin\TermsAndConditionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('/aviso-privacidad', PrivacyNoticeController::class)->names('admin.privacy');
Route::resource('/terminos-condiciones', TermsAndConditionController::class)->names('admin.terminos');
