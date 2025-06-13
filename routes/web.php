<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminVendorController;

Route::get('/', function () {
    return view('landingpage');
})->name('home');


Route::prefix('admin')->group(function () {
    Route::post('/auth', [AdminController::class, 'auth'])->name('admin.auth');
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/qr/generate', [AdminController::class, 'generateQr']);
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/vendor/delete/{vendor}', [AdminVendorController::class, 'destroy']);    
    Route::get('/vendor/view/{vendor}', [AdminVendorController::class, 'view'])->name('admin.vendor.view');
    Route::post('/vendor/update-status/{vendor}', [AdminVendorController::class, 'updateStatus'])->name('admin.vendor.update.status');
    Route::get('/vendor/edit/{vendor}', [AdminVendorController::class, 'edit'])->name('admin.vendor.edit');
    Route::get('/vendors', [AdminVendorController::class, 'index'])->name('admin.vendors');
    Route::resource('vendor', AdminVendorController::class)->except(['index', 'view', 'edit', 'destroy']);
});

Route::prefix('vendor')->group(function () {
    Route::get('/success', [VendorController::class, 'success'])->name('vendor.success');
    Route::get('/signup', [VendorController::class, 'signup'])->name('vendor.signup');
});
Route::resource('vendor', VendorController::class);

Route::get('/logout', function () {
    return view('landingpage');
})->name('logout');