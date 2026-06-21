<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete9Auditoria\Http\Controllers\Paquete9AuditoriaController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('paquete9auditorias', Paquete9AuditoriaController::class)->names('paquete9auditoria');
});
