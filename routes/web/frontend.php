<?php

use App\Http\Controllers\FrontEndController;
use App\Models\EntryType;
use App\Models\Locale;
use App\Models\Redirection;
use App\Models\TaxonomyType;
use Illuminate\Support\Facades\Route;

$alphanum = '[0-9A-Za-z\-]{3,255}';

try {
    $locales = Locale::all();
    $localeNames = $locales->count() > 0
        ? $locales->pluck('name')->join('|')
        : null;
} catch (\Exception $e) {
    $localeNames = null;
}

try {
    $taxonomyTypes = TaxonomyType::all();
    $taxonomyTypeNames = $taxonomyTypes->count() > 0
        ? $taxonomyTypes->pluck('name')->join('|')
        : null;
} catch (\Exception $e) {
    $taxonomyTypeNames = null;
}

try {
    $entryTypes = EntryType::all();
    $entryTypeNames = $entryTypes->count() > 0
        ? $entryTypes->pluck('name')->join('|')
        : null;
} catch (\Exception $e) {
    $entryTypeNames = null;
}

try {
    $redirections = Redirection::active()->get();
    $redirectionSources = $redirections->count() > 0
        ? $redirections->pluck('source')->join('|')
        : null;
} catch (\Exception $e) {
    $redirectionSources = null;
}

Route::any('/', [FrontEndController::class, 'home'])
    ->name('home');

Route::post(
    uri: '/upload',
    action: [FrontEndController::class, 'upload'],
)->name('upload');

if (isset($redirectionSources)) {
    Route::any(
        uri: '/{redirection:source}',
        action: [FrontEndController::class, 'redirect'],
    )->where([
        'redirection' => $redirectionSources,
    ]);
}

if (isset($taxonomyTypeNames, $entryTypeNames)) {
    Route::any(
        uri: '/{taxonomyType:name}/{taxonomy:name}/{entryType:name?}',
        action: [FrontEndController::class, 'taxonomy'],
    )->where([
        'taxonomyType' => $taxonomyTypeNames,
        'taxonomy' => $alphanum,
        'entryType' => $entryTypeNames,
    ])->name('taxonomy');
}

if (isset($entryTypeNames)) {
    Route::any(
        uri: '/{entryType:name}',
        action: [FrontEndController::class, 'entryType'],
    )->where([
        'entryType' => $entryTypeNames,
    ])->name('entryType');
}

Route::any(
    uri: '/{entry:name}',
    action: [FrontEndController::class, 'entry'],
)->where([
    'entry' => $alphanum,
])->name('entry');

if (isset($localeNames)) {
    Route::any(
        uri: '/{locale:name}',
        action: [FrontEndController::class, 'home'],
    )->where([
        'locale' => $localeNames,
    ])->name('locale.home');

    Route::post(
        uri: '/{locale:name}/upload',
        action: [FrontEndController::class, 'upload'],
    )->name('locale.upload');

    if (isset($taxonomyTypeNames, $entryTypeNames)) {
        Route::any(
            uri: '/{locale:name}/{taxonomyType:name}/{taxonomy:name}/{entryType:name?}',
            action: [FrontEndController::class, 'taxonomy'],
        )->where([
            'locale' => $localeNames,
            'taxonomy' => $alphanum,
            'taxonomyType' => $taxonomyTypeNames,
            'entryType' => $entryTypeNames,
        ])->name('locale.taxonomy');
    }

    if (isset($entryTypeNames)) {
        Route::any(
            uri: '/{locale:name}/{entryType:name}',
            action: [FrontEndController::class, 'entryType'],
        )->where([
            'locale' => $localeNames,
            'entryType' => $entryTypeNames,
        ])->name('locale.entryType');
    }

    Route::any(
        uri: '/{locale:name}/{entry:name}',
        action: [FrontEndController::class, 'entry'],
    )->where([
        'locale' => $localeNames,
        'entry' => $alphanum,
    ])->name('locale.entry');
}
