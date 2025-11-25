<?php

use App\Http\Controllers\GalletaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/galleta', [GalletaController::class, 'mostrar'])->middleware('auth')->name('galleta');
Route::get('/api/mensaje', [GalletaController::class, 'obtenerMensaje'])->middleware('auth');
Route::get('/galleta', function () {
    return view('galleta');
})->middleware('auth');
