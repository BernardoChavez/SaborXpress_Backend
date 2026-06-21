<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete6Produccion\Http\Controllers\Paquete6ProduccionController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('paquete6produccions', Paquete6ProduccionController::class)->names('paquete6produccion');
});
