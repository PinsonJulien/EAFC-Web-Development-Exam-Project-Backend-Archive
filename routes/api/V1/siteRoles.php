<?php

use App\Http\Controllers\API\V1\SiteRoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('siteRoles')
    ->controller(SiteRoleController::class)
    ->group(function() {
    Route::get('', 'index');
    Route::get('{siteRole}', 'show');
    Route::post('', 'store');
    Route::delete('{siteRole}', 'destroy');
});
