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
        $settlements = Settlement::with('vendor')->latest();

        // Filters
        if ($request->has('date_from')) {
            $settlements->whereDate('settled_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $settlements->whereDate('settled_at', '<=', $request->date_to);
        }

        if ($request->has('amount_min')) {
            $settlements->where('total_amount', '>=', $request->amount_min);
        }

        if ($request->has('amount_max')) {
            $settlements->where('total_amount', '<=', $request->amount_max);
        }

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

        return view('admin.reports.commissions', compact(
            'settlementData',
            'thisMonthTransactions',
            'thisMonthAmount',
            'thisMonthCommission',
            'transactionChange',
            'amountChange',
            'commissionChange'));
    }

    public function vendorReport(Request $request)
    {
        $settlements = Settlement::with('admin', 'vendor')->latest();

        // Filters
        if ($request->has('date_from')) {
            $settlements->whereDate('settled_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $settlements->whereDate('settled_at', '<=', $request->date_to);
        }

        if ($request->has('amount_min')) {
            $settlements->where('total_amount', '>=', $request->amount_min);
        }

        if ($request->has('amount_max')) {
            $settlements->where('total_amount', '<=', $request->amount_max);
        }

        $settlements = $settlements->get();

        return view('admin.reports.vendorPayment', compact('settlements'));
    }
}
