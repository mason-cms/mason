<?php

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

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('/backend')
    ->name('backend.')
    ->group(base_path('routes/web/backend.php'));

Route::middleware('guest')
    ->group(base_path('routes/web/guest.php'));

Route::middleware('auth')
    ->group(base_path('routes/web/auth.php'));

Route::prefix('/')
    ->group(base_path('routes/web/frontend.php'));
