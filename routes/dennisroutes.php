<?php

use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/instructors', [InstructorController::class, 'index'])->name('instructors.index');
Route::get('/students', [StudentController::class, 'index'])->name('students.index');