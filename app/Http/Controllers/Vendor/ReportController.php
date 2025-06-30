<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
        public function commissions(Request $request)
    {
        $vendors = Vendor::all()->toArray();

        // Generate dummy commission data
        $commissionRates= [2.5,5,7.5,10];
        $commissions= [];
        $statuses = ['pending', 'paid', 'cancelled'];
        
        foreach ($vendors as $vendor) {
            for ($i = 0; $i < 5; $i++) {
                $amount = rand(50, 500);
                $date = now()->subDays(rand(0, 90));
                $status = $statuses[array_rand($statuses)];
                $commissions[] = [
                    'id' => uniqid(),
                    'vendor_id' => $vendor['id'],
                    'vendor_name' => $vendor['vendor_name'],
                    'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                    'amount' => $amount,
                    'commissionPercentage' => $commissionRates[rand(0,3)],
                    'status' => $status,
                    'created_at' => $date->format('Y-m-d H:i:s'),
                    'paid_at' => $status === 'paid' ? $date->addDays(rand(1, 5))->format('Y-m-d H:i:s') : null,
                ];
            }
        }

        // Filtering logic
        if ($request->has('vendor')) {
            $vendorId = $request->vendor;
            $commissions = array_filter($commissions, function($item) use ($vendorId) {
                return $item['vendor_id'] == $vendorId;
            });
        }

        if ($request->has('status') && $request->status !== 'all') {
            $status = $request->status;
            $commissions = array_filter($commissions, function($item) use ($status) {
                return $item['status'] == $status;
            });
        }

        if ($request->has('date_from')) {
            $dateFrom = Carbon::parse($request->date_from);
            $commissions = array_filter($commissions, function($item) use ($dateFrom) {
                return Carbon::parse($item['created_at']) >= $dateFrom;
            });
        }

        if ($request->has('date_to')) {
            $dateTo = Carbon::parse($request->date_to);
            $commissions = array_filter($commissions, function($item) use ($dateTo) {
                return Carbon::parse($item['created_at']) <= $dateTo;
            });
        }

        // Calculate totals
        $totalCommission = array_sum(array_column($commissions, 'commission'));
        $totalAmount = array_sum(array_column($commissions, 'amount'));

        return view('vendor.reports.commissions', [
            'commissions' => $commissions,
            'vendors' => $vendors,
            'totalCommission' => $totalCommission,
            'totalAmount' => $totalAmount,
            'filters' => $request->all(),
        ]);
    }

    public function vendorPayment(Request $request)
    {
        // Generate dummy vendors
        $vendors = [
            ['id' => 1, 'name' => 'Vendor A', 'account_number' => '****1234'],
            ['id' => 2, 'name' => 'Vendor B', 'account_number' => '****5678'],
            ['id' => 3, 'name' => 'Vendor C', 'account_number' => '****9012'],
            ['id' => 4, 'name' => 'Vendor D', 'account_number' => '****3456'],
        ];

        // Generate dummy payment methods
        $paymentMethods = ['Bank Transfer', 'Check', 'PayPal', 'Wire Transfer', 'Credit Card'];

        // Generate dummy payment statuses
        $statuses = ['Completed', 'Pending', 'Failed', 'Processing', 'Refunded'];

        // Generate dummy payment data
        $payments = [];
        
        for ($i = 1; $i <= 30; $i++) {
            $paymentDate = now()->subDays(rand(0, 90));
            $vendor = $vendors[array_rand($vendors)];
            $amount = rand(100, 5000);
            $fee = $amount * 0.02; // 2% fee
            $netAmount = $amount - $fee;
            
            $payments[] = [
                'id' => $i,
                'reference' => 'PAY-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'vendor_id' => $vendor['id'],
                'vendor_name' => $vendor['name'],
                'account_number' => $vendor['account_number'],
                'amount' => $amount,
                'fee' => $fee,
                'net_amount' => $netAmount,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'status' => $statuses[array_rand($statuses)],
                'payment_date' => $paymentDate->format('Y-m-d H:i:s'),
                'processed_by' => 'Admin ' . rand(1, 5),
                'notes' => ['Monthly payment', 'Service fee', 'Product purchase', 'Contract payment'][rand(0, 3)],
            ];
        }

        // Filter by date range if provided
        if ($request->has('from_date') && !empty($request->from_date)) {
            $fromDate = Carbon::parse($request->from_date)->startOfDay();
            $payments = array_filter($payments, function($payment) use ($fromDate) {
                return Carbon::parse($payment['payment_date']) >= $fromDate;
            });
        }

        if ($request->has('to_date') && !empty($request->to_date)) {
            $toDate = Carbon::parse($request->to_date)->endOfDay();
            $payments = array_filter($payments, function($payment) use ($toDate) {
                return Carbon::parse($payment['payment_date']) <= $toDate;
            });
        }

        // Filter by vendor if provided
        if ($request->has('vendor') && !empty($request->vendor)) {
            $payments = array_filter($payments, function($payment) use ($request) {
                return $payment['vendor_id'] == $request->vendor;
            });
        }

        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $payments = array_filter($payments, function($payment) use ($request) {
                return $payment['status'] == $request->status;
            });
        }

        // Calculate totals
        $totalAmount = array_sum(array_column($payments, 'amount'));
        $totalFees = array_sum(array_column($payments, 'fee'));
        $totalNet = array_sum(array_column($payments, 'net_amount'));

        return view('vendor.reports.vendorPayment', [
            'payments' => $payments,
            'vendors' => $vendors,
            'paymentMethods' => $paymentMethods,
            'statuses' => $statuses,
            'totalAmount' => $totalAmount,
            'totalFees' => $totalFees,
            'totalNet' => $totalNet,
            'filters' => $request->all(),
        ]);
    }

}
