<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete8Compras\Http\Controllers\Paquete8ComprasController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('paquete8compras', Paquete8ComprasController::class)->names('paquete8compras');
});
