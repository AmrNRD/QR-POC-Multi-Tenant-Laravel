<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'auth',
    'namespace'=>'Auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('login/provider', 'AuthController@loginWithProvider');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::resource('/users','UserController');
        Route::post('logout', 'AuthController@logout');
        Route::post('user', 'AuthController@user');
    });
});
