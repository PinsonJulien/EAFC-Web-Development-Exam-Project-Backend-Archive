<?php

use App\Http\Controllers\API\V1\StatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;

Route::prefix('statuses')
    ->controller(StatusController::class)
    ->group(function() {

    Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{status}', 'show');

    Route::post('', 'store');
    Route::delete('{status}', 'destroy');
});
