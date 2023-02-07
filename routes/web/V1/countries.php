<?php

use App\Http\Controllers\API\V1\CountryController;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\RestrictedMiddleware;
use App\Models\Country;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('countries')
    // Forbidden access to banned users.
    ->middleware(RestrictedMiddleware::class)
    ->controller(CountryController::class)
    ->group(function() {

    Route::get('', 'index')
        ->can('viewAny', Country::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->can('exportAny', Country::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{country}', 'show')
        ->can('view', 'country')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store')
        ->can('create', Country::class);

    Route::put('{country}', 'update')
        ->can('update', 'country');

    Route::patch('{country}', 'update')
        ->can('update', 'country');

    Route::delete('{country}', 'destroy')
        ->can('delete', 'country');
});
