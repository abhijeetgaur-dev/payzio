<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
  public function allTransactions()
    {
        $vendor= auth('vendor')->user();
        $transactions = Transaction::where('vendor_id', $vendor->id)->get();
        $showStats = 1;

        // --- This Month Stats ---
        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();

        $thisMonthTransactions = Transaction::whereBetween('date', [$thisMonthStart, $thisMonthEnd])
            ->where('status', '1')
            ->where('vendor_id', $vendor->id)
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
            ->where('vendor_id', $vendor->id)
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
        return view('vendor.transactions.index', [
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
        $vendor= auth('vendor')->user();
        $transactions = Transaction::where('vendor_id', $vendor->id)
            ->whereIn('status', ['1', '2'])
            ->get();
        $showStats = 0;
        return view('vendor.transactions.index', [
            'transactions' => $transactions,
            'showStats' => $showStats,
        ]);
    }

    public function pendingTransactions()
    {
        $vendor= auth('vendor')->user();
        $transactions = Transaction::where('vendor_id', $vendor->id)
            ->get()->where('status', '0');

        $showStats = 0;
        return view('vendor.transactions.index', [
            'transactions' => $transactions,
            'showStats' => $showStats,
        ]);
    }

}
