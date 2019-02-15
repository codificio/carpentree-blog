<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('api/admin')->namespace('Carpentree\Core\Http\Controllers\Admin')->group(function () {

    Route::middleware(['api', 'auth:api', 'verified'])->group(function() {



    });

});
