<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;

class SettlementController extends Controller
{ 

       public function pending(Request $request)
    {
        // Generate dummy vendors
        $loggedInVendor = auth('vendor')->user();

        $vendor = Vendor::where('id', $loggedInVendor->id)->first()-> toArray();
        
        // Generate dummy pending settlements
        $settlements = [];
        
            $date = now()->subDays(rand(1, 30));
            for( $i=0; $i<rand(5, 15); $i++){
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
            $settlements = array_filter($settlements, function($item) use ($vendorId) {
                return $item['vendor_id'] == $vendorId;
            });
        }

        if ($request->has('amount_min')) {
            $amountMin = $request->amount_min;
            $settlements = array_filter($settlements, function($item) use ($amountMin) {
                return $item['amount'] >= $amountMin;
            });
        }

        if ($request->has('amount_max')) {
            $amountMax = $request->amount_max;
            $settlements = array_filter($settlements, function($item) use ($amountMax) {
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
        // Generate dummy vendors
        $loggedInVendor = auth('vendor')->user();

        $vendor = Vendor::where('id', $loggedInVendor->id)->first()-> toArray();
        
        // Generate dummy pending settlements
        $settlements = [];
        
            $date = now()->subDays(rand(1, 30));
            for( $i=0; $i<rand(5, 15); $i++){
                $amount = rand(100, 5000);
                $settlements[$i] = [
                    'id' => uniqid(),
                    'vendor_id' => $vendor['id'],
                    'vendor_name' => $vendor['vendor_name'],
                    'account_number' => $vendor['account_number'],
                    'commission' => $amount * 0.05, // Assuming a 5% commission
                    'amount' => $amount,
                    'reference' => 'SET-' . strtoupper(uniqid()),
                    'period_start' => $date->format('Y-m-d'),
                    'period_end' => $date->addDays(rand(7, 30))->format('Y-m-d'),
                    'transactions_count' => rand(3, 15),
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'status' => 'completed',
                     'qr_code' => 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode('SET-' . strtoupper(uniqid())) . '&size=100x100',
                ];
            }


        // Filtering logic
        if ($request->has('vendor')) {
            $vendorId = $request->vendor;
            $settlements = array_filter($settlements, function($item) use ($vendorId) {
                return $item['vendor_id'] == $vendorId;
            });
        }

        if ($request->has('amount_min')) {
            $amountMin = $request->amount_min;
            $settlements = array_filter($settlements, function($item) use ($amountMin) {
                return $item['amount'] >= $amountMin;
            });
        }

        if ($request->has('amount_max')) {
            $amountMax = $request->amount_max;
            $settlements = array_filter($settlements, function($item) use ($amountMax) {
                return $item['amount'] <= $amountMax;
            });
        }

        return view('vendor.settlements.completed', [
            'settlements' => $settlements,
            'vendors' => $vendor,
            'totalAmount' => array_sum(array_column($settlements, 'amount')),
            'filters' => $request->all(),
        ]);
    }




}
