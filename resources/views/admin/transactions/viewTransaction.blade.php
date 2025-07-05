@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Transaction Details</h1>
            <a href="{{ route('admin.transactions.all') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                Back to All Transactions
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <!-- Transaction Header -->
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Transaction #{{ $transaction->id }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Processed on {{ $transaction->created_at->format('M d, Y \a\t h:i A') }}
                </p>
            </div>

            <!-- Transaction Details -->
            <div class="border-t border-gray-200">
                <dl class="divide-y divide-gray-200">
                    <!-- Customer Information -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Customer Information
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">Customer ID: {{ $transaction->cust_id }}</div>
                            <div>Machine ID: {{ $transaction->cust_machine_id }}</div>
                        </dd>
                    </div>

                    <!-- Date & Time -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Date & Time
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">Date: {{ $transaction->date->format('M d, Y') }}</div>
                            <div>Time: {{ $transaction->time }}</div>
                        </dd>
                    </div>

                    <!-- Vendor Information -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Vendor Information
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">Vendor ID: {{ $transaction->vendor_id }}</div>
                            @if ($transaction->vendor)
                                <div class="mb-2">Name: {{ $transaction->vendor->name }}</div>
                                <div>Contact: {{ $transaction->vendor->contact_info ?? 'N/A' }}</div>
                            @else
                                <div>Vendor details not available</div>
                            @endif
                        </dd>
                    </div>

                    <!-- Payment Details -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Payment Details
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">Amount: ${{ number_format($transaction->amount, 2) }}</div>
                            <div class="mb-2">Payment Method: {{ ucfirst($transaction->paid_by) }}</div>
                            <div>Commission: {{ $transaction->commission ? $transaction->commission . '%' : 'N/A' }}</div>
                        </dd>
                    </div>

                    <!-- Status Information -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Status Information
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">
                                Status:
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->status == '1' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $transaction->status == '1' ? 'Completed' : 'Pending' }}
                                </span>
                            </div>
                            <div>
                                Settlement:
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->settled == '1' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $transaction->settled == '1' ? 'Settled' : 'Pending Settlement' }}
                                </span>
                            </div>
                        </dd>
                    </div>

                    <!-- Timestamps -->
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Timestamps
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="mb-2">Created: {{ $transaction->created_at->format('M d, Y h:i A') }}</div>
                            <div>Last Updated: {{ $transaction->updated_at->format('M d, Y h:i A') }}</div>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Action Buttons -->
            <div class="px-4 py-4 bg-gray-50 text-right sm:px-6 flex justify-between">
                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Transaction
                    </button>
                </form>
                <div>
                    <a href="{{ route('transactions.edit', $transaction->id) }}"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                        Edit Transaction
                    </a>
                    @if ($transaction->settled == '0')
                        <form action="{{ route('transactions.markAsSettled', $transaction->id) }}" method="POST"
                            class="inline">
                            @csrf
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Mark as Settled
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
