<?php

use App\Http\Controllers\ProductController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;

Route::get('/purchases/{purchase}/export-pdf', [PurchaseController::class, 'exportSinglePdf'])->name('purchases.exportSinglePdf');

Route::get('/products/{id}/pdf', [ProductController::class, 'exportIndividualPdf'])->name('products.pdf');

Route::get('/customers/{id}/pdf', [CustomerController::class, 'generateIndividualPDF'])->name('customers.pdf');

// Handle form submission
Route::post('/purchases', [CustomerController::class, 'store'])->name('purchases.store');

// Show edit form
Route::get('/purchases/{purchase}/edit', [CustomerController::class, 'edit'])->name('purchases.edit');

// Handle update
Route::put('/purchases/{purchase}', [CustomerController::class, 'update'])->name('purchases.update');



// Handle form submission
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');

// Show edit form
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');

// Handle update
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');Route::get('customers-pdf', [CustomerController::class, 'exportPdf'])->name('customers.exportPdf');

Route::resource('purchases', PurchaseController::class);
Route::get('purchases-pdf', [PurchaseController::class, 'exportPdf'])->name('purchases.exportPdf');


Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class)->except(['show']);
Route::resource('purchases', PurchaseController::class);

Route::get('/products/export-pdf', [ProductController::class, 'exportPdf'])->name('products.exportPdf');

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('products', ProductController::class);

