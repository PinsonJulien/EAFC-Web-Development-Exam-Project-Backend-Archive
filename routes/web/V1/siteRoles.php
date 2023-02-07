<?php

use App\Http\Controllers\API\V1\SiteRoleController;
use App\Http\Middleware\RestrictedMiddleware;
use App\Models\SiteRole;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('siteRoles')
    // Forbidden access to banned users.
    ->middleware(RestrictedMiddleware::class)
    ->controller(SiteRoleController::class)
    ->group(function() {

    Route::get('', 'index')
        ->can('viewAny', SiteRole::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->can('exportAny', SiteRole::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{siteRole}', 'show')
        ->can('view', 'siteRole')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store')
        ->can('create', SiteRole::class);

    Route::put('{siteRole}', 'update')
        ->can('update', 'siteRole');

    Route::patch('{siteRole}', 'update')
        ->can('update', 'siteRole');

    Route::delete('{siteRole}', 'destroy')
        ->can('delete', 'siteRole');
});
