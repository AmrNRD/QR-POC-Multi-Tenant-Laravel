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


Route::middleware(['auth'])->group(function () {
    Route::resource('/attendances','AttendanceController');
	Route::resource('/holidays','HolidaysController');
	Route::resource('/devices','DevicesController');
	###CRUD_PLACEHOLDER###

    Route::get('/attendances-month-records','AttendanceController@monthAttendanceRecords');

    Route::post('/activate-device/{device}','DevicesController@activateDevice')->name('devices.activate');

});
