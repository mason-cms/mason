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

Route::get('/', [FrontEndController::class, 'home'])
    ->name('home');

Route::get('/{taxonomyType:name}/{taxonomy:name}/{entryType:name?}', [FrontEndController::class, 'taxonomy'])
    ->where([
        'taxonomy' => $alphanum,
        'taxonomyType' => $taxonomyTypeNames,
        'entryType' => $entryTypeNames,
    ])
    ->name('taxonomy');

Route::get('/{entryType:name}', [FrontEndController::class, 'entryType'])
    ->where([
        'entryType' => $entryTypeNames,
    ])
    ->name('entryType');

Route::get('/{entry:name}', [FrontEndController::class, 'entry'])
    ->where([
        'entry' => $alphanum,
    ])
    ->name('entry');

if (Schema::hasTable('locales')) {
    $locales = Locale::all();
    $localeNames = $locales->pluck('name')->join('|');

    Route::get('/{locale:name}', [FrontEndController::class, 'home'])
        ->where(['locale' => $localeNames])
        ->name('locale.home');

    Route::get('/{locale:name}/{taxonomyType:name}/{taxonomy:name}/{entryType:name?}', [FrontEndController::class, 'taxonomy'])
        ->where([
            'locale' => $localeNames,
            'taxonomy' => $alphanum,
            'taxonomyType' => $taxonomyTypeNames,
            'entryType' => $entryTypeNames,
        ])
        ->name('locale.taxonomy');

    Route::get('/{locale:name}/{entryType:name}', [FrontEndController::class, 'entryType'])
        ->where([
            'locale' => $localeNames,
            'entryType' => $entryTypeNames,
        ])
        ->name('locale.entryType');

    Route::get('/{locale:name}/{entry:name}', [FrontEndController::class, 'entry'])
        ->where([
            'locale' => $localeNames,
            'entry' => $alphanum,
        ])
        ->name('locale.entry');
}
