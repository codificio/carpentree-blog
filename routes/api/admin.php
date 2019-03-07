<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api/admin')
    ->name('api.admin.')
    ->namespace('Carpentree\Blog\Http\Controllers')
    ->group(function () {

    Route::middleware(['api', 'auth:api', 'verified', 'scope:admin'])
        ->group(function() {

            /**
             * Articles
             */
            Route::prefix('articles')->group(function() {
                Route::get('/', 'Admin\ArticleController@list')
                    ->name('articles.list');

                Route::get('{id}', 'Admin\ArticleController@get')
                    ->name('articles.get');

                Route::post('/', 'Admin\ArticleController@create')
                    ->name('articles.create');

                Route::patch('/', 'Admin\ArticleController@update')
                    ->name('articles.update');

                Route::delete('{id}', 'Admin\ArticleController@delete')
                    ->name('articles.delete');
            });

    });

});
