<?php

use App\Http\Controllers\API\V1\FormationController;
use Illuminate\Support\Facades\Route;

Route::prefix('formations')
    ->controller(FormationController::class)
    ->group(function() {
    Route::get('', 'index');
    Route::get('{formation}', 'show');
    Route::post('', 'store');
});
