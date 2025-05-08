<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;
use Illuminate\Support\Facades\Route;

// Student Management Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/', [StudentController::class, 'store'])->name('store');
        Route::get('/{student}', [StudentController::class, 'show'])->name('show');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::put('/{student}', [StudentController::class, 'update'])->name('update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
        Route::get('/{student}/progress', [StudentController::class, 'progress'])->name('progress');
        Route::post('/{student}/update-progress', [StudentController::class, 'updateProgress'])->name('update-progress');
    });

    // Instructor Management Routes
    Route::prefix('instructors')->name('instructors.')->group(function () {
        Route::get('/', [InstructorController::class, 'index'])->name('index');
        Route::get('/create', [InstructorController::class, 'create'])->name('create');
        Route::post('/', [InstructorController::class, 'store'])->name('store');
        Route::get('/{instructor}', [InstructorController::class, 'show'])->name('show');
        Route::get('/{instructor}/edit', [InstructorController::class, 'edit'])->name('edit');
        Route::put('/{instructor}', [InstructorController::class, 'update'])->name('update');
        Route::delete('/{instructor}', [InstructorController::class, 'destroy'])->name('destroy');
        Route::get('/{instructor}/schedule', [InstructorController::class, 'schedule'])->name('schedule');
        Route::post('/{instructor}/update-schedule', [InstructorController::class, 'updateSchedule'])->name('update-schedule');
        Route::get('/{instructor}/students', [InstructorController::class, 'students'])->name('students');
    });
});
