@extends('layouts.admin')

@section('title', 'Vendor Details')

@section('content')
    <div class="p-6">
        <!-- Page Header with Back Button -->
        <div class="flex items-center justify-between mb-6 ">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.vendors') }}"
                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Vendor Details</h2>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.vendor.edit', $vendor->id) }}"
                    class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Vendor
                </a>
                <button onclick="window.location.href='{{ route('admin.vendors') }}'"
                    class="flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-list mr-2"></i>
                    Back to List
                </button>
            </div>
        </div>

        <!-- Vendor Information Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex-shrink-0 h-16 w-16 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 text-2xl">
                            <i
                                class="fas fa-{{ $vendor->vendor_type === 'company' ? 'building' : ($vendor->vendor_type === 'partner' ? 'handshake' : 'user') }}"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $vendor->vendor_name }}</h3>
                            <div class="flex items-center space-x-2 mt-1">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400 capitalize">{{ $vendor->vendor_type }}</span>
                                <span class="text-gray-400">•</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $vendor->id }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Status Dropdown Only -->
                    <form id="status-form" action="{{ route('admin.vendor.update.status', $vendor->id) }}" method="POST"
                        class="ml-4">
                        @csrf
                        @method('PUT')
                        <select name="status" id="status-select"
                            class="appearance-none pl-3 pr-8 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                {{ $vendor->status === 'active'
                                    ? 'bg-green-100 text-green-800 border-green-300'
                                    : ($vendor->status === 'suspended'
                                        ? 'bg-red-100 text-red-800 border-red-300'
                                        : 'bg-yellow-100 text-yellow-800 border-yellow-300') }}">
                            <option value="pending" {{ $vendor->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="active" {{ $vendor->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ $vendor->status === 'suspended' ? 'selected' : '' }}>Suspended
                            </option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Read-only Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <!-- Business Information -->
                <div class="space-y-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Business
                        Information</h4>
                    <div class="space-y-3">
                        @if ($vendor->business_description)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Description</p>
                                <p class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-2 rounded">
                                    {{ $vendor->business_description }}</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PAN Number</p>
                                <p class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-2 rounded">
                                    {{ $vendor->pan_number ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">GST Number</p>
                                <p class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-2 rounded">
                                    {{ $vendor->gst_number ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="space-y-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contact
                        Information</h4>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Contact Person</p>
                            <p class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-2 rounded">
                                {{ $vendor->contact_person ?? 'Not specified' }}
                                @if ($vendor->designation)
                                    <span
                                        class="text-gray-500 dark:text-gray-400 text-sm">({{ $vendor->designation }})</span>
                                @endif
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Email</p>
                                <p class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-2 rounded">
                                    {{ $vendor->email ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Phone</p>
                                <p class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-2 rounded">
                                    {{ $vendor->phone ? '+' . $vendor->phone : 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Attachments (Read-only) -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Document Attachments</h3>
            <div class="grid grid-cols-2 gap-4 text-gray-100">
                @if ($vendor->pan_card_file)
                    <div class="border rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <a href="{{ asset('storage/' . $vendor->pan_card_file) }}" target="_blank"
                            class="flex items-center space-x-2">
                            <i class="fas fa-file-pdf text-red-500"></i>
                            <span class="text-sm">PAN Card</span>
                        </a>
                    </div>
                @endif

                @if ($vendor->gst_certificate_file)
                    <div class="border rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <a href="{{ asset('storage/' . $vendor->gst_certificate_file) }}" target="_blank"
                            class="flex items-center space-x-2">
                            <i class="fas fa-file-pdf text-red-500"></i>
                            <span class="text-sm">GST Certificate</span>
                        </a>
                    </div>
                @endif

                @if ($vendor->registration_doc_file)
                    <div class="border rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <a href="{{ asset('storage/' . $vendor->registration_doc_file) }}" target="_blank"
                            class="flex items-center space-x-2">
                            <i class="fas fa-file-pdf text-red-500"></i>
                            <span class="text-sm">Registration Doc</span>
                        </a>
                    </div>
                @endif

                @if ($vendor->cancelled_cheque_file)
                    <div class="border rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <a href="{{ asset('storage/' . $vendor->cancelled_cheque_file) }}" target="_blank"
                            class="flex items-center space-x-2">
                            <i class="fas fa-file-image text-blue-500"></i>
                            <span class="text-sm">Cancelled Cheque</span>
                        </a>
                    </div>
                @endif
            </div>

            @if (
                !$vendor->pan_card_file &&
                    !$vendor->gst_certificate_file &&
                    !$vendor->registration_doc_file &&
                    !$vendor->cancelled_cheque_file)
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">No documents uploaded</p>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status change handler
            const statusSelect = document.getElementById('status-select');
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    document.getElementById('status-form').submit();
                });
            }
        });
    </script>
@endsection
