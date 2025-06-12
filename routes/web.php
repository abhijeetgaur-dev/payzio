<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('landingpage');
})->name('home');

Route::prefix('admin')->group(function () {
    Route::post('/auth', [AdminController::class, 'auth'])->name('admin.auth');
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
Route::resource('/admin', AdminController::class);


Route::prefix('vendor')->group(function () {
    Route::get('/success', [VendorController::class, 'success'])->name('vendor.success');
    Route::get('/signup', [VendorController::class, 'signup'])->name('vendor.signup');
});
Route::resource('vendor', VendorController::class);
