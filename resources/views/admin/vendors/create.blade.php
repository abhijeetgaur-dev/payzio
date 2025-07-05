@extends('layouts.admin')

@section('title', 'Add New Vendor')

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.vendors') }}"
                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Add New Vendor</h2>
            </div>
        </div>

        <!-- Add Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden max-w-3xl mx-auto">
            <form action="{{ route('admin.vendor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Basic Information Section -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Essential Information</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Provide basic details to create the vendor
                        account</p>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Vendor Name -->
                    <div>
                        <label for="vendor_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Company/Individual Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="vendor_name" name="vendor_name" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Enter company/individual name" />
                    </div>

                    <!-- Contact Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter email" />
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="phone" name="phone" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter phone number" />
                        </div>
                    </div>

                    <!-- Vendor Type -->
                    <div>
                        <label for="vendor_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Vendor Type
                        </label>
                        <select id="vendor_type" name="vendor_type"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            <option value="individual">
                                Individual</option>
                            <option value="company">Company
                            </option>
                            <option value="partner">Partner
                            </option>
                        </select>
                    </div>

                    <!-- Required Documents -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Required Documents <span class="text-red-500">*</span>
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- PAN Card -->
                            <div>
                                <label for="pan_card_file"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    PAN Card <span class="text-red-500">*</span>
                                </label>
                                <input type="file" id="pan_card_file" name="pan_card_file" required
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class=" text-gray-200 w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PDF, JPG, or PNG (Max 2MB)</p>
                            </div>

                            <!-- Cancelled Cheque -->
                            <div>
                                <label for="cancelled_cheque_file"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Cancelled Cheque <span class="text-red-500">*</span>
                                </label>
                                <input type="file" id="cancelled_cheque_file" name="cancelled_cheque_file" required
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="text-gray-200 w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PDF, JPG, or PNG (Max 2MB)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
                    <button type="button" onclick="window.location.href='{{ route('admin.vendors') }}'"
                        class="mr-3 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
