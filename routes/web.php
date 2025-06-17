<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\QrController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\VendorController;

Route::get('/', function () {
    return view('landingpage');
})->name('home');


Route::prefix('admin')
    ->middleware('admin.auth') 
    ->group(function () {
        Route::post('/auth', [AdminController::class, 'auth'])->name('admin.auth');
        Route::get('/qr/generate', [AdminController::class, 'generateQr']);
        Route::post('/qr/save/', [QrController::class, 'store'])->name('admin.qr.save');
        Route::get('/qr/index/', [QrController::class, 'index'])->name('admin.qr.index');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/transactions/all', [AdminController::class, 'transaction'])->name('admin.transactions.all');
        Route::get('/transactions/completed', [AdminController::class, 'completedTransaction'])->name('admin.transactions.completed');
        Route::delete('/vendor/delete/{vendor}', [AdminVendorController::class, 'destroy']);
        Route::get('/vendor/view/{vendor}', [AdminVendorController::class, 'view'])->name('admin.vendor.view');
        Route::put('/vendor/update-status/{vendor}', [AdminVendorController::class, 'updateStatus'])->name('admin.vendor.update.status');
        Route::get('/vendor/edit/{vendor}', [AdminVendorController::class, 'edit'])->name('admin.vendor.edit');
        Route::get('/vendor/create/', [AdminVendorController::class, 'create'])->name('admin.vendor.create');
        Route::post('/vendor/store/', [AdminVendorController::class, 'store'])->name('admin.vendor.store');
        Route::put('/vendor/update/{vendor}', [AdminVendorController::class, 'update'])->name('admin.vendor.update');
        Route::get('/vendors', [AdminVendorController::class, 'index'])->name('admin.vendors');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::put('/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    });

    Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
    //Admin authentication routes
    Route::post('/admin/auth', [AuthController::class, 'login'])->name('admin.auth.login');
    Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');


Route::prefix('vendor')->group(function () {
    Route::get('/login', [VendorController::class,'login'])->name('vendor.login');
    Route::get('/success', [VendorController::class, 'success'])->name('vendor.success');
    Route::get('/signup', [VendorController::class, 'signup'])->name('vendor.signup');
    Route::post('/auth', [VendorAuthController::class, 'login'])->name('vendor.auth');
    Route::get('/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout');
});

Route::prefix('vendor')
    ->middleware('vendor.auth')
    ->group(function () {
        Route::get('dashboard',[VendorController::class, 'dashboard'])->name('vendor.dashboard'); 
        Route::get('dashboard',[VendorController::class, 'dashboard'])->name('vendor.dashboard'); 
        Route::get('qr/generate',[VendorController::class, 'generateQr'])->name('vendor.qr.index'); 
        Route::post('qr/save', [QrController::class, 'store'])->name('vendor.qr.store');
    });

Route::get('/logout', function () {
    return view('landingpage');
})->name('logout');


