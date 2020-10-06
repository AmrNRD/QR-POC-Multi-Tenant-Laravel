<?php
use Illuminate\Support\Facades\Route;


//Web
Route::middleware('web')
    ->prefix(config('system.admin.prefix'))
    ->namespace("App\Domain\Tenant\Dashboard\Http\Controllers")
    ->group(app_path('Domain/Tenant/Dashboard/Routes/web/public.php'));

Route::middleware('web')
    ->prefix(config('system.admin.prefix'))
    ->namespace("App\Domain\Tenant\Dashboard\Http\Controllers")
    ->group(app_path('Domain/Tenant/Dashboard/Routes/web/guest.php'));

Route::middleware('web')
    ->prefix(config('system.admin.prefix'))
    ->namespace("App\Domain\Tenant\Dashboard\Http\Controllers")
    ->group(app_path('Domain/Tenant/Dashboard/Routes/web/auth.php'));



//API
Route::middleware('api')
    ->prefix('api/')
    ->name('api.')
    ->namespace("App\Domain\Tenant\Dashboard\Http\Controllers")
    ->group(app_path("Domain/Tenant/Dashboard/Routes/api/public.php"));

Route::middleware('api')
    ->prefix('api/')
    ->name('api.')
    ->namespace("App\Domain\Tenant\Dashboard\Http\Controllers")
    ->group(app_path("Domain/Tenant/Dashboard/Routes/api/guest.php"));

Route::middleware('api')
    ->prefix('api/')
    ->name('api.')
    ->namespace("App\Domain\Tenant\Dashboard\Http\Controllers")
    ->group(app_path("Domain/Tenant/Dashboard/Routes/api/auth.php"));
