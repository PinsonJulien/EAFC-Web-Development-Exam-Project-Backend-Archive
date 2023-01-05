<?php

use App\Http\Controllers\API\V1\GroupController;
use Illuminate\Support\Facades\Route;

Route::prefix('groups')
    ->controller(GroupController::class)
    ->group(function() {
    Route::get('', 'index');
    Route::get('{group}', 'show');
    Route::post('', 'store');
});
