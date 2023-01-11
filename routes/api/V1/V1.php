<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->namespace('App\Http\Controllers\API\V1')
//    ->middleware('auth:sanctum')
    ->group(function () {
        $files = [
            'courses',
            'formations',
            'educationLevels',
            'users',
            'countries',
            'cohorts',
        ];

        foreach ($files as $file) {
            Route::group([], __DIR__ . '/' . $file . '.php');
        }
    });
