<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include individual team member route files
require __DIR__.'/wassimroutes.php';  // Accounts and notifications
require __DIR__.'/dennisroutes.php';  // Student and instructor
require __DIR__.'/mahdiroutes.php';   // Car, bundles, and planning
require __DIR__.'/danielroutes.php';  // Invoices and payment

require __DIR__.'/auth.php';
