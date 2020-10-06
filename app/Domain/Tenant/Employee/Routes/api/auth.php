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


Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('/employee_devices','EmployeeDevicesController');
	Route::resource('/employees','EmployeeController');
	Route::resource('/employee_shifts','EmployeeShiftController');
	###CRUD_PLACEHOLDER###
});