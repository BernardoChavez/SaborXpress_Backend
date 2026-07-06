<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete11ServiciosEspeciales\Http\Controllers\Paquete11ServiciosEspecialesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('paquete11serviciosespeciales', Paquete11ServiciosEspecialesController::class)->names('paquete11serviciosespeciales');
});
