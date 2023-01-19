<?php

use App\Http\Controllers\API\V1\CountryController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;

Route::prefix('countries')
    ->controller(CountryController::class)
    ->group(function() {

    Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{country}', 'show');

    Route::post('', 'store');
});
