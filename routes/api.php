<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalletaController;
use App\Http\Controllers\FortuneController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\StatsController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/mensaje', [GalletaController::class, 'obtenerMensaje']);

    Route::get('/user/history', [HistoryController::class, 'userHistory']);
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/fortunes', [FortuneController::class, 'index']);
    Route::post('/fortunes', [FortuneController::class, 'store']);
    Route::put('/fortunes/{id}', [FortuneController::class, 'update']);
    Route::delete('/fortunes/{id}', [FortuneController::class, 'destroy']);

    Route::get('/stats', [StatsController::class, 'index']);

    Route::get('/history', [HistoryController::class, 'globalHistory']);
});
