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
    Route::resource('/attendances','AttendanceController');
	Route::resource('/holidays','HolidaysController');
	Route::resource('/devices','DevicesController');

    Route::post('/refresh-qr','DevicesController@updateQR');


    Route::post('/activate-device/{device}','DevicesController@activateDevice')->name('devices.activate');

    Route::post('/register-attendance/qr','AttendanceController@registerAttendanceViaQR');

    Route::get('/attendances-month-records','AttendanceController@monthAttendanceRecords');

});
