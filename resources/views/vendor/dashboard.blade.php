@extends('layouts.vendor')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6 bg-slate-800">
        <!-- Today's Transactions Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Transactions</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">₹12,845.50</p>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-exchange-alt"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    8.5% from yesterday
                </span>
            </div>
        </div>

        <!-- Weekly Transactions Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">This Week</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">₹78,420.75</p>
                </div>
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-calendar-week"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-red-600">
                    <i class="fas fa-arrow-down mr-1"></i>
                    3.2% from last week
                </span>
            </div>
        </div>

        <!-- Pending Settlements Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending Settlements</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">₹24,310.00</p>
                </div>
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View Details</a>
            </div>
        </div>

        <!-- Total Customers Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Customers</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">1,248</p>
                </div>
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    12% from last month
                </span>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Transactions</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TX-78945</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rahul Sharma</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹1,250.00</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jun 17, 2023 10:45 AM</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TX-78944</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Priya Patel</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹2,499.00</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jun 17, 2023 09:30 AM</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TX-78943</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Anonymous</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹450.50</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jun 16, 2023 5:15 PM</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TX-78942</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Amit Singh</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹3,750.00</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                Failed
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jun 16, 2023 2:30 PM</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TX-78941</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Neha Gupta</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹1,899.00</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jun 16, 2023 11:20 AM</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                View all transactions
            </a>
        </div>
    </div>

    <!-- QR Code Quick Access -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Your QR Code</h3>
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    Generate New
                </a>
            </div>
        </div>
        <div class="p-6 flex flex-col items-center">
            <div class="mb-4 p-2 bg-white rounded-lg shadow-md">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://example.com/vendor/1234"
                    alt="Vendor QR Code" class="h-48 w-48">
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-2">Scan this QR code to receive payments</p>
                <div class="flex space-x-3 justify-center">
                    <a href="#"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        <i class="fas fa-download mr-2"></i> Download
                    </a>
                    <button onclick="window.print()"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-print mr-2"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
