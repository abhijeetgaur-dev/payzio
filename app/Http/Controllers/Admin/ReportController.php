<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Settlement;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function commissionReport(Request $request)
    {
        $allVendors = Vendor::all();
        $settlements = Settlement::with('vendor')->latest();

        // Filters
        if ($request->has('date_from')) {
            $settlements->whereDate('settled_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $settlements->whereDate('settled_at', '<=', $request->date_to);
        }

        if ($request->filled('vendor_id')) {
            $settlements->where('vendor_id', $request->get('vendor_id'));
        }
        $paginatedSettlements = $settlements->paginate(10)->appends($request->all());

        $settlements = $settlements->get();

        $settlementData = [];

        foreach ($settlements as $settlement) {
            foreach (json_decode($settlement->transaction_ids, true) as $transactionId) {
                $transaction = Transaction::where('id', $transactionId)->first();
                $settlementData[] = [
                    'created_at' => $settlement->settled_at,
                    'vendor_name' => $settlement->vendor->vendor_name,
                    'transaction_id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'commission' => $transaction->commission,
                    'commission_amount' => ($transaction->amount * $transaction->commission) / 100,
                    'payout_amount' => $transaction->amount + ($transaction->amount * $transaction->commission) / 100,
                    'vendor_id' => $settlement->vendor_id,
                    'settlement_reference' => $settlement->settlement_reference,
                    'vendor_bank_details' => $settlement->vendor_bank_details,
                ];
            }
        }

        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();

        $thisMonthSettlements = Settlement::whereBetween('settled_at', [$thisMonthStart, $thisMonthEnd])->get();

        $thisMonthTransactions = 0;
        $thisMonthAmount = 0;
        $thisMonthCommission = 0;

        foreach ($thisMonthSettlements as $settlement) {
            $transactionIds = json_decode($settlement->transaction_ids, true);
            foreach ($transactionIds as $transactionId) {
                $transaction = Transaction::find($transactionId);
                if ($transaction) {
                    $thisMonthTransactions++;
                    $thisMonthAmount += $transaction->amount;
                    $thisMonthCommission += ($transaction->amount * $transaction->commission) / 100;
                }
            }
        }

        // ----- LAST MONTH TOTALS ----- //
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        $lastMonthSettlements = Settlement::whereBetween('settled_at', [$lastMonthStart, $lastMonthEnd])->get();

        $lastMonthTransactions = 0;
        $lastMonthAmount = 0;
        $lastMonthCommission = 0;

        foreach ($lastMonthSettlements as $settlement) {
            $transactionIds = json_decode($settlement->transaction_ids, true);
            foreach ($transactionIds as $transactionId) {
                $transaction = Transaction::find($transactionId);
                if ($transaction) {
                    $lastMonthTransactions++;
                    $lastMonthAmount += $transaction->amount;
                    $lastMonthCommission += ($transaction->amount * $transaction->commission) / 100;
                }
            }
        }

        // ----- % COMPARISON ----- //
        $transactionChange = $lastMonthTransactions > 0 ? round((($thisMonthTransactions - $lastMonthTransactions) / $lastMonthTransactions) * 100, 2) : 0;
        $amountChange = $lastMonthAmount > 0 ? round((($thisMonthAmount - $lastMonthAmount) / $lastMonthAmount) * 100, 2) : 0;
        $commissionChange = $lastMonthCommission > 0 ? round((($thisMonthCommission - $lastMonthCommission) / $lastMonthCommission) * 100, 2) : 0;
        return view('admin.reports.commissions', [
            'paginatedSettlements' => $paginatedSettlements,
            'settlementData' => $settlementData,
            'thisMonthTransactions' => $thisMonthTransactions,
            'thisMonthAmount' => $thisMonthAmount,
            'thisMonthCommission' => $thisMonthCommission,
            'transactionChange' => $transactionChange,
            'amountChange' => $amountChange,
            'commissionChange' => $commissionChange,
            'allVendors' => $allVendors,
        ]);
    }

    public function vendorReport(Request $request)
    {
        $allVendors = Vendor::all();

        $settlements = Settlement::with('admin', 'vendor')->latest();

        // Use filled() instead of has()
        if ($request->filled('date_from')) {
            $settlements->whereDate('settled_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $settlements->whereDate('settled_at', '<=', $request->date_to);
        }

        if ($request->filled('vendor_id')) {
            $settlements->where('vendor_id', $request->vendor_id);
        }

        $settlements = $settlements->paginate(10)->appends($request->all());

        return view('admin.reports.vendorPayment', compact('settlements', 'allVendors'));
    }
}
