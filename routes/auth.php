<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\NewCodeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::get('/crear-cuenta', [RegisterController::class, 'index'])->name('register');
Route::post('/crear-cuenta', [RegisterController::class, 'store']);

Route::get('/activar-cuenta/{user:verification_id}', [VerifyEmailController::class, 'show'])->name('verify');
Route::post('/activar-cuenta/{user:verification_id}', [VerifyEmailController::class, 'verify']);


Route::get('/reset-code/{user:verification_id}', [NewCodeController::class, 'index'])->name('new.code');
Route::post('/reset-code/{user:verification_id}', [NewCodeController::class, 'store']);

Route::get('/ingresar', [LoginController::class, 'index'])->name('login');
Route::post('/ingresar', [LoginController::class, 'store']);

Route::get('/restablecer-contraseña', [ResetPasswordController::class, 'index'])->name('reset');
Route::post('/restablecer-contraseña', [ResetPasswordController::class, 'store']);

Route::get('/nueva-contraseña/{user:verification_id}', [ConfirmPasswordController::class, 'index'])->name('password.confirm');
Route::post('/nueva-contraseña/{user:verification_id}', [ConfirmPasswordController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
