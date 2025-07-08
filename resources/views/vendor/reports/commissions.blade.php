@extends('layouts.vendor')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 ">Commission Reports</h1>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
            <form action="" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Vendor Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vendor</label>
                        <div class="relative flex-1 md:mr-4">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search-input"
                                placeholder="Search transactions by ID, vendor, or customer..."
                                class="pl-10 pr-4 py-2 w-full border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Amount</label>
                        <input type="number" name="amount_min" value="{{ request('amount_min') }}" placeholder="₹0.00"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Amount</label>
                        <input type="number" name="amount_max" value="{{ request('amount_max') }}" placeholder="₹10,000.00"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Date</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">To Date</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('admin.reports.commissions') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Reset</a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Apply
                        Filters</button>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Total Transactions (This Month) -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Transactions (This Month)</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $thisMonthTransactions }}</p>
                @if ($transactionChange !== 0)
                    <span class="text-sm ml-2 {{ $transactionChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ abs($transactionChange) }}%
                        <i class="fas {{ $transactionChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                        from last month
                    </span>
                @endif
            </div>

            <!-- Total Amount (This Month) -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Amount (This Month)</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                    ₹{{ number_format($thisMonthAmount, 2) }}
                </p>
                @if ($amountChange !== 0)
                    <span class="text-sm ml-2 {{ $amountChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ abs($amountChange) }}%
                        <i class="fas {{ $amountChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                        from last month
                    </span>
                @endif
            </div>

            <!-- Total Commission (This Month) -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Commission (This Month)</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                    ₹{{ number_format($thisMonthCommission, 2) }}
                </p>
                @if ($commissionChange !== 0)
                    <span class="text-sm ml-2 {{ $commissionChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ abs($commissionChange) }}%
                        <i class="fas {{ $commissionChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                        from last month
                    </span>
                @endif
            </div>
        </div>
        <!-- Commission Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Settlement Id</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Settlement Date</th>

                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Transaction ID</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Amount</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Commission %</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Commission Amount</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Net Amount</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Bank Account</th>
                            {{-- <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status</th> --}}
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($settlementData as $settlement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $settlement['settlement_reference'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $settlement['created_at']->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $settlement['created_at']->format('h:i A') }} </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $settlement['transaction_id'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    ₹{{ number_format($settlement['amount'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ number_format($settlement['commission'], 1) }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    ₹{{ number_format($settlement['commission_amount'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    ₹{{ number_format($settlement['payout_amount'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    <div class="text-xs">
                                        <strong>Bank:</strong>
                                        {{ $settlement['vendor_bank_details']['bank_name'] ?? 'N/A' }}<br>
                                        <strong>Account No:</strong>
                                        {{ $settlement['vendor_bank_details']['account_number'] ?? 'N/A' }}<br>
                                        <strong>Holder:</strong>
                                        {{ $settlement['vendor_bank_details']['account_holder'] ?? 'N/A' }}
                                    </div>
                                </td>
                                {{-- <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $settlement['status'] === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                {{$settlement['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                {{ $settlement['status'] === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}">
                                        {{ ucfirst($commission['status']) }}
                                    </span>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                    No commissions found matching your criteria
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
