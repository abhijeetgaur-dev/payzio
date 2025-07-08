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
        // Generate dummy vendors
        $loggedInVendor = auth('vendor')->user();

        $vendor = Vendor::where('id', $loggedInVendor->id)->first()->toArray();

        // Generate dummy pending settlements
        $settlements = [];

        $date = now()->subDays(rand(1, 30));
        for ($i = 0; $i < rand(5, 15); $i++) {
            $amount = rand(100, 5000);
            $settlements[$i] = [
                'id' => uniqid(),
                'vendor_id' => $vendor['id'],
                'vendor_name' => $vendor['vendor_name'],
                'account_number' => $vendor['account_number'],
                'amount' => $amount,
                'commission' => $amount * 0.05, // Assuming a 5% commission
                'reference' => 'SET-' . strtoupper(uniqid()),
                'period_start' => $date->format('Y-m-d'),
                'period_end' => $date->addDays(rand(7, 30))->format('Y-m-d'),
                'transactions_count' => rand(3, 15),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'status' => 'pending',
                'qr_code' => 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode('SET-' . strtoupper(uniqid())) . '&size=100x100',
            ];
        }

        // Filtering logic
        if ($request->has('vendor')) {
            $vendorId = $request->vendor;
            $settlements = array_filter($settlements, function ($item) use ($vendorId) {
                return $item['vendor_id'] == $vendorId;
            });
        }

        if ($request->has('amount_min')) {
            $amountMin = $request->amount_min;
            $settlements = array_filter($settlements, function ($item) use ($amountMin) {
                return $item['amount'] >= $amountMin;
            });
        }

        if ($request->has('amount_max')) {
            $amountMax = $request->amount_max;
            $settlements = array_filter($settlements, function ($item) use ($amountMax) {
                return $item['amount'] <= $amountMax;
            });
        }

        return view('vendor.settlements.pending', [
            'settlements' => $settlements,
            'vendors' => $vendor,
            'totalAmount' => array_sum(array_column($settlements, 'amount')),
            'filters' => $request->all(),
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
