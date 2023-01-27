<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')
    ->namespace('App\Http\Controllers\API\V1')
//    ->middleware('auth:sanctum')
    ->group(function () {
        $files = [
            'auth',
            'courses',
            'formations',
            'educationLevels',
            'users',
            'countries',
            'cohorts',
            'siteRoles',
            'cohortRoles',
            'statuses',
            'enrollments',
            'grades',
        ];

        foreach ($files as $file) {
            Route::group([], __DIR__ . '/' . $file . '.php');
        }
    });
