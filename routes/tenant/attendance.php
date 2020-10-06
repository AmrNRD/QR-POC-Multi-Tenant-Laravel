<?php
use Illuminate\Support\Facades\Route;


//Web
Route::middleware('web')
    ->prefix(config('system.admin.prefix'))
    ->namespace("App\Domain\Tenant\Attendance\Http\Controllers")
    ->group(app_path('Domain/Tenant/Attendance/Routes/web/public.php'));

Route::middleware('web')
    ->prefix(config('system.admin.prefix'))
    ->namespace("App\Domain\Tenant\Attendance\Http\Controllers")
    ->group(app_path('Domain/Tenant/Attendance/Routes/web/guest.php'));

Route::middleware('web')
    ->prefix(config('system.admin.prefix'))
    ->namespace("App\Domain\Tenant\Attendance\Http\Controllers")
    ->group(app_path('Domain/Tenant/Attendance/Routes/web/auth.php'));



//API

Route::middleware('api')
    ->prefix('api/')
    ->name('api.')
    ->namespace("App\Domain\Tenant\Attendance\Http\Controllers")
    ->group(app_path("Domain/Tenant/Attendance/Routes/api/public.php"));

Route::middleware('api')
    ->prefix('api/')
    ->name('api.')
    ->namespace("App\Domain\Tenant\Attendance\Http\Controllers")
    ->group(app_path("Domain/Tenant/Attendance/Routes/api/guest.php"));

Route::middleware('api')
    ->prefix('api/')
    ->name('api.')
    ->namespace("App\Domain\Tenant\Attendance\Http\Controllers")
    ->group(app_path("Domain/Tenant/Attendance/Routes/api/auth.php"));
