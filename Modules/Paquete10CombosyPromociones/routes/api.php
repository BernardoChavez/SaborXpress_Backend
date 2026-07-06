<?php

use Illuminate\Support\Facades\Route;
use Modules\Paquete10CombosyPromociones\Http\Controllers\ComboController;
use Modules\Paquete10CombosyPromociones\Http\Controllers\PromocionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Agrupamos las rutas bajo el prefijo 'marketing'
Route::prefix('marketing')->group(function() {
    
    // Rutas para Combos
    Route::get('/combos', [ComboController::class, 'index']);
    Route::post('/combos', [ComboController::class, 'store']);
    Route::get('/combos/{id}', [ComboController::class, 'show']);
    Route::put('/combos/{id}', [ComboController::class, 'update']);
    Route::delete('/combos/{id}', [ComboController::class, 'destroy']);

    // Rutas para Promociones
    Route::get('/promociones', [PromocionController::class, 'index']);
    Route::post('/promociones', [PromocionController::class, 'store']);
    Route::get('/promociones/{id}', [PromocionController::class, 'show']);
    Route::put('/promociones/{id}', [PromocionController::class, 'update']);
    Route::delete('/promociones/{id}', [PromocionController::class, 'destroy']);
    
});
