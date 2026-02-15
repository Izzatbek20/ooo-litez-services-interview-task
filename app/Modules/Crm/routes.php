<?php

use App\Modules\Crm\Controllers\AuthController;
use App\Modules\Crm\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->middleware(['api'])
    ->group(function () {

        // Tizimga kirish va ro'yxatdan o'tish
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {

            Route::get('/clients', [ClientController::class, 'getAll']);

        });

    });
