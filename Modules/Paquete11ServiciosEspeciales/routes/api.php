<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete11ServiciosEspeciales\Http\Controllers\Paquete11ServiciosEspecialesController;
use Modules\Paquete11ServiciosEspeciales\Http\Controllers\CateringServicioController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('paquete11serviciosespeciales', Paquete11ServiciosEspecialesController::class)->names('paquete11serviciosespeciales');
    
    Route::apiResource('catering', CateringServicioController::class);
    Route::patch('catering/{id}/estado', [CateringServicioController::class, 'changeState']);
});
