<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete10MesasReservasResenas\Http\Controllers\ZonaController;
use Modules\Paquete10MesasReservasResenas\Http\Controllers\MesaController;
use Modules\Paquete10MesasReservasResenas\Http\Controllers\ReservaController;
use Modules\Paquete10MesasReservasResenas\Http\Controllers\ResenaController;

Route::group([], function () {
    Route::post('resenas', [ResenaController::class, 'store']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('zonas', ZonaController::class);
    Route::apiResource('mesas', MesaController::class);
    Route::apiResource('reservas', ReservaController::class);
    Route::apiResource('resenas', ResenaController::class)->except(['store']);
});
