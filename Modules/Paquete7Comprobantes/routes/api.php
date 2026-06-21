<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete7Comprobantes\Http\Controllers\Paquete7ComprobantesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('paquete7comprobantes', Paquete7ComprobantesController::class)->names('paquete7comprobantes');
});
