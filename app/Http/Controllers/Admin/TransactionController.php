<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Vendor;

class TransactionController extends Controller
{
    public function allTransactions()
    {
        $transactions = Transaction::with('vendor')->get();
        $showStats = 1;

        // --- This Month Stats ---
        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();

        $thisMonthTransactions = Transaction::whereBetween('date', [$thisMonthStart, $thisMonthEnd])
            ->where('status', '1')
            ->get();

        $thisMonthTransactionsCount = $thisMonthTransactions->count();
        $thisMonthAmount = $thisMonthTransactions->sum('amount');

        $thisMonthCommission = 0;
        foreach ($thisMonthTransactions as $transaction) {
            $thisMonthCommission += ($transaction->amount * $transaction->commission) / 100;
        }

        // --- Last Month Stats ---
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        $lastMonthTransactions = Transaction::whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->where('status', '1')
            ->get();

        $lastMonthTransactionsCount = $lastMonthTransactions->count();
        $lastMonthAmount = $lastMonthTransactions->sum('amount');

        $lastMonthCommission = 0;
        foreach ($lastMonthTransactions as $transaction) {
            $lastMonthCommission += ($transaction->amount * $transaction->commission) / 100;
        }

        // --- % Change Calculations ---
        $transactionChange = $lastMonthTransactionsCount > 0 ? round((($thisMonthTransactionsCount - $lastMonthTransactionsCount) / $lastMonthTransactionsCount) * 100, 2) : 0;

        $amountChange = $lastMonthAmount > 0 ? round((($thisMonthAmount - $lastMonthAmount) / $lastMonthAmount) * 100, 2) : 0;

        $commissionChange = $lastMonthCommission > 0 ? round((($thisMonthCommission - $lastMonthCommission) / $lastMonthCommission) * 100, 2) : 0;
        // dd($transactionChange,$thisMonthTransactionsCount);
        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'showStats' => $showStats,
            'transactionChange' => $transactionChange,
            'amountChange' => $amountChange,
            'commissionChange' => $commissionChange,
            'thisMonthTransactionsCount' => $thisMonthTransactionsCount,
            'thisMonthAmount' => $thisMonthAmount,
            'thisMonthCommission' => $thisMonthCommission,
        ]);
    }

    public function completedTransactions()
    {
        $transactions = Transaction::with('vendor')
            ->whereIn('status', ['1', '2'])
            ->get();
        $showStats = 0;
        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'showStats' => $showStats,
        ]);
    }

    public function pendingTransactions()
    {
        $transactions = Transaction::with('vendor')->where('status', '0')->get();
        $showStats = 0;
        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'showStats' => $showStats,
        ]);
    }

    public function approveTransaction($transactionId)
    {
        try {
            $transaction = Transaction::findOrFail($transactionId);
            $transaction->status = '1';
            $transaction->save();

            return redirect()->route('admin.transactions.completed')->with('success', 'Transaction approved successfully.');
        } catch (\Exception $e) {
            \Log::error('Error changing transaction status: ' . $e->getMessage());
            return back()->with('error', 'Error updating status of the transaction.');
        }
    }

    public function rejectTransaction($transactionId)
    {
        try {
            $transaction = Transaction::findOrFail($transactionId);
            $transaction->status = '2';
            $transaction->save();

            return redirect()->route('admin.transactions.completed')->with('success', 'Transaction rejected successfully.');
        } catch (\Exception $e) {
            \Log::error('Error changing transaction status: ' . $e->getMessage());
            return back()->with('error', 'Error updating status of the transaction.');
        }
    }

    public function receipt($id)
    {
        $transaction = Transaction::with('vendor')->findOrFail($id);
        return view('admin.transactions.receipt', compact('transaction'));
    }

    public function show($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);

        return view('admin.transactions.viewTransaction', compact('transaction'));
    }
}
