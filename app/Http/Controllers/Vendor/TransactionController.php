<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(){
        return view('vendor.transactions.allTransactions');
    }

    public function completedTransactions(){
        return view('vendor.transactions.completed');
    }

    public function pendingTransactions(){
        return view('vendor.transactions.pending');
    }
}
