<?php

use App\Http\Controllers\FrontEndController;
use App\Models\EntryType;
use App\Models\Locale;
use App\Models\TaxonomyType;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

$alphanum = '[0-9A-Za-z\-]{3,255}';

$entryTypes = EntryType::all();
$entryTypeNames = $entryTypes->pluck('name')->join('|');

$taxonomyTypes = TaxonomyType::all();
$taxonomyTypeNames = $taxonomyTypes->pluck('name')->join('|');

Route::any('/', [FrontEndController::class, 'home'])
    ->name('home');

Route::any('/{taxonomyType:name}/{taxonomy:name}/{entryType:name?}', [FrontEndController::class, 'taxonomy'])
    ->where([
        'taxonomyType' => $taxonomyTypeNames,
        'taxonomy' => $alphanum,
        'entryType' => $entryTypeNames,
    ])
    ->name('taxonomy');

Route::any('/{entryType:name}', [FrontEndController::class, 'entryType'])
    ->where([
        'entryType' => $entryTypeNames,
    ])
    ->name('entryType');

Route::any('/{entry:name}', [FrontEndController::class, 'entry'])
    ->where([
        'entry' => $alphanum,
    ])
    ->name('entry');

if (Schema::hasTable('locales')) {
    $locales = Locale::all();
    $localeNames = $locales->pluck('name')->join('|');

    Route::any('/{locale:name}', [FrontEndController::class, 'home'])
        ->where(['locale' => $localeNames])
        ->name('locale.home');

    Route::any('/{locale:name}/{taxonomyType:name}/{taxonomy:name}/{entryType:name?}', [FrontEndController::class, 'taxonomy'])
        ->where([
            'locale' => $localeNames,
            'taxonomy' => $alphanum,
            'taxonomyType' => $taxonomyTypeNames,
            'entryType' => $entryTypeNames,
        ])
        ->name('locale.taxonomy');

    Route::any('/{locale:name}/{entryType:name}', [FrontEndController::class, 'entryType'])
        ->where([
            'locale' => $localeNames,
            'entryType' => $entryTypeNames,
        ])
        ->name('locale.entryType');

    Route::any('/{locale:name}/{entry:name}', [FrontEndController::class, 'entry'])
        ->where([
            'locale' => $localeNames,
            'entry' => $alphanum,
        ])
        ->name('locale.entry');
}
