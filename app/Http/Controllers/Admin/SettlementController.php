<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\AdminBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class SettlementController extends Controller
{
    public function pending(Request $request)
    {
        // Get all vendors with unsettled transactions (grouped)
        $query = Transaction::where('settled', '0')
            ->where('status','1')
            ->with('vendor')
            ->selectRaw('vendor_id, 
                COUNT(*) as transactions_count, 
                MIN(date) as period_start, 
                MAX(date) as period_end')
            ->groupBy('vendor_id')
            ->orderBy('transactions_count', 'desc');

        $settlementsData = $query->get()->map(function($item) {
            $vendor = Vendor::find($item->vendor_id);

            // Fetch the 5 oldest unsettled transactions for this vendor
            $oldestTransactions = Transaction::where('vendor_id', $item->vendor_id)
                ->where('settled', '0')
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->take(5)
                ->get();

            $totalAmount = $oldestTransactions->sum('amount');
            $totalCommission = $oldestTransactions->sum(function ($txn) {
                return round(($txn->amount * ($txn->commission )) / 100, 2);
            });

            return [
                'id' => $item->vendor_id,
                'vendor_id' => $item->vendor_id,
                'vendor_name' => $vendor->vendor_name ?? 'Unknown Vendor',
                'period_start' => Carbon::parse($item->period_start)->format('d M Y'),
                'period_end' => Carbon::parse($item->period_end)->format('d M Y'),
                'transactions_count' => $item->transactions_count,
                'amount' => $totalAmount,
                'commission' => $totalCommission,
                'account_number' => $vendor->account_number ?? 'N/A',
            ];
        });

    $totalAmount = $settlementsData->sum('amount');
    $totalCommission = $settlementsData->sum('commission');

    return view('admin.settlements.pending', [
        'settlements' => $settlementsData,
        'totalAmount' => $totalAmount,
        'totalCommission' => $totalCommission,
    ]);
}

    public function processShow($vendorId){

        $vendor = Vendor::findOrFail($vendorId);

        // Get oldest 5 unsettled transactions for this vendor
        $transactions = Transaction::where('vendor_id', $vendorId)
            ->where('settled', '0')
            ->where('status', '1')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->take(5) // Only take 5 transactions
            ->get();

        $adminId = auth('admin')->id();
        $admin = Admin::findorFail($adminId);
        $adminBank = AdminBankAccount::where('admin_id', $adminId)
                ->where('is_primary', 1)
                ->first();


        $totalCommission = 0;
        foreach ($transactions as $item) {
            $totalCommission += ($item->commission * $item->amount)/100;
        }
        $totalAmount = $transactions->sum('amount');

        $payoutAmount = $totalAmount + $totalCommission;
        // dd($vendor, $adminBank, $transactions, $totalCommission);

        // dd($transactions);

        return view('admin.settlements.process',compact('vendor','adminBank','admin','transactions') ,[
            'totalCommission' => $totalCommission,
            'totalAmount' => $totalAmount,
            'payoutAmount' => $payoutAmount,
            

        ]);
    }

    public function processSettlement($vendorId)
    {
        $vendor = Vendor::findorFail($vendorId);
        // Get oldest 5 unsettled transactions
        $transactions = Transaction::where('vendor_id', $vendorId)
            ->where('settled', '0')
            ->where('status', '1')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->take(5)
            ->get();

        if ($transactions->count() < 5) {
            return redirect()->back()
                ->with('error', "Need 5 transactions to process. Only {$transactions->count()} available.");
        }

        foreach($transactions as $transaction){
            $transaction->settled = "1";
            $transaction->save();
        }

        return redirect()->route('admin.settlements.completed')->with('success', '5 Transactions Processed Successfully');
    }

    public function completed(Request $request)
    {
        // Get all vendors with unsettled transactions (grouped)
        $query = Transaction::where('settled', '1')
            ->where('status','1')
            ->with('vendor')
            ->selectRaw('vendor_id, 
                COUNT(*) as transactions_count, 
                MIN(date) as period_start, 
                MAX(date) as period_end')
            ->groupBy('vendor_id')
            ->orderBy('transactions_count', 'desc');

        $settlementsData = $query->get()->map(function($item) {
            $vendor = Vendor::find($item->vendor_id);

            $transactions = Transaction::where('vendor_id', $item->vendor_id)
                ->where('settled', '1')
                ->get();

            $vendorTotalAmount = $transactions->sum('amount');

            $vendorTotalCommission = $transactions->sum(function ($txn) {
                $amount = $txn->amount ?? 0;
                $rate = $txn->commission ?? 0;
                return round(($amount * $rate) / 100, 2);
            });


            return [
                'id' => $item->vendor_id,
                'vendor_id' => $item->vendor_id,
                'vendor_name' => $vendor->vendor_name ?? 'Unknown Vendor',
                'period_start' => Carbon::parse($item->period_start)->format('d M Y'),
                'period_end' => Carbon::parse($item->period_end)->format('d M Y'),
                'transactions_count' => $item->transactions_count,
                'amount' => $vendorTotalAmount,
                'commission' => $vendorTotalCommission,
                'account_number' => $vendor->account_number ?? 'N/A',
            ];
        });

        
            $totalAmount = $settlementsData->sum('amount');
            $totalCommission = $settlementsData->sum('commission');

            return view('admin.settlements.completed', [
                'settlements' => $settlementsData,
                'totalAmount' => $totalAmount,
                'totalCommission' => $totalCommission,
            ]);
    }
    
}