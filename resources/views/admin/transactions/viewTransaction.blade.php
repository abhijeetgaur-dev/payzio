@extends('layouts.admin')
@php
    $previousUrl = url()->previous();
    $currentUrl = url()->current();
    $backUrl = $previousUrl !== $currentUrl ? $previousUrl : route('admin.transactions.all');
@endphp

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-start items-center mb-6 space-x-4">
            <a href="{{ $backUrl }}"
                class="text-indigo-600 dark:text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400">
                <i class="fas fa-arrow-left text-2xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Transaction Details</h1>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <!-- Transaction Header -->
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Transaction #{{ $transaction->id }}
                </h3>
                {{-- 
                <p class="mt-1 max-w-2xl text-lg text-gray-500">
                    Processed on {{ $transaction->created_at->format('d M Y') }}
                    {{ $transaction->created_at->format('h:i A') }}
                </p> --}}
            </div>

            <!-- Transaction Details -->
            <div class="border-t border-gray-200">
                <dl class="divide-y divide-gray-200">
                    <!-- Customer Information -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-lg font-medium text-gray-500">
                            Customer Information
                        </dt>
                        <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">Customer ID: {{ $transaction->cust_id }}</div>
                            <div>Machine ID: {{ $transaction->cust_machine_id }}</div>
                        </dd>
                    </div>

                    <!-- Date & Time -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-lg font-medium text-gray-500">
                            Date & Time
                        </dt>
                        <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">Date: {{ $transaction->created_at->format('d M Y') }}</div>
                            <div>Time: {{ $transaction->created_at->format('h:i A') }}</div>
                        </dd>
                    </div>

                    <!-- Vendor Information -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-lg font-medium text-gray-500">
                            Vendor Information
                        </dt>
                        <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">Vendor ID: {{ $transaction->vendor_id }}</div>
                            @if ($transaction->vendor)
                                <div class="mb-2">Name: {{ $transaction->vendor->vendor_name }}</div>
                                <div>Contact: {{ $transaction->vendor->phone ?? 'N/A' }}</div>
                            @else
                                <div>Vendor details not available</div>
                            @endif
                        </dd>
                    </div>

                    <!-- Payment Details -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-lg font-medium text-gray-500">
                            Payment Details
                        </dt>
                        <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">Amount: ₹{{ number_format($transaction->amount, 2) }}</div>
                            <div class="mb-2">Payment Method: {{ ucfirst($transaction->paid_by) }}</div>
                            <div>Commission: {{ $transaction->commission ? $transaction->commission . '%' : 'N/A' }}</div>
                        </dd>
                    </div>

                    <!-- Status Information -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-lg font-medium text-gray-500">
                            Status Information
                        </dt>
                        <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">
                                Status:
                                <span
                                    class="px-2 inline-flex text-lg leading-5 font-semibold rounded-full 
                                    @if ($transaction->status === 1) bg-green-100 text-green-800
                                    @elseif($transaction->status === 2) bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    @if ($transaction->status === 1)
                                        Approved
                                    @elseif($transaction->status === 2)
                                        Rejected
                                    @else
                                        Pending
                                    @endif
                                </span>
                            </div>
                            <div>
                                Settlement:
                                <span
                                    class="px-2
                                    inline-flex text-lg leading-5 font-semibold rounded-full
                                    {{ $transaction->settled == true ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-gray-800' }}">
                                    {{ $transaction->settled == true ? 'Settled' : 'Pending Settlement' }}
                                </span>
                            </div>
                        </dd>
                    </div>

                    <!-- Timestamps -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-lg font-medium text-gray-500">
                            Timestamps
                        </dt>
                        <dd class="mt-1 text-lg text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">Created: {{ $transaction->created_at->format('M d, Y h:i A') }}</div>
                            <div>Last Updated: {{ $transaction->updated_at->format('M d, Y h:i A') }}</div>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Action Buttons -->

        </div>
    </div>
@endsection
