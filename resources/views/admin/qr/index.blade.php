@extends('layouts.admin')

@section('title', 'QR Codes List')

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">QR Codes Management</h2>
            <div class="flex space-x-3">
                <a href="/admin/qr/generate"
                    class="cursor-pointer flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-qrcode mr-2"></i>
                    Generate New QR
                </a>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="relative flex-1 md:mr-4">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="search-input" placeholder="Search QR codes by vendor name or token..."
                        class="pl-10 pr-4 py-2 w-full border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                </div>
                <div class="flex space-x-3">
                    <select id="status-filter"
                        class="border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- QR Codes Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                QR Code
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Vendor
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Token
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Generated On
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
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($qrCodes as $qrCode)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <!-- QR Code Image -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            @if (Storage::disk('public')->exists('qr_codes/' . $qrCode->qr_code_url))
                                                <img src="{{ asset('storage/qr_codes/' . $qrCode->qr_code_url) }}"
                                                    alt="QR Code" class="h-16 w-16 object-contain">
                                            @else
                                                <div
                                                    class="h-16 w-16 bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-qrcode text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Vendor Information -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($qrCode->vendor)
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $qrCode->vendor->vendor_name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $qrCode->vendor->email }}
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Vendor not found</span>
                                    @endif
                                </td>

                                <!-- Token -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white font-mono">
                                        {{ \Illuminate\Support\Str::limit($qrCode->qr_code_token, 10) }}
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $qrCode->created_at->format('M d, Y') }}
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full {{ $qrCode->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $qrCode->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href=""
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href=""
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                                onclick="return confirm('Are you sure you want to delete this QR code?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No QR codes found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($qrCodes->hasPages())
                <div
                    class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($qrCodes->onFirstPage())
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-400 bg-white dark:bg-gray-700 cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $qrCodes->previousPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                Previous
                            </a>
                        @endif

                        @if ($qrCodes->hasMorePages())
                            <a href="{{ $qrCodes->nextPageUrl() }}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                Next
                            </a>
                        @else
                            <span
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-400 bg-white dark:bg-gray-700 cursor-not-allowed">
                                Next
                            </span>
                        @endif
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Showing <span class="font-medium">{{ $qrCodes->firstItem() }}</span> to
                                <span class="font-medium">{{ $qrCodes->lastItem() }}</span> of
                                <span class="font-medium">{{ $qrCodes->total() }}</span> QR codes
                            </p>
                        </div>
                        <div>
                            {{ $qrCodes->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Search functionality
                const searchInput = document.getElementById('search-input');
                const statusFilter = document.getElementById('status-filter');
                const tableBody = document.querySelector('tbody');

                // Function to filter QR codes
                function filterQRCodes() {
                    const searchTerm = searchInput.value.toLowerCase();
                    const statusValue = statusFilter.value;

                    document.querySelectorAll('tbody tr').forEach(row => {
                        const vendorName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                        const token = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                        const status = row.querySelector('td:nth-child(5) span').textContent.toLowerCase();

                        const matchesSearch = vendorName.includes(searchTerm) || token.includes(searchTerm);
                        const matchesStatus = statusValue === '' ||
                            (statusValue === '1' && status.includes('active')) ||
                            (statusValue === '0' && status.includes('inactive'));

                        if (matchesSearch && matchesStatus) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }

                // Event listeners
                searchInput.addEventListener('input', filterQRCodes);
                statusFilter.addEventListener('change', filterQRCodes);
            });
        </script>
    @endpush
@endsection
