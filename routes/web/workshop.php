<?php

use App\Http\Controllers\Workshop\BlockController;
use App\Http\Controllers\Workshop\ConfigurationController;
use App\Http\Controllers\Workshop\DashboardController;
use App\Http\Controllers\Workshop\EntryController;
use App\Http\Controllers\Workshop\EntryTypeController;
use App\Http\Controllers\Workshop\FormController;
use App\Http\Controllers\Workshop\FormFieldController;
use App\Http\Controllers\Workshop\FormSubmissionController;
use App\Http\Controllers\Workshop\LocaleController;
use App\Http\Controllers\Workshop\MediumController;
use App\Http\Controllers\Workshop\MenuController;
use App\Http\Controllers\Workshop\MenuItemController;
use App\Http\Controllers\Workshop\RedirectionController;
use App\Http\Controllers\Workshop\SettingsController;
use App\Http\Controllers\Workshop\TaxonomyController;
use App\Http\Controllers\Workshop\TaxonomyTypeController;
use App\Http\Controllers\Workshop\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::prefix('/entries/{entryType:name}')->name('entries.')->group(function () {
    Route::get('/', [EntryController::class, 'index'])->name('index');
    Route::get('/create', [EntryController::class, 'create'])->name('create');
    Route::get('/{entry}', [EntryController::class, 'show'])->name('show');
    Route::get('/{entry}/edit', [EntryController::class, 'edit'])->name('edit');
    Route::patch('/{entry}', [EntryController::class, 'update'])->name('update');
    Route::get('/{entry}/destroy', [EntryController::class, 'destroy'])->name('destroy');
});

Route::prefix('/taxonomies/{taxonomyType:name}')->name('taxonomies.')->group(function () {
    Route::get('/', [TaxonomyController::class, 'index'])->name('index');
    Route::get('/create', [TaxonomyController::class, 'create'])->name('create');
    Route::get('/{taxonomy}', [TaxonomyController::class, 'show'])->name('show');
    Route::get('/{taxonomy}/edit', [TaxonomyController::class, 'edit'])->name('edit');
    Route::patch('/{taxonomy}', [TaxonomyController::class, 'update'])->name('update');
    Route::get('/{taxonomy}/destroy', [TaxonomyController::class, 'destroy'])->name('destroy');
});

Route::resource('medium', MediumController::class);

Route::prefix('/menus')->name('menus.')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('index');
    Route::patch('/{menu}', [MenuController::class, 'update'])->name('update');

    Route::prefix('/{menu}/items')->name('items.')->group(function () {
        Route::get('/create', [MenuItemController::class, 'create'])->name('create');
        Route::get('/{item}', [MenuItemController::class, 'show'])->name('show');
        Route::get('/{item}/edit', [MenuItemController::class, 'edit'])->name('edit');
        Route::patch('/{item}', [MenuItemController::class, 'update'])->name('update');
        Route::get('/{item}/destroy', [MenuItemController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('/blocks')->name('blocks.')->group(function () {
    Route::get('/', [BlockController::class, 'index'])->name('index');
    Route::get('/create', [BlockController::class, 'create'])->name('create');
    Route::post('/', [BlockController::class, 'store'])->name('store');
    Route::get('/{block}', [BlockController::class, 'show'])->name('show');
    Route::get('/{block}/edit', [BlockController::class, 'edit'])->name('edit');
    Route::patch('/{block}', [BlockController::class, 'update'])->name('update');
    Route::get('/{block}/destroy', [BlockController::class, 'destroy'])->name('destroy');
});

Route::prefix('/forms')->name('forms.')->group(function () {
    Route::get('/', [FormController::class, 'index'])->name('index');
    Route::get('/create', [FormController::class, 'create'])->name('create');
    Route::post('/', [FormController::class, 'store'])->name('store');

    Route::prefix('/{form}')->group(function () {
        Route::get('/', [FormController::class, 'show'])->name('show');
        Route::get('/edit', [FormController::class, 'edit'])->name('edit');
        Route::patch('/', [FormController::class, 'update'])->name('update');
        Route::get('/destroy', [FormController::class, 'destroy'])->name('destroy');

        Route::prefix('/fields')->name('fields.')->group(function () {
            Route::get('/', [FormFieldController::class, 'index'])->name('index');
            Route::get('/create', [FormFieldController::class, 'create'])->name('create');
            Route::post('/', [FormFieldController::class, 'store'])->name('store');

            Route::prefix('/{field}')->group(function () {
                Route::get('/edit', [FormFieldController::class, 'edit'])->name('edit');
                Route::patch('/', [FormFieldController::class, 'update'])->name('update');
                Route::get('/destroy', [FormFieldController::class, 'destroy'])->name('destroy');
            });
        });

        Route::prefix('/submissions')->name('submissions.')->group(function () {
            Route::get('/', [FormSubmissionController::class, 'index'])->name('index');
        });
    });
});

Route::prefix('/users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::patch('/{user}', [UserController::class, 'update'])->name('update');
    Route::get('/{user}/destroy', [UserController::class, 'destroy'])->name('destroy');
});

Route::prefix('/configuration')->name('configuration.')->group(function () {
    Route::get('/', [ConfigurationController::class, 'general'])->name('general');
    Route::patch('/', [ConfigurationController::class, 'update'])->name('update');
    Route::get('/app/update', [ConfigurationController::class, 'updateApp'])->name('app.update');
    Route::get('/theme/update', [ConfigurationController::class, 'updateTheme'])->name('theme.update');

    Route::prefix('/setting')->name('setting.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::patch('/', [SettingsController::class, 'update'])->name('update');
    });

    Route::resource('locale', LocaleController::class);
    Route::resource('entry-type', EntryTypeController::class);
    Route::resource('taxonomy-type', TaxonomyTypeController::class);
    Route::resource('redirection', RedirectionController::class);
});
