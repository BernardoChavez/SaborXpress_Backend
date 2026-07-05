<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-db', function () {
    return response()->json([
        'connection' => config('database.default'),
        'env_db' => env('DB_CONNECTION'),
        'dir' => base_path(),
    ]);
});
