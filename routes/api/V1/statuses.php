<?php

use App\Http\Controllers\API\V1\StatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('statuses')
    ->controller(StatusController::class)
    ->group(function() {
    Route::get('', 'index');
    Route::get('{status}', 'show');
    Route::post('', 'store');
    Route::delete('{status}', 'destroy');
});
