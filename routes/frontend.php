<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;

Route::prefix('{locale?}')->where(['locale' => '[a-z]{2}'])->group(function () {
    Route::get('/{entry:name?}', [FrontEndController::class, 'entry'])->name('entry');
});
