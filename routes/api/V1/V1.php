<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->namespace('App\Http\Controllers\API\V1')
//    ->middleware('auth:sanctum')
    ->group(function () {
        Route::group([], __DIR__ . '/courses.php');
        Route::group([], __DIR__ . '/formations.php');
        Route::group([], __DIR__ . '/educationLevels.php');
    });
