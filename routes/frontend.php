<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;
use App\Models\Locale;
use Illuminate\Support\Facades\Schema;

$alphanum = '[0-9A-Za-z\-]{3,255}';

Route::get('/', [FrontEndController::class, 'home'])
    ->name('home');

Route::get('/{entry:name}', [FrontEndController::class, 'entry'])
    ->where(['entry' => $alphanum])
    ->name('entry');

Route::get('/{taxonomyType:name}/{taxonomy:name}/{entryType:name?}', [FrontEndController::class, 'taxonomy'])
    ->where([
        'taxonomy' => $alphanum,
        'taxonomyType' => $alphanum,
        'entryType' => $alphanum,
    ])
    ->name('taxonomy');

if (Schema::hasTable('locales')) {
    $locales = Locale::all()->pluck('name')->join('|');

    Route::get('/{locale:name}', [FrontEndController::class, 'home'])
        ->where(['locale' => $locales])
        ->name('locale.home');

    Route::get('/{locale:name}/{entry:name}', [FrontEndController::class, 'entry'])
        ->where(['locale' => $locales])
        ->where(['entry' => $alphanum])
        ->name('locale.entry');

    Route::get('/{locale:name}/{taxonomyType:name}/{taxonomy:name}/{entryType:name?}', [FrontEndController::class, 'taxonomy'])
        ->where(['locale' => $locales])
        ->where([
            'taxonomy' => $alphanum,
            'taxonomyType' => $alphanum,
            'entryType' => $alphanum,
        ])
        ->name('locale.taxonomy');
}
