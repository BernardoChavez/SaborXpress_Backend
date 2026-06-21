<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete6Produccion\Http\Controllers\Paquete6ProduccionController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('paquete6produccions', Paquete6ProduccionController::class)->names('paquete6produccion');
});
