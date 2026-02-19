<?php

use App\Modules\Crm\Controllers\AuthController;
use App\Modules\Crm\Controllers\ClientController;
use App\Modules\Crm\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->middleware(['api'])
    ->group(function () {

        // Tizimga kirish va ro'yxatdan o'tish
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {

            Route::get('/clients', [ClientController::class, 'getAll']);

            Route::prefix('/tasks')
                ->group(function () {

                    Route::get('/', [TaskController::class, 'all']);
                    Route::post('/', [TaskController::class, 'store']);
                    Route::get('/today', [TaskController::class, 'today']);
                    Route::get('/overdue', [TaskController::class, 'overdue']);
                    Route::patch('/{id}/status', [TaskController::class, 'updateStatus']);
                    Route::put('/{id}', [TaskController::class, 'update']);
                    Route::delete('/{id}', [TaskController::class, 'delete']);
                });

        });

    });
