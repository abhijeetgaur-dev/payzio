<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\QrController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\SettlementController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Vendor\QrController as VendorQrController;
use App\Http\Controllers\Vendor\TransactionController as VendorTransactionController;
use App\Http\Controllers\Vendor\SettlementController as VendorSettlementController;
use App\Http\Controllers\Vendor\ReportController as VendorReportController;
use App\Http\Controllers\Vendor\TicketController as VendorTicketController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\SettingController as VendorSettingController;



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
            Route::put('/qr/update-status/{qrId}', [QrController::class, 'updateStatus'])->name('admin.vendor.status.update');
            Route::get('/qr/show/{qrId}', [QrController::class, 'show'])->name('admin.qr.show');
            Route::delete('/qr/delete/{qrId}', [QrController::class, 'destroy']);
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

            Route::get('/transactions/all', [TransactionController::class, 'allTransactions'])->name('admin.transactions.all');
            Route::get('/transactions/completed', [TransactionController::class, 'completedTransactions'])->name('admin.transactions.completed');
            Route::get('/transactions/pending', [TransactionController::class, 'pendingTransactions'])->name('admin.transactions.pending');
            Route::get('/transactions/view/{transactionId}', [TransactionController::class, 'show'])->name('admin.transactions.show');
            Route::get('/transactions/approve/{transactionId}', [TransactionController::class, 'approveTransaction'])->name('admin.transactions.approve');
            Route::get('/transactions/reject/{transactionId}', [TransactionController::class, 'rejectTransaction'])->name('admin.transactions.reject');
            Route::get('/transactions/receipt/{transactionId}', [TransactionController::class, 'receipt'])->name('admin.transactions.receipt');

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


            Route::get('/reports/commissions', [AdminReportController::class, 'commissionReport'])->name('admin.reports.commissions');
            Route::get('/reports/vendorpayment', [AdminReportController::class, 'vendorReport'])->name('admin.reports.vendorpayment');

            // Route::get('/settlements/pending', [AdminController::class, 'pendingSettlements'])->name('admin.settlements.pending');
            Route::get('/settlements/pending', [SettlementController::class, 'pending'])->name('admin.settlements.pending');
            Route::get('/settlements/completed', [SettlementController::class, 'completed'])->name('admin.settlements.completed');
            Route::get('/settlements/process/{vendorId}', [SettlementController::class, 'processShow'])->name('admin.settlements.process.show');
            Route::post('/settlements/process/{vendorId}', [SettlementController::class, 'processSettlement'])->name('admin.settlements.process');

            Route::get('/tickets/raised', [AdminTicketController::class, 'ticketsRaised'])->name('admin.tickets.raised');
            Route::get('/tickets/closed', [AdminTicketController::class, 'ticketsClosed'])->name('admin.tickets.closed');
            Route::get('/tickets/view/{ticketId}', [AdminTicketController::class, 'ticketsView'])->name('admin.tickets.view');
            Route::put('/tickets/view/update-status/{ticketId}', [AdminTicketController::class, 'updateStatus'])->name('admin.tickets.update-status');
            Route::put('/tickets/view/assign-ticket/{ticketId}', [AdminTicketController::class, 'assignTicket'])->name('admin.tickets.assign-ticket');
            Route::put('/tickets/view/assign-priority/{ticketId}', [AdminTicketController::class, 'assignPriority'])->name('admin.tickets.update-priority');
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
                Route::get('qr/show/{qrId}', [VendorQrController::class, 'show'])->name('vendor.qr.show');
                Route::delete('qr/delete/{qrId}', [VendorQrController::class, 'destroy']);

                Route::get('/transactions/all', [VendorTransactionController::class, 'allTransactions'])->name('vendor.transactions.all');
                Route::get('/transactions/completed', [VendorTransactionController::class, 'completedTransactions'])->name('vendor.transactions.completed');
                Route::get('/transactions/pending', [VendorTransactionController::class, 'pendingTransactions'])->name('vendor.transactions.pending');

                Route::get('/settlements/completed', [VendorSettlementController::class, 'completed'])->name('vendor.settlements.completed');
                Route::get('/settlements/pending', [VendorSettlementController::class, 'pending'])->name('vendor.settlements.pending');

                Route::get('/reports/commissions', [VendorReportController::class, 'commissionReport'])->name('vendor.reports.commissions');
                Route::get('/reports/vendorpayment', [VendorReportController::class, 'vendorReport'])->name('vendor.reports.vendorpayment');

                Route::get('/tickets/raised', [VendorTicketController::class, 'ticketsRaised'])->name('vendor.tickets.raised');
                Route::get('/tickets/closed', [VendorTicketController::class, 'ticketsClosed'])->name('vendor.tickets.closed');
                Route::get('/tickets/create', [VendorTicketController::class, 'ticketsCreate'])->name('vendor.tickets.create');
                Route::post('/tickets/create', [VendorTicketController::class, 'ticketsCreateStore'])->name('vendor.tickets.store');

                Route::get('/settings/edit', [VendorSettingController::class, 'edit'])->name('vendor.settings.edit');
                Route::post('/settings/edit', [VendorSettingController::class, 'update'])->name('vendor.settings.update');
                Route::get('/settings/change-password', [VendorSettingController::class, 'changePassword'])->name('vendor.settings.change-password');
                Route::put('/settings/change-password', [VendorSettingController::class, 'changePasswordUpdate'])->name('vendor.settings.change-password');


            });
    });

    Route::get('/logout', function () {
        return view('landingpage');
    })->name('logout');


