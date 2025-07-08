@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-6">Process Settlement</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Transaction Details -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Transaction Summary</h3>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Vendor:</p>
                        <p class="font-medium">{{ $vendor->vendor_name }} (ID: {{ $vendor->id }})</p>
                    </div>
                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-2 font-semibold">Transaction ID</th>
                                    <th class="px-4 py-2 font-semibold">Amount</th>
                                    <th class="px-4 py-2 font-semibold">Commission</th>
                                    <th class="px-4 py-2 font-semibold">Commission Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($transactions as $transaction)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $transaction->id }}</td>
                                        <td class="px-4 py-2">₹{{ number_format($transaction->amount, 2) }}</td>
                                        <td class="px-4 py-2">{{ number_format($transaction->commission, 2) }}%</td>
                                        <td class="px-4 py-2">
                                            ₹{{ number_format(($transaction->commission * $transaction->amount) / 100, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 font-semibold text-gray-700">
                                <tr>
                                    <td colspan="1" class="px-4 py-2 text-right">Total:</td>
                                    <td class="px-4 py-2">₹{{ number_format($totalAmount, 2) }}</td>
                                    <td class="px-4 py-2"></td>
                                    <td class="px-4 py-2">₹{{ number_format($totalCommission, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>


                    <div class="grid grid-cols-3 gap-4 mt-4">
                        <div class="border p-3 rounded">
                            <p class="text-sm text-gray-600">Total Transaction Amount</p>
                            <p class="font-bold text-lg">₹{{ number_format($totalAmount, 2) }}</p>
                        </div>
                        <div class="border p-3 rounded">
                            <p class="text-sm text-gray-600">Total Commission</p>
                            <p class="font-bold text-lg">₹{{ number_format($totalCommission, 2) }}</p>
                        </div>
                        <div class="border p-3 rounded bg-green-50">
                            <p class="text-sm text-gray-600">Payout Amount</p>
                            <p class="font-bold text-lg text-green-600">₹{{ number_format($payoutAmount, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bank Details -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Bank Transfer Details</h3>

                    <form action="" method="POST">
                        @csrf

                        <input type="hidden" name="processed_at" value="{{ now() }}">

                        <!-- Admin Bank Details -->
                        <div class="mb-6 p-4 border rounded bg-gray-50">
                            <h4 class="font-medium mb-3">Admin Bank Account</h4>
                            <div class="space-y-2">
                                <p class="text-sm"><span class="text-gray-600">Bank:</span> {{ $adminBank->bank_name }}</p>
                                <p class="text-sm"><span class="text-gray-600">Account:</span>
                                    {{ $adminBank->account_number }}</p>
                                <p class="text-sm"><span class="text-gray-600">IFSC:</span> {{ $adminBank->ifsc_code }}</p>
                                <p class="text-sm"><span class="text-gray-600">Branch:</span> {{ $adminBank->branch_name }}
                                </p>
                            </div>
                            <input type="hidden" name="admin_bank_id" value="{{ $adminBank->id }}">
                        </div>

                        <!-- Vendor Bank Details -->
                        <div class="mb-6 p-4 border rounded bg-blue-50">
                            <h4 class="font-medium mb-3">Vendor Bank Account</h4>
                            @if ($vendor)
                                <div class="space-y-2">
                                    <p class="text-sm"><span class="text-gray-600">Bank:</span>
                                        {{ $vendor->bank_name }}</p>
                                    <p class="text-sm"><span class="text-gray-600">Account:</span>
                                        {{ $vendor->account_number }}</p>
                                    <p class="text-sm"><span class="text-gray-600">IFSC:</span>
                                        {{ $vendor->ifsc_code }}</p>
                                    <p class="text-sm"><span class="text-gray-600">Account Name:</span>
                                        {{ $vendor->account_holder }}</p>
                                </div>
                                <input type="hidden" name="vendor_bank_id" value="{{ $vendor->id }}">
                            @else
                                <p class="text-red-500 text-sm">No bank details found for this vendor!</p>
                            @endif
                        </div>

                        <!-- UTR Number -->
                        {{-- <div class="mb-4">
                            <label for="utr_number" class="block text-sm font-medium text-gray-700 mb-1">UTR/Reference
                                Number</label>
                            <input type="text" id="utr_number" name="utr_number" required
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div> --}}

                        <!-- Processing Date -->
                        <div class="mb-4 bg-gray-200 p-2 rounded-md">
                            <label for="processed_at" class="block text-sm font-medium text-gray-700 mb-1">Processing Date &
                                Time</label>
                            <span>{{ now()->format('F j, Y \a\t g:i A') }}</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="{{ route('admin.settlements.pending') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Cancel
                            </a>
                            <form method="POST" action="{{ route('admin.settlements.process', $vendor->id) }}">
                                @csrf
                                <input type="hidden" name="transaction_ids"
                                    value="{{ json_encode($transactions->pluck('id')) }}">
                                <input type="hidden" name="admin_bank_details" value="{{ $adminBank }}">
                                <input type="hidden" name="total_commission" value="{{ $totalCommission }}">
                                <input type="hidden" name="total_transaction_amount" value="{{ $totalAmount }}">
                                <input type="hidden" name="total_payout_amount" value="{{ $payoutAmount }}">

                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Confirm Settlement
                                </button>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
