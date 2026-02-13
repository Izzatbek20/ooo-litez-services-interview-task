<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->middleware(['api'])
    ->group(function () {

        Route::get('/hi', function (Request $request) {
            return response()->json([
                'message' => 'Hello World!'
            ]);
        });

    });
