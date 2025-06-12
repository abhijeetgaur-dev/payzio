<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;

Route::get('/', function () {
    return view('landingpage');
})->name('home');


Route::get('/admin/login', function() {
    return view('admin.login');
})->name('admin.login');


Route::prefix('vendor')->group(function () {
    Route::get('/success', [VendorController::class, 'success'])->name('vendor.success');
    Route::get('/signup', [VendorController::class, 'signup'])->name('vendor.signup');
});
Route::resource('vendor', VendorController::class);
