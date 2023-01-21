<?php

use App\Http\Controllers\API\V1\CountryController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('countries')
    ->controller(CountryController::class)
    ->group(function() {

    Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{country}', 'show');

    Route::post('', 'store');

    Route::put('{country}', 'update');

    Route::patch('{country}', 'update');

    Route::delete('{country}', 'destroy');
});
