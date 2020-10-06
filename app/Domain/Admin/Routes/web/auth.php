<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth:staff'])->group(function () {
    Route::resource('/admins','AdminController');
	Route::resource('/roles','RoleController');
	###CRUD_PLACEHOLDER###
});

Auth::routes();
