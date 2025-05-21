<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Invoice Management Routes
Route::prefix('invoices')->name('invoices.')->group(function () {
    Route::get('/', [InvoiceController::class, 'index'])->name('index');
    Route::get('/create', [InvoiceController::class, 'create'])->name('create');
    Route::post('/', [InvoiceController::class, 'store'])->name('store');
    Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
    Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
    Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
    Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
    Route::post('/{invoice}/send', [InvoiceController::class, 'send'])->name('send');
    Route::get('/{invoice}/download', [InvoiceController::class, 'download'])->name('download');
    Route::get('/student/{student}', [InvoiceController::class, 'studentInvoices'])->name('student');
    Route::get('/unpaid', [InvoiceController::class, 'unpaid'])->name('unpaid');
});

// Payment Management Routes
Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::get('/create', [PaymentController::class, 'create'])->name('create');
    Route::post('/', [PaymentController::class, 'store'])->name('store');
    Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
    Route::get('/{payment}/edit', [PaymentController::class, 'edit'])->name('edit');
    Route::put('/{payment}', [PaymentController::class, 'update'])->name('update');
    Route::delete('/{payment}', [PaymentController::class, 'destroy'])->name('destroy');
    Route::post('/process', [PaymentController::class, 'process'])->name('process');
    Route::get('/success', [PaymentController::class, 'success'])->name('success');
    Route::get('/failed', [PaymentController::class, 'failed'])->name('failed');
    Route::get('/student/{student}', [PaymentController::class, 'studentPayments'])->name('student');
    Route::get('/reports', [PaymentController::class, 'reports'])->name('reports');
});

