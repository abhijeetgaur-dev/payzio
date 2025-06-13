@extends('layouts.admin')

@section('head')
    <title>Dashboard</title>
@endsection



@section('content')
    <div class="space-y-6 p-6 text-gray-800">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg cursor-pointer transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                        <h3 class="text-2xl font-bold mt-1">₹45,231</h3>
                        <p class="text-xs text-gray-400 mt-2">+12% from last month</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-rupee-sign text-indigo-500 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg cursor-pointer transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Vendors</p>
                        <h3 class="text-2xl font-bold mt-1">₹1,234</h3>
                        <p class="text-xs text-gray-400 mt-2">+8% from last month</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-users text-green-500 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg cursor-pointer transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">QR Codes Issued</p>
                        <h3 class="text-2xl font-bold mt-1">₹3,456</h3>
                        <p class="text-xs text-gray-400 mt-2">+19% from last month</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-qrcode text-blue-500 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg cursor-pointer transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Transaction Volume</p>
                        <h3 class="text-2xl font-bold mt-1">₹12,345</h3>
                        <p class="text-xs text-gray-400 mt-2">+24% from last month</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-chart-line text-purple-500 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">Recent Transactions</h3>
                <button class="text-sm text-indigo-600 hover:text-indigo-800">View All</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Vendor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Grocery Store</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">John Doe</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹120.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10 min ago</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Electronics Shop</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jane Smith</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹450.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25 min ago</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Restaurant</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Robert Johnson</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹35.50</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1 hour ago</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Clothing Store</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Emily Davis</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹89.99</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2 hours ago</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Book Store</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Michael Wilson</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹24.99</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Failed
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3 hours ago</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-md font-semibold mb-4">Transaction Volume</h4>
                <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                    <p class="text-gray-400">Chart Placeholder</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-md font-semibold mb-4">Vendor Growth</h4>
                <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                    <p class="text-gray-400">Chart Placeholder</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-md font-semibold mb-4">Top Vendors</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div
                                class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                                G
                            </div>
                            <span class="ml-3 text-sm font-medium">Grocery Store</span>
                        </div>
                        <span class="text-sm font-semibold">₹1000.00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div
                                class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                                E
                            </div>
                            <span class="ml-3 text-sm font-medium">Electronics Shop</span>
                        </div>
                        <span class="text-sm font-semibold">₹800.00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div
                                class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                                R
                            </div>
                            <span class="ml-3 text-sm font-medium">Restaurant</span>
                        </div>
                        <span class="text-sm font-semibold">₹600.00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div
                                class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                                C
                            </div>
                            <span class="ml-3 text-sm font-medium">Clothing Store</span>
                        </div>
                        <span class="text-sm font-semibold">₹400.00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div
                                class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                                B
                            </div>
                            <span class="ml-3 text-sm font-medium">Book Store</span>
                        </div>
                        <span class="text-sm font-semibold">₹200.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
