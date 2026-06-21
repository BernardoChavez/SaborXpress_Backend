<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete7Comprobantes\Http\Controllers\Paquete7ComprobantesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('paquete7comprobantes', Paquete7ComprobantesController::class)->names('paquete7comprobantes');
});
