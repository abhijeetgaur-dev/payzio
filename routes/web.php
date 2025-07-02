<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\QrController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SettlementController;
use App\Http\Controllers\Vendor\QrController as VendorQrController;
use App\Http\Controllers\Vendor\TransactionController as VendorTransactionController;
use App\Http\Controllers\Vendor\SettlementController as VendorSettlementController;
use App\Http\Controllers\Vendor\ReportController as VendorReportController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorController;


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
            Route::get('/transactions/pending', [AdminController::class, 'pendingTransaction'])->name('admin.transactions.pending');

            Route::delete('/vendor/delete/{vendor}', [AdminVendorController::class, 'destroy']);
            Route::get('/vendor/view/{vendor}', [AdminVendorController::class, 'view'])->name('admin.vendor.view');
            Route::put('/vendor/update-status/{vendorId}', [AdminVendorController::class, 'vendorUpdateStatus'])->name('admin.vendor.update.status');
            Route::put('/vendor/update-commission-status/{vendorId}', [AdminVendorController::class, 'updateCommissionStatus'])->name('admin.vendor.update.commission.status');
            Route::get('/vendor/edit/{vendor}', [AdminVendorController::class, 'edit'])->name('admin.vendor.edit');
            Route::get('/vendor/create/', [AdminVendorController::class, 'create'])->name('admin.vendor.create');
            Route::post('/vendor/store/', [AdminVendorController::class, 'store'])->name('admin.vendor.store');
            Route::put('/vendor/update/{vendor}', [AdminVendorController::class, 'update'])->name('admin.vendor.update');
            Route::put('/vendor/update-commission/{vendorId}', [AdminVendorController::class, 'updateCommission'])->name('admin.vendor.update-commission');
            Route::get('/vendor/show-commission/{vendorId}', [AdminVendorController::class, 'showVendorCommission'])->name('admin.vendor.show-commission');
            Route::get('/vendors', [AdminVendorController::class, 'index'])->name('admin.vendors');

            Route::get('/settings/edit', [AdminSettingController::class, 'edit'])->name('admin.settings.edit');
            Route::post('/settings/edit', [AdminSettingController::class, 'update'])->name('admin.settings.update');
            Route::get('/settings/change-password', [AdminSettingController::class, 'changePassword'])->name('admin.settings.change-password');
            Route::put('/settings/change-password', [AdminSettingController::class, 'changePasswordUpdate'])->name('admin.settings.change-password');


            Route::get('/reports/commissions', [AdminController::class, 'commissions'])->name('admin.reports.commissions');
            Route::get('/reports/vendorpayment', [AdminController::class, 'vendorPayment'])->name('admin.reports.vendorpayment');

            // Route::get('/settlements/pending', [AdminController::class, 'pendingSettlements'])->name('admin.settlements.pending');
            Route::get('/settlements/pending', [SettlementController::class, 'pending'])->name('admin.settlements.pending');
            Route::get('/settlements/completed', [AdminController::class, 'completedSettlements'])->name('admin.settlements.completed');
            Route::get('/settlements/process/{vendorId}', [SettlementController::class, 'processShow'])->name('admin.settlements.process');
            Route::post('/settlements/process/{vendorId}', [SettlementController::class, 'process'])->name('admin.settlements.process');

            Route::get('/tickets/raised', [AdminController::class, 'ticketsRaised'])->name('admin.tickets.raised');
            Route::get('/tickets/closed', [AdminController::class, 'ticketsClosed'])->name('admin.tickets.closed');
        });

    Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
    //Admin authentication routes
    Route::post('/admin/auth', [AuthController::class, 'login'])->name('admin.auth.login');
    Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');


    Route::prefix('vendor')->group(function () {
        Route::get('/login', [VendorController::class,'login'])->name('vendor.login');
        Route::get('/success', [VendorController::class, 'success'])->name('vendor.success');
        Route::get('/signup', [VendorController::class, 'signup'])->name('vendor.signup');
        Route::post('/signup', [VendorController::class, 'store'])->name('vendor.store');
        Route::post('/auth', [VendorAuthController::class, 'login'])->name('vendor.auth');
        Route::get('/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout');
    
    //Vendor authentication routes
        Route::middleware('vendor.auth')
            ->group(function () {
                Route::get('dashboard',[VendorController::class, 'dashboard'])->name('vendor.dashboard'); 
                Route::get('qr/index', [VendorQrController::class, 'index'])->name('vendor.qr.index');
                Route::post('qr/save', [VendorQrController::class, 'store'])->name('vendor.qr.store');

                Route::get('/transactions/all', [VendorTransactionController::class, 'index'])->name('vendor.transactions.all');
                Route::get('/transactions/completed', [VendorTransactionController::class, 'completedTransactions'])->name('vendor.transactions.completed');
                Route::get('/transactions/pending', [VendorTransactionController::class, 'pendingTransactions'])->name('vendor.transactions.pending');

                Route::get('/settlements/completed', [VendorSettlementController::class, 'completed'])->name('vendor.settlements.completed');
                Route::get('/settlements/pending', [VendorSettlementController::class, 'pending'])->name('vendor.settlements.pending');

                Route::get('/reports/commissions', [VendorReportController::class, 'commissions'])->name('vendor.reports.commissions');
                Route::get('/reports/vendorpayment', [VendorReportController::class, 'vendorPayment'])->name('vendor.reports.vendorpayment');

                Route::get('/tickets/raised', [VendorController::class, 'ticketsRaised'])->name('vendor.tickets.raised');
                Route::get('/tickets/closed', [VendorController::class, 'ticketsClosed'])->name('vendor.tickets.closed');

                Route::get('/settings', [VendorController::class, 'settings'])->name('vendor.settings');
                Route::put('/settings/update', [VendorController::class, 'updateSettings'])->name('vendor.settings.update');


            });
    });

    Route::get('/logout', function () {
        return view('landingpage');
    })->name('logout');


