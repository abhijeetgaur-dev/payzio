@extends('layouts.admin')

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
            <!-- Total Transactions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Transactions (This Month)</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $thisMonthTransactions }}</p>
                @if ($transactionChange)
                    <span class="text-sm ml-2 {{ $transactionChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ abs($transactionChange) }}%
                        <i class="fas {{ $transactionChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                        from last month
                    </span>
                @endif
            </div>

            <!-- Total Amount -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Amount (This Month)</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                    ₹{{ number_format($thisMonthAmount, 2) }}</p>
                @if ($amountChange)
                    <span class="text-sm ml-2 {{ $amountChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ abs($amountChange) }}%
                        <i class="fas {{ $amountChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                        from last month
                    </span>
                @endif
            </div>

            <!-- Total Commission -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Commission (This Month)</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                    ₹{{ number_format($thisMonthCommission, 2) }}</p>
                @if ($commissionChange)
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
                                Vendor</th>
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
                                Vendor Bank Account</th>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $settlement['vendor_name'] }}
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

        {{-- <!-- Chart Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Commission by Vendor</h2>
                <canvas id="vendorChart" height="300"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Commission by Status</h2>
                <canvas id="statusChart" height="300"></canvas>
            </div>
        </div>
    </div> --}}

        {{-- @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Vendor Chart
                    const vendorCtx = document.getElementById('vendorChart').getContext('2d');
                    const vendorChart = new Chart(vendorCtx, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode(array_column($vendors, 'name')) !!},
                            datasets: [{
                                label: 'Commission ($)',
                                data: {!! json_encode(
                                    array_map(function ($vendor) use ($commissions) {
                                        return array_sum(
                                            array_map(function ($c) use ($vendor) {
                                                return $c['vendor_id'] === $vendor['id'] ? $c['commissionPercentage'] * $c['amount'] : 0;
                                            }, $commissions),
                                        );
                                    }, $vendors),
                                ) !!},
                                backgroundColor: 'rgba(79, 70, 229, 0.7)',
                                borderColor: 'rgba(79, 70, 229, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Status Chart
                    const statusCtx = document.getElementById('statusChart').getContext('2d');
                    const statusChart = new Chart(statusCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Paid', 'Pending', 'Cancelled'],
                            datasets: [{
                                data: [
                                    {{ array_sum(array_map(function ($c) {return $c['status'] === 'paid' ? $c['commissionPercentage'] * $c['amount'] : 0;}, $commissions)) }},
                                    {{ array_sum(array_map(function ($c) {return $c['status'] === 'pending' ? $c['commissionPercentage'] * $c['amount'] : 0;}, $commissions)) }},
                                    {{ array_sum(array_map(function ($c) {return $c['status'] === 'cancelled' ? $c['commissionPercentage'] * $c['amount'] : 0;}, $commissions)) }}
                                ],
                                backgroundColor: [
                                    'rgba(16, 185, 129, 0.7)',
                                    'rgba(245, 158, 11, 0.7)',
                                    'rgba(239, 68, 68, 0.7)'
                                ],
                                borderColor: [
                                    'rgba(16, 185, 129, 1)',
                                    'rgba(245, 158, 11, 1)',
                                    'rgba(239, 68, 68, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'right',
                                }
                            }
                        }
                    });
                });
            </script>
        @endpush --}}
    @endsection
