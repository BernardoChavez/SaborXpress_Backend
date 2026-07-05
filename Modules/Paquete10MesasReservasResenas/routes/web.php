<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete10MesasReservasResenas\Http\Controllers\Paquete10MesasReservasResenasController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('paquete10mesasreservasresenas', Paquete10MesasReservasResenasController::class)->names('paquete10mesasreservasresenas');
});
