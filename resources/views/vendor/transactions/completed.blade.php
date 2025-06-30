@extends('layouts.vendor')

@section('title', 'Completed Transactions')

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 text-gray-800">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Completed Transactions</h2>
            <div class="flex space-x-3">
                {{-- <button id="filter-btn"
                    class="cursor-pointer flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-filter mr-2"></i>
                    Filter With Date
                </button> --}}
            </div>
        </div>


        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
            <form action="" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Customer Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Customer</label>
                        <div class="relative flex-1 md:mr-4">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search-input" placeholder="Search by customer name or id..."
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed Today</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">87</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2"><i class="fas fa-arrow-up mr-1"></i>15% from
                    yesterday</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Today's Volume</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">₹1,24,752</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                </div>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2"><i class="fas fa-arrow-up mr-1"></i>22% from
                    yesterday</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Today's Commission</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">₹3,742</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2"><i class="fas fa-arrow-up mr-1"></i>18% from
                    yesterday</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Transaction</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">₹1,434</p>
                    </div>
                    <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300">
                        <i class="fas fa-calculator"></i>
                    </div>
                </div>
                <p class="text-xs text-red-600 dark:text-red-400 mt-2"><i class="fas fa-arrow-down mr-1"></i>5% from
                    yesterday</p>
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
                                Customer
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
                                Date & Time
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
                        id="transactions-table-body">
                        <!-- Dummy Transaction 1 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">#TXN20230615001</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">QR: QRSTORE001</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Mohan Grocery Store
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Customer: +919876543210</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300">
                                        <i class="fab fa-google-pay"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm text-gray-900 dark:text-white">Google Pay</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">UPI Transaction</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">₹450.00</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Commission: ₹13.50 (3%)</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">Today, 10:30 AM</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Completed</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button
                                        class="receipt-btn text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300"
                                        data-transaction-id="TXN20230615001">
                                        <i class="fas fa-receipt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Dummy Transaction 2 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">#TXN20230615002</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">QR: QRELECT002</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Suresh Electronics
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Customer: +919876543211</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-300">
                                        <i class="fab fa-phone-pe"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm text-gray-900 dark:text-white">PhonePe</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">UPI Transaction</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">₹12,499.00</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Commission: ₹374.97 (3%)</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">Today, 11:45 AM</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Completed</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button
                                        class="receipt-btn text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300"
                                        data-transaction-id="TXN20230615002">
                                        <i class="fas fa-receipt"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>

                        <!-- Dummy Transaction 3 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">#TXN20230615003</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">QR: QRFASH003</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Priya Fashion
                                            Boutique</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Customer: +919876543212</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center text-yellow-600 dark:text-yellow-300">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm text-gray-900 dark:text-white">Credit Card</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Visa ••3456</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">₹2,499.00</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Commission: ₹74.97 (3%)</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">Today, 02:15 PM</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Completed</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button
                                        class="receipt-btn text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300"
                                        data-transaction-id="TXN20230615003">
                                        <i class="fas fa-receipt"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>

                        <!-- Dummy Transaction 4 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">#TXN20230615004</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">QR: QRKIRA004</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Raju Kirana Store
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Customer: +919876543213</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300">
                                        <i class="fab fa-paytm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm text-gray-900 dark:text-white">Paytm Wallet</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Wallet Transaction</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">₹1,250.00</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Commission: ₹37.50 (3%)</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">Today, 04:30 PM</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Completed</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button
                                        class="receipt-btn text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300"
                                        data-transaction-id="TXN20230615004">
                                        <i class="fas fa-receipt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Dummy Transaction 5 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">#TXN20230615005</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">QR: QRMEDI005</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Geeta Medical Store
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Customer: +919876543214</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-300">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm text-gray-900 dark:text-white">BHIM UPI</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">UPI Transaction</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">₹650.00</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Commission: ₹19.50 (3%)</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">Today, 06:45 PM</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Completed</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button
                                        class="receipt-btn text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300"
                                        data-transaction-id="TXN20230615005">
                                        <i class="fas fa-receipt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    <span
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-400 bg-white dark:bg-gray-700 cursor-not-allowed">
                        Previous
                    </span>
                    <a href="#"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        Next
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of
                            <span class="font-medium">87</span> transactions
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <span
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-sm font-medium text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Previous</span>
                                <i class="fas fa-chevron-left h-5 w-5" aria-hidden="true"></i>
                            </span>
                            <span aria-current="page"
                                class="z-10 bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-600 dark:text-indigo-300 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                1
                            </span>
                            <a href="#"
                                class="bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-700 text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                2
                            </a>
                            <a href="#"
                                class="bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-700 text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                3
                            </a>
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300">
                                ...
                            </span>
                            <a href="#"
                                class="bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-700 text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                18
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <span class="sr-only">Next</span>
                                <i class="fas fa-chevron-right h-5 w-5" aria-hidden="true"></i>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Refund Confirmation Modal -->
    {{-- <div id="refund-modal"
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
    </div> --}}

    <!-- Receipt Modal -->
    <div id="receipt-modal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden text-gray-200">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Transaction Receipt</h3>
                <button id="print-receipt"
                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                    <i class="fas fa-print"></i>
                </button>
            </div>
            <div id="receipt-content" class="space-y-4">
                <!-- Sample receipt content will be inserted here by JavaScript -->
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
            const refundModal = document.getElementById('refund-modal');
            const refundBtns = document.querySelectorAll('.refund-btn');
            const cancelRefundBtn = document.getElementById('cancel-refund');
            const confirmRefundBtn = document.getElementById('confirm-refund');

            let transactionToRefund = null;

            refundBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    refundModal.classList.remove('hidden');
                    const transactionId = this.getAttribute('data-transaction-id');
                    transactionToRefund = transactionId;
                    console.log('Preparing to refund transaction:', transactionId);
                });
            });

            confirmRefundBtn.addEventListener('click', function() {
                if (transactionToRefund) {
                    console.log('Processing refund for transaction:', transactionToRefund);
                    alert(`Refund processed for transaction ${transactionToRefund}`);
                    // In a real app, you would make an AJAX call here
                }
                refundModal.classList.add('hidden');
            });

            cancelRefundBtn.addEventListener('click', function() {
                refundModal.classList.add('hidden');
            });

            // Receipt modal functionality
            const receiptModal = document.getElementById('receipt-modal');
            const receiptBtns = document.querySelectorAll('.receipt-btn');
            const closeReceiptBtn = document.getElementById('close-receipt');
            const printReceiptBtn = document.getElementById('print-receipt');
            const receiptContent = document.getElementById('receipt-content');

            // Sample receipt templates for each transaction
            const receiptTemplates = {
                'TXN20230615001': `
                    <div class="text-center">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Payzio Payments</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Transaction Receipt</p>
                    </div>
                    <div class="border-t border-b border-gray-200 dark:border-gray-700 py-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Transaction ID:</span>
                            <span class="font-medium">TXN20230615001</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Date:</span>
                            <span>Today, 10:30 AM</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Vendor:</span>
                            <span>Mohan Grocery Store</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Customer:</span>
                            <span>+919876543210</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                            <span>Google Pay (UPI)</span>
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
                        <p>Thank you for using Payzio Payment System</p>
                        <p>Transaction ID: TXN20230615001</p>
                    </div>
                `,
                'TXN20230615002': `
                    <div class="text-center">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Payzio Payment System</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Transaction Receipt</p>
                    </div>
                    <div class="border-t border-b border-gray-200 dark:border-gray-700 py-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Transaction ID:</span>
                            <span class="font-medium">TXN20230615002</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Date:</span>
                            <span>Today, 11:45 AM</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Vendor:</span>
                            <span>Suresh Electronics</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Customer:</span>
                            <span>+919876543211</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                            <span>PhonePe (UPI)</span>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 dark:border-gray-700 py-4">
                        <div class="flex justify-between font-bold text-lg">
                            <span>Amount:</span>
                            <span>₹12,499.00</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-1">
                            <span>Commission (3%):</span>
                            <span>₹374.97</span>
                        </div>
                    </div>
                    <div class="text-center text-xs text-gray-500 dark:text-gray-400">
                        <p>Thank you for using Payzio Payment System</p>
                        <p>Transaction ID: TXN20230615002</p>
                    </div>
                `,
                // Add templates for other transactions similarly
            };

            receiptBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const transactionId = this.getAttribute('data-transaction-id');
                    const template = receiptTemplates[transactionId] || receiptTemplates[
                        'TXN20230615001'];
                    receiptContent.innerHTML = template;
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

            // Filter functionality
            const vendorFilter = document.getElementById('vendor-filter');
            const amountFilter = document.getElementById('amount-filter');
            const timeFilter = document.getElementById('time-filter');

            [vendorFilter, amountFilter, timeFilter].forEach(filter => {
                filter.addEventListener('change', function() {
                    console.log('Filters changed:', {
                        vendor: vendorFilter.value,
                        amount: amountFilter.value,
                        time: timeFilter.value
                    });
                    // In a real app, you would filter the data here
                });
            });
        });
    </script>
@endsection
