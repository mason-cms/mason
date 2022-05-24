<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\EntryController;

Route::middleware(['auth'])->prefix('backend')->name('backend.')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::prefix('/entries/{entryType:name}')->name('entries.')->group(function () {
        Route::get('/', [EntryController::class, 'index'])->name('index');
        Route::get('/create', [EntryController::class, 'create'])->name('create');
        Route::post('/', [EntryController::class, 'store'])->name('store');
        Route::get('/{entry}', [EntryController::class, 'show'])->name('show');
        Route::get('/{entry}/edit', [EntryController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{entry}', [EntryController::class, 'update'])->name('update');
        Route::get('/{entry}/destroy', [EntryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/taxonomies')->name('taxonomies.')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('index');
    });

    Route::prefix('/menus')->name('menus.')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('index');
    });

    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('index');
    });

    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('index');
    });

    Route::prefix('/settings')->name('settings.')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('index');
    });
});
