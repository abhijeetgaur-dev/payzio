<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Settlement;
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
                ->where('status', '1')
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


    public function processSettlement(Request $request, $vendorId)
    {
        $vendor = Vendor::findOrFail($vendorId);

        $transactionIds = json_decode($request->input('transaction_ids'), true);
        $adminBankDetails = json_decode($request->input('admin_bank_details'), true);

        if (count($transactionIds) < 5) {
            return redirect()->back()->with('error', 'At least 5 transactions are required.');
        }

        $transactions = Transaction::whereIn('id', $transactionIds)
            ->where('vendor_id', $vendorId)
            ->where('settled', '0')
            ->where('status', '1')
            ->get();

        if ($transactions->count() !== 5) {
            return redirect()->back()->with('error', 'One or more selected transactions are already settled.');
        }

        $settlementReference = 'SETTLE-' . str_pad(Settlement::max('id') + 1, 4, '0', STR_PAD_LEFT);

        $settlement = Settlement::create([
            'settlement_reference'   => $settlementReference,
            'settled_at'             => now(),
            'vendor_id'              => $vendorId,
            'transaction_ids'        => json_encode($transactionIds),
            'transaction_amount'     => $request->input('total_transaction_amount'),
            'total_commission'       => $request->input('total_commission'),
            'total_amount'           => $request->input('total_payout_amount'),
            'payment_method'         => 'BANK_TRANSFER',
            'status'                 => '',
            'admin_id'               => auth()->guard('admin')->id(),
            'notes'                  => 'Processed from settlement form.',
            'vendor_bank_details'    => [
                'bank_name'      => $vendor->bank_name,
                'account_number' => $vendor->account_number,
                'account_holder' => $vendor->account_holder,
            ],
            'admin_bank_details'     => $adminBankDetails,
        ]);

        foreach ($transactions as $transaction) {
            $transaction->settled = '1';
            $transaction->settlement_id = $settlement->id; // if applicable
            $transaction->save();
        }

        return redirect()->route('admin.settlements.completed')
            ->with('success', 'Settlement created and 5 transactions processed successfully.');
    }

 public function completed(Request $request)
{
    $settlementsRaw = Settlement::where('status', '1') // 1 = Completed
        ->orderByDesc('settled_at')
        ->get();


    $settlementsData = $settlementsRaw->map(function ($settlement) {
        $vendor = Vendor::find($settlement->vendor_id);
        $transactionIds = explode(',', $settlement->transaction_ids); // assuming comma-separated

        // Fetch transactions to get min/max date
        $transactions = Transaction::whereIn('id', $transactionIds)->get();
        $periodStart = $transactions->min('date');
        $periodEnd = $transactions->max('date');

        return [
            'id' => $settlement->id,
            'settlement_reference' => $settlement->settlement_reference,
            'vendor_id' => $settlement->vendor_id,
            'vendor_name' => $vendor->vendor_name ?? 'Unknown Vendor',
            'account_number' => $vendor->account_number ?? 'N/A',
            'transactions_count' => count($transactionIds),
            'period_start' => $periodStart ? Carbon::parse($periodStart)->format('d M Y') : 'N/A',
            'period_end' => $periodEnd ? Carbon::parse($periodEnd)->format('d M Y') : 'N/A',
            'amount' => $settlement->transaction_amount,
            'commission' => $settlement->total_commission,
            'total_amount' => $settlement->total_amount,
            'settled_at' => $settlement->settled_at,
        ];
    
    });

    // 3. Totals for cards
    $totalAmount = $settlementsData->sum('amount');
    $totalCommission = $settlementsData->sum('commission');

    // 4. Pass to Blade
    return view('admin.settlements.completed', [
        'settlements' => $settlementsData,
        'totalAmount' => $totalAmount,
        'totalCommission' => $totalCommission,
    ]);
}
    
}