<?php

use App\Http\Controllers\API\V1\CohortController;
use Illuminate\Support\Facades\Route;

Route::prefix('cohorts')
    ->controller(CohortController::class)
    ->group(function() {
    Route::get('', 'index');
    Route::get('{cohort}', 'show');
    Route::post('', 'store');
});
