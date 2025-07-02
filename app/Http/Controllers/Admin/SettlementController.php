<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Models\AdminBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class SettlementController extends Controller
{

    private function calculateCommission($vendorId, $totalAmount)
    {
        // Get the vendor's latest active commission rate
        $commissionRate = Transaction::where('vendor_id', $vendorId)
                            ->where('settled', '0') 
                            ->latest()
                            ->value('commission');

        $commissionRate = $commissionRate ?? 0;

        $commissionAmount = ($totalAmount * $commissionRate) / 100;

        return round( $commissionAmount, 2);
    }


      public function pending(Request $request)
    {


        // Get all vendors with unsettled transactions (grouped)
        $query = Transaction::where('settled', '0')
            ->with('vendor')
            ->selectRaw('vendor_id, 
                COUNT(*) as transactions_count, 
                MIN(date) as period_start, 
                MAX(date) as period_end,
                SUM(amount) as total_amount')
            ->groupBy('vendor_id')
            ->orderBy('transactions_count','desc');


        $settlementsData = $query->get()->map(function($item) {
            $vendor = Vendor::find($item->vendor_id);
            
            return [
                'id' => $item->vendor_id, 
                'vendor_id' => $item->vendor_id,
                'vendor_name' => $vendor->vendor_name ?? 'Unknown Vendor',
                'period_start' => Carbon::parse($item->period_start)->format('d M Y'),
                'period_end' => Carbon::parse($item->period_end)->format('d M Y'),
                'transactions_count' => $item->transactions_count,
                'amount' =>  $item->total_amount,
                'commission' => $this->calculateCommission($item->vendor_id, $item->total_amount),
                'account_number' => $vendor->account_number ?? 'N/A',
                'batches_available' => floor($item->transactions_count / 5),
            ];
        });

        $totalAmount = $settlementsData->sum('amount');

        return view('admin.settlements.pending', [
            'settlements' => $settlementsData,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function process($vendorId)
    {
        // Get vendor details
        $vendor = Vendor::findOrFail($vendorId);

        // Get oldest 5 unsettled transactions for this vendor
        $transactions = Transaction::where('vendor_id', $vendorId)
            ->where('settled', '0')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->take(5) // Only take 5 transactions
            ->get();

        // Check if we have exactly 5 transactions to process
        if ($transactions->count() < 5) {
            return redirect()->back()
                ->with('error', "Need 5 transactions to process. Only {$transactions->count()} available.");
        }

        // Calculate commission for this batch
        $batchAmount = $transactions->sum('amount');
        $batchCommission=$batchAmount*($vendor->commission_rate/100);    
        // Mark transactions as settled
        $batchIds = $transactions->pluck('id')->toArray();
        Transaction::whereIn('id', $batchIds)
            ->update([
                'settled' => '1', 
                'commission' => $batchCommission / 5 // Distribute commission evenly
            ]);


        return view('admin.settlements.process')
            ->with('message', "Processed 5 transactions for vendor {$vendor->name}. Commission: " . number_format($batchCommission, 2))
            ->with('processed_transactions', $batchIds);
    }

    public function processShow($vendorId){
        $vendor = Vendor::findorFail($vendorId);
        $adminId = auth('admin')->id();
        $admin = Admin::findorFail($adminId);
        $adminBank = AdminBankAccount::where('admin_id', $adminId)
                ->where('is_primary', 1)
                ->first();

       $query = Transaction::where('settled', '0')
            ->with('vendor')
            ->selectRaw('vendor_id, 
                COUNT(*) as transactions_count, 
                MIN(date) as period_start, 
                MAX(date) as period_end,
                SUM(amount) as total_amount')
            ->groupBy('vendor_id')
            ->orderBy('transactions_count','desc');


        $settlementsData = $query->get()->map(function($item) {
            $vendor = Vendor::find($item->vendor_id);
            
            return [
                'id' => $item->vendor_id, 
                'vendor_id' => $item->vendor_id,
                'vendor_name' => $vendor->vendor_name ?? 'Unknown Vendor',
                'period_start' => Carbon::parse($item->period_start)->format('d M Y'),
                'period_end' => Carbon::parse($item->period_end)->format('d M Y'),
                'transactions_count' => $item->transactions_count,
                'amount' =>  $item->total_amount,
                'commission' => $this->calculateCommission($item->vendor_id, $item->total_amount),
                'account_number' => $vendor->account_number ?? 'N/A',
                'batches_available' => floor($item->transactions_count / 5),
            ];
        });

        $totalCommission = $settlementsData->sum('commission');


        return view('admin.settlements.pending',compact('vendor','adminBank','admin') ,[
            'settlements' => $settlementsData,
            'totalCommission' => $totalCommission
        ]);
    }

    public function processSettlement($vendorId)
    {
        $vendor = Vendor::with('bankDetails')->findOrFail($vendorId);
        $adminBank = BankDetail::where('type', 'admin')->first();
        
        // Get oldest 5 unsettled transactions
        $transactions = Transaction::where('vendor_id', $vendorId)
            ->where('settled', '0')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->take(5)
            ->get();

        if ($transactions->count() < 5) {
            return redirect()->back()
                ->with('error', "Need 5 transactions to process. Only {$transactions->count()} available.");
        }

        $totalAmount = $transactions->sum('amount');
        $commissionAmount = $totalAmount * ($vendor->commission_rate / 100);
        $payoutAmount = $totalAmount - $commissionAmount;

        return view('settlements.process', [
            'vendor' => $vendor,
            'transactions' => $transactions,
            'adminBank' => $adminBank,
            'totalAmount' => $totalAmount,
            'commissionAmount' => $commissionAmount,
            'payoutAmount' => $payoutAmount,
            'processingDate' => now()->format('Y-m-d'),
            'processingTime' => now()->format('H:i:s')
        ]);
    }

    
}