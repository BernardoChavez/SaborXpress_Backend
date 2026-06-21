<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete8Compras\Http\Controllers\Paquete8ComprasController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('paquete8compras', Paquete8ComprasController::class)->names('paquete8compras');
});
