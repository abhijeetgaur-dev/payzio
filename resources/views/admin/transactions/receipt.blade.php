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
            <h1 class="text-3xl font-bold text-gray-800">Print Receipt</h1>
        </div>
        <div
            class="max-w-md mx-auto my-10 bg-white p-6 rounded-lg shadow-md border print:shadow-none print:border-none print:rounded-none print:p-0 print:m-0 print:w-full">
            <!-- Header -->
            <div class="text-center border-b pb-4 mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Payzio</h1>
                <p class="text-xl text-gray-600">Official Payment Receipt</p>
                <p class="text-lg text-gray-400 mt-1">Transaction ID: {{ $transaction->id }}</p>
            </div>

            <!-- Details -->
            <div class="space-y-4 text-lg text-gray-800">
                <!-- Date & Time -->
                <div class="flex justify-between">
                    <span><strong>Date:</strong> {{ $transaction->created_at->format('d M Y') }}</span>
                    <span><strong>Time:</strong> {{ $transaction->created_at->format('h:i A') }}</span>
                </div>

                <!-- Customer Info -->
                <div class="flex justify-between">
                    <span><strong>Customer ID:</strong></span>
                    <span>{{ $transaction->cust_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span><strong>Machine ID:</strong></span>
                    <span>{{ $transaction->cust_machine_id }}</span>
                </div>

                <!-- Vendor Info -->
                <div class="flex justify-between">
                    <span><strong>Vendor Name:</strong></span>
                    <span>{{ $transaction->vendor->vendor_name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span><strong>Phone:</strong></span>
                    <span>{{ $transaction->vendor->phone ?? 'N/A' }}</span>
                </div>

                <!-- Payment Details -->
                <div class="flex justify-between">
                    <span><strong>Amount Paid:</strong></span>
                    <span>₹{{ number_format($transaction->amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span><strong>Payment Method:</strong></span>
                    <span>{{ ucfirst($transaction->paid_by) }}</span>
                </div>
                <div class="flex justify-between">
                    <span><strong>Commission:</strong></span>
                    <span>{{ $transaction->commission ? $transaction->commission . '%' : 'N/A' }}</span>
                </div>

                <!-- Status -->
                <div class="flex justify-between">
                    <span><strong>Status:</strong></span>
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
                @if ($transaction->status != 2)
                    <div class="flex justify-between">
                        <span><strong>Settlement:</strong></span>
                        <span
                            class=" px-2 inline-flex text-lg leading-5 font-semibold rounded-full {{ $transaction->settled == true ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $transaction->settled == true ? 'Settled' : 'Pending' }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Print Button -->
            <div class="mt-8 text-center print:hidden">
                <button onclick="window.print()"
                    class="text-lg bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded transition">
                    Print Receipt
                </button>
            </div>
        </div>
    </div>

    <!-- Print Cleanup -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .max-w-md,
            .max-w-md * {
                visibility: visible !important;
            }

            .max-w-md {
                position: absolute !important;
                left: 0;
                top: 0;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                background: white !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .print\:hidden {
                display: none !important;
            }
        }
    </style>
@endsection
