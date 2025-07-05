<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Vendor;

class TransactionController extends Controller
{
    public function allTransactions(){
        $transactions = Transaction::with('vendor')->get();

        return view('admin.transactions.all', [
            'transactions' => $transactions
        ]);
    }


    public function completedTransactions(){
        $transactions = Transaction::with('vendor')->where('status', "1")->get();
        return view('admin.transactions.completed', [
            'transactions' => $transactions
        ]);
    }

    public function pendingTransactions(){
        $transactions = Transaction::with('vendor')->where('status', "0")->get();
        return view('admin.transactions.completed', [
            'transactions' => $transactions
        ]);
    }

    public function approveTransaction($transactionId)
    {
        try {
            $transaction = Transaction::findOrFail($transactionId); 
            $transaction->status = "1";
            $transaction->save();

            return redirect()->route('admin.transactions.completed')
                            ->with('success', 'Transaction approved successfully.');
        } catch (\Exception $e) {
            \Log::error('Error changing transaction status: ' . $e->getMessage());
            return back()->with('error', 'Error updating status of the transaction.');
        }
    }

    public function viewTransaction($transactionId){
        $transaction = Transaction::findOrFail($transactionId); 

        return view('admin.transactions.viewTransaction',compact('transaction'));
    }

}
