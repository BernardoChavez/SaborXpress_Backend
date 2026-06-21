<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete9Auditoria\Http\Controllers\Paquete9AuditoriaController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('paquete9auditorias', Paquete9AuditoriaController::class)->names('paquete9auditoria');
});
