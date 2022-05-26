<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;

Route::get('/{locale:name}/{entry:name}', [FrontEndController::class, 'entry'])
    ->where(['locale' => '[a-z]{2}'])
    ->name('locale.entry');

Route::get('/{locale:name}', [FrontEndController::class, 'entry'])
    ->where(['locale' => '[a-z]{2}'])
    ->name('locale.home');

Route::get('/{entry:name}', [FrontEndController::class, 'entry'])
    ->name('entry');

Route::get('/', [FrontEndController::class, 'home'])
    ->name('home');
