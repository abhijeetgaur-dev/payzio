@extends('layouts.admin')

@section('title', 'Transactions List')

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 text-gray-800">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Transactions List</h2>
            <div class="flex space-x-3">
                {{-- <button id="filter-btn"
                    class="cursor-pointer flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-filter mr-2"></i>
                    Advanced Filters
                </button> --}}
            </div>
        </div>


        <!-- Search and Filter Bar -->

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
                            <input type="text" id="search-input" placeholder="Search by vendor name or id..."
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
                    <a href="#"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Reset</a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Apply
                        Filters</button>
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Transactions</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">1,248</p>
                    </div>
                    <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2"><i class="fas fa-arrow-up mr-1"></i>12% from last
                    month</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Volume</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">₹1,84,752</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                </div>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2"><i class="fas fa-arrow-up mr-1"></i>8% from last
                    month</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Commission Earned</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">₹9,237</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
                <p class="text-xs text-red-600 dark:text-red-400 mt-2"><i class="fas fa-arrow-down mr-1"></i>3% from last
                    month</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Transaction</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">₹148</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300">
                        <i class="fas fa-calculator"></i>
                    </div>
                </div>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2"><i class="fas fa-arrow-up mr-1"></i>5% from last
                    month</p>
            </div>
        </div>



        <!-- Transactions Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Transaction ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Vendor
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Payment Method
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Amount
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Commission
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date & Time
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
                        id="transactions-table-body">
                        @foreach ($transactions as $transaction)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                        #{{ $transaction->id }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Machine Id :
                                        {{ $transaction->cust_machine_id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                                            <i class="fas fa-store"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $transaction->vendor->vendor_name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->phone }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white uppercase">
                                        {{ $transaction->paid_by }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">
                                        ₹{{ $transaction->amount }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Commission
                                        {{ $transaction->commission }}%
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">
                                        ₹{{ number_format(($transaction->amount * $transaction->commission) / 100, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $transaction->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $transaction->created_at->format('h:i A') }} </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($transaction->status == 1)
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            Success
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yello-800">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="#">
                                            <button
                                                class="view-btn text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300"
                                                data-transaction-id="{{ $transaction->id }}">
                                                <i class="fas
                                                fa-eye"></i>
                                            </button>
                                        </a>
                                        <button
                                            class="receipt-btn text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300"
                                            data-vendor-id="{{ $transaction->vendor->id }}"
                                            data-transaction-id="{{ $transaction->id }}" <i class="fas fa-receipt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Refund Confirmation Modal -->
    <div id="refund-modal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Process Refund</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-6">Are you sure you want to refund this transaction? This
                action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancel-refund"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
                <button id="confirm-refund"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Process Refund
                </button>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div id="receipt-modal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Transaction Receipt</h3>
                <button id="print-receipt"
                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                    <i class="fas fa-print"></i>
                </button>
            </div>
            <div id="receipt-content" class="space-y-4">
                <!-- Sample receipt content -->
                <div class="text-center">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">XYZ Payment System</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Transaction Receipt</p>
                </div>
                <div class="border-t border-b border-gray-200 dark:border-gray-700 py-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Transaction ID:</span>
                        <span class="font-medium">TXN1001</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Date:</span>
                        <span>15 Jun 2023, 10:30 AM</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Vendor:</span>
                        <span>Mohan Grocery Store</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Customer:</span>
                        <span>+919876543210</span>
                    </div>
                </div>
                <div class="border-b border-gray-200 dark:border-gray-700 py-4">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Amount:</span>
                        <span>₹450.00</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-1">
                        <span>Commission (3%):</span>
                        <span>₹13.50</span>
                    </div>
                </div>
                <div class="text-center text-xs text-gray-500 dark:text-gray-400">
                    <p>Thank you for using XYZ Payment System</p>
                    <p>Transaction ID: TXN1001</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button id="close-receipt"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('search-input');
            const transactionsTableBody = document.getElementById('transactions-table-body');

            if (searchInput && transactionsTableBody) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = transactionsTableBody.querySelectorAll('tr');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Refund modal functionality
            // const refundModal = document.getElementById('refund-modal');
            // const refundBtns = document.querySelectorAll('.refund-btn');
            // const cancelRefundBtn = document.getElementById('cancel-refund');
            // const confirmRefundBtn = document.getElementById('confirm-refund');

            // let transactionToRefund = null;

            // refundBtns.forEach(btn => {
            //     btn.addEventListener('click', function() {
            //         refundModal.classList.remove('hidden');
            //         const transactionId = this.getAttribute('data-transaction-id');
            //         transactionToRefund = transactionId;
            //         console.log('Preparing to refund transaction:', transactionId);
            //     });
            // });

            // confirmRefundBtn.addEventListener('click', function() {
            //     if (transactionToRefund) {
            //         console.log('Processing refund for transaction:', transactionToRefund);
            //         // In a real app, you would make an AJAX call here
            //         alert(`Refund processed for transaction ${transactionToRefund}`);
            //     }
            //     refundModal.classList.add('hidden');
            // });

            // cancelRefundBtn.addEventListener('click', function() {
            //     refundModal.classList.add('hidden');
            // });

            // Receipt modal functionality
            const receiptModal = document.getElementById('receipt-modal');
            const receiptBtns = document.querySelectorAll('.receipt-btn');
            const closeReceiptBtn = document.getElementById('close-receipt');
            const printReceiptBtn = document.getElementById('print-receipt');

            receiptBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const transactionJson = this.dataset.transaction;
                    const transaction = JSON.parse(transactionJson);

                    console.log('Transaction ID:', transaction.id);
                    console.log('Amount:', transaction.amount);
                    console.log('Date:', transaction.date);
                    console.log('Note:', transaction.note);
                    console.log('Vendor ID:', transaction.vendor.id);
                    console.log('Vendor Name:', transaction.vendor.name);

                    const transactionId = this.getAttribute('data-transaction-id');
                    console.log('Showing receipt for transaction:', transactionId);
                    receiptModal.classList.remove('hidden');
                });
            });

            closeReceiptBtn.addEventListener('click', function() {
                receiptModal.classList.add('hidden');
            });

            printReceiptBtn.addEventListener('click', function() {
                console.log('Printing receipt...');
                window.print();
            });

            // Export functionality
            const exportBtn = document.getElementById('export-btn');
            if (exportBtn) {
                exportBtn.addEventListener('click', function() {
                    console.log('Exporting transaction data...');
                    alert('Export functionality would download a CSV file in a real application');
                });
            }
        });
    </script>
@endsection
