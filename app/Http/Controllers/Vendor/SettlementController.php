<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Transaction;
use App\Models\Settlement;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class SettlementController extends Controller
{
    public function pending(Request $request)
    {
        // Get all vendors with unsettled transactions (grouped)
        $vendor = auth('vendor')->user();

        // Fetch the 5 oldest unsettled transactions for this vendor
        $oldestTransactions = Transaction::where('vendor_id',$vendor->id )
            ->where('settled', '0')
            ->where('status', '1')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return view('vendor.settlements.pending', [
            'transactions' => $oldestTransactions
        ]);
    }

    public function completed(Request $request)
    {
        $vendor = auth('vendor')->user();
        $settlementsRaw = Settlement::where('status', '1') 
            ->where('vendor_id', $vendor->id)
            ->orderByDesc('settled_at')
            ->get();


        $settlementsData = $settlementsRaw->map(function ($settlement) {
            $transactionIds = explode(',', $settlement->transaction_ids); // assuming comma-separated

            // Fetch transactions to get min/max date
            $transactions = Transaction::whereIn('id', $transactionIds)->get();
            $periodStart = $transactions->min('date');
            $periodEnd = $transactions->max('date');

            return [
                'id' => $settlement->id,
                'settlement_reference' => $settlement->settlement_reference,
                'vendor_bank_details' => $settlement->vendor_bank_details,
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
        return view('vendor.settlements.completed', [
            'settlementData' => $settlementsData,
            'totalAmount' => $totalAmount,
            'totalCommission' => $totalCommission,
        ]);
    }
}
