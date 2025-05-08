<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;

// Car Management Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('cars')->name('cars.')->group(function () {
        Route::get('/', [CarController::class, 'index'])->name('index');
        Route::get('/create', [CarController::class, 'create'])->name('create');
        Route::post('/', [CarController::class, 'store'])->name('store');
        Route::get('/{car}', [CarController::class, 'show'])->name('show');
        Route::get('/{car}/edit', [CarController::class, 'edit'])->name('edit');
        Route::put('/{car}', [CarController::class, 'update'])->name('update');
        Route::delete('/{car}', [CarController::class, 'destroy'])->name('destroy');
        Route::get('/maintenance-schedule', [CarController::class, 'maintenanceSchedule'])->name('maintenance-schedule');
        Route::post('/{car}/schedule-maintenance', [CarController::class, 'scheduleMaintenance'])->name('schedule-maintenance');
    });

    // Package (Bundle) Management Routes
    Route::prefix('packages')->name('packages.')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('index');
        Route::get('/create', [PackageController::class, 'create'])->name('create');
        Route::post('/', [PackageController::class, 'store'])->name('store');
        Route::get('/{package}', [PackageController::class, 'show'])->name('show');
        Route::get('/{package}/edit', [PackageController::class, 'edit'])->name('edit');
        Route::put('/{package}', [PackageController::class, 'update'])->name('update');
        Route::delete('/{package}', [PackageController::class, 'destroy'])->name('destroy');
        Route::get('/student/{student}', [PackageController::class, 'studentPackages'])->name('student');
    });

    // Lesson Planning Routes
    Route::prefix('lessons')->name('lessons.')->group(function () {
        Route::get('/', [LessonController::class, 'index'])->name('index');
        Route::get('/create', [LessonController::class, 'create'])->name('create');
        Route::post('/', [LessonController::class, 'store'])->name('store');
        Route::get('/{lesson}', [LessonController::class, 'show'])->name('show');
        Route::get('/{lesson}/edit', [LessonController::class, 'edit'])->name('edit');
        Route::put('/{lesson}', [LessonController::class, 'update'])->name('update');
        Route::delete('/{lesson}', [LessonController::class, 'destroy'])->name('destroy');
        Route::post('/{lesson}/confirm', [LessonController::class, 'confirm'])->name('confirm');
        Route::post('/{lesson}/cancel', [LessonController::class, 'cancel'])->name('cancel');
        Route::get('/calendar', [LessonController::class, 'calendar'])->name('calendar');
        Route::get('/instructor/{instructor}', [LessonController::class, 'instructorLessons'])->name('instructor');
        Route::get('/student/{student}', [LessonController::class, 'studentLessons'])->name('student');
    });
});
