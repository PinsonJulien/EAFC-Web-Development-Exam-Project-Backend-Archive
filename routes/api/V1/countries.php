<?php

use App\Http\Controllers\API\V1\CountryController;
use Illuminate\Support\Facades\Route;

Route::prefix('countries')
    ->controller(CountryController::class)
    ->group(function() {
   Route::get('', 'index');
   Route::get('{country}', 'show');
});
