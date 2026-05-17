<?php

use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitDayController;
use App\Http\Controllers\HabitLogController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('habits', HabitController::class);

    Route::prefix('habits/{habit}')->name('habits.')->group(function () {
        Route::get('days', [HabitDayController::class, 'index'])->name('days.index');
        Route::post('days', [HabitDayController::class, 'store'])->name('days.store');
        Route::delete('days/{day}', [HabitDayController::class, 'destroy'])->name('days.destroy');

        Route::get('logs', [HabitLogController::class, 'index'])->name('logs.index');
        Route::post('logs', [HabitLogController::class, 'store'])->name('logs.store');
        Route::delete('logs/{log}', [HabitLogController::class, 'destroy'])->name('logs.destroy');
    });
});

