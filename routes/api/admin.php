<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api/admin')
    ->name('api.admin.')
    ->namespace('Carpentree\Core\Http\Controllers\Admin')
    ->group(function () {

    Route::middleware(['api', 'auth:api', 'verified', 'scope:admin'])
        ->group(function() {



    });

});
