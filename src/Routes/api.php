<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'api', 'middleware' => 'api', 'namespace' => 'CoreCMF\Socialite\App\Http\Controllers\Api', 'as' => 'api.'], function () {
    /*
    |--------------------------------------------------------------------------
    | 需要用户认证路由模块
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'socialite', 'as' => 'socialite.', 'middleware' => []], function () {
        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::group(['prefix' => 'config', 'as' => 'config.'], function () {
                Route::post('/', ['as' => 'index',     'uses' => 'ConfigController@index']);
                Route::post('update', ['as' => 'update',     'uses' => 'ConfigController@update']);
            });
        });
        Route::post('main', [ 'as' => 'main', 'uses' => 'MainController@index']);
    });
});
