<?php

use App\Http\Controllers\API\V1\CohortRoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('cohortRoles')
    ->controller(CohortRoleController::class)
    ->group(function() {
    Route::get('', 'index');
    Route::get('{cohortRole}', 'show');
    Route::post('', 'store');
    Route::delete('{cohortRole}', 'destroy');
});
