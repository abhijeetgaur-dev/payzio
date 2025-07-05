@extends('layouts.admin')

@section('title', 'Vendors List')

@section('styles')
    <style>
        .table th {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Sortable column styles */
        .sortable-column {
            cursor: pointer;
            user-select: none;
            transition: color 0.2s ease;
        }

        .sortable-column:hover {
            color: #4f46e5;
            /* indigo-600 */
        }

        .sort-icon {
            margin-left: 4px;
            font-size: 0.75rem;
            transition: all 0.2s ease;
        }

        /* Active sort indicator */
        .sort-active {
            color: #4f46e5 !important;
        }

        /* Filter badges */
        .filter-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .dark .filter-badge {
            background-color: #312e81;
            color: #c7d2fe;
        }

        /* Search highlight (optional) */
        .search-highlight {
            background-color: #fef3c7;
            padding: 1px 2px;
            font-weight: 600;
        }

        .dark .search-highlight {
            background-color: #451a03;
            color: #fbbf24;
        }
    </style>


@endsection

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 text-gray-800">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Vendors List</h2>
            <div class="flex space-x-3">

                <a href={{ route('admin.vendor.create') }}
                    class="cursor-pointer flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Add Vendor
                </a>
            </div>
        </div>

        <div>
            @include('partials.flash')
        </div>

        <!-- Search and Filter Bar -->

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
            <form action="{{ route('admin.vendors') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search
                            Vendors</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by name, email, or phone..."
                                class="pl-10 pr-4 py-2 w-full border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Status</option>
                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
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

                <!-- Hidden inputs to maintain sort parameters -->
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <input type="hidden" name="direction" value="{{ request('direction') }}">

                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('admin.vendors') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Reset</a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Apply
                        Filters</button>
                </div>
            </form>
        </div>


        <!-- Vendors Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm ">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <!-- Vendor Name Column (Sortable) -->
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'vendor_name', 'direction' => request('sort') == 'vendor_name' && request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center hover:text-indigo-600 dark:hover:text-indigo-400">
                                    Vendor
                                    @if (request('sort') == 'vendor_name')
                                        <i
                                            class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600 dark:text-indigo-400"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-gray-400"></i>
                                    @endif
                                </a>
                            </th>

                            <!-- Contact Column (Sortable by email) -->
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => request('sort') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center hover:text-indigo-600 dark:hover:text-indigo-400">
                                    Contact
                                    @if (request('sort') == 'email')
                                        <i
                                            class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600 dark:text-indigo-400"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-gray-400"></i>
                                    @endif
                                </a>
                            </th>

                            <!-- Joined Column (Sortable) -->
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center hover:text-indigo-600 dark:hover:text-indigo-400">
                                    Joined
                                    @if (request('sort') == 'created_at')
                                        <i
                                            class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600 dark:text-indigo-400"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-gray-400"></i>
                                    @endif
                                </a>
                            </th>

                            <!-- Status Column (Sortable) -->
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center hover:text-indigo-600 dark:hover:text-indigo-400">
                                    Status
                                    @if (request('sort') == 'status')
                                        <i
                                            class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600 dark:text-indigo-400"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-gray-400"></i>
                                    @endif
                                </a>
                            </th>

                            <!-- Non-sortable columns -->
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Set Commission
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
                        id="vendors-table-body">
                        @if ($vendors && count($vendors) > 0)
                            @foreach ($vendors as $vendor)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $vendor->vendor_name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">ID:
                                                    {{ $vendor->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $vendor->email }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $vendor->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($vendor->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td class="flex flex-row px-6 py-4 whitespace-nowrap">
                                        <form id="status-form-{{ $vendor->id }}"
                                            action="{{ route('admin.vendor.update.status', $vendor->id) }}" method="POST"
                                            class="ml-4">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" id="status-select-{{ $vendor->id }}"
                                                onchange="this.form.submit()"
                                                class="appearance-none pl-3 pr-8 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                                {{ $vendor->status == 1
                                                    ? 'bg-green-100 text-green-800 border-green-300'
                                                    : ($vendor->status == 0
                                                        ? 'bg-red-100 text-red-800 border-red-300'
                                                        : 'bg-yellow-100 text-yellow-800 border-yellow-300') }} ">
                                                @if ($vendor->status == 2)
                                                    <option value="2" {{ $vendor->status == 2 ? 'selected' : '' }}>
                                                        Pending
                                                    </option>
                                                @endif
                                                <option value="1" {{ $vendor->status == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ $vendor->status == 0 ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-center items-center ">

                                            <a href="/admin/vendor/show-commission/{{ $vendor->id }}"
                                                class="flex justify-center edit-status-btn px-2 text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                                <i class="fas
                                                fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.vendor.view', [$vendor->id]) }}">
                                                <button
                                                    class="view-btn text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300"
                                                    data-vendor-id="{{ $vendor->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('admin.vendor.edit', [$vendor->id]) }}">
                                                <button
                                                    class="edit-btn text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300"
                                                    data-vendor-id="{{ $vendor->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </a>
                                            <button
                                                class="delete-btn text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                                data-vendor-id="{{ $vendor->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No vendors found.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($vendors->hasPages())
                <div
                    class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($vendors->onFirstPage())
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-400 bg-white dark:bg-gray-700 cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $vendors->previousPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                Previous
                            </a>
                        @endif

                        @if ($vendors->hasMorePages())
                            <a href="{{ $vendors->nextPageUrl() }}"
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
                                Showing <span class="font-medium">{{ $vendors->firstItem() }}</span> to
                                <span class="font-medium">{{ $vendors->lastItem() }}</span> of
                                <span class="font-medium">{{ $vendors->total() }}</span> vendors
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination">
                                @if ($vendors->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <span class="sr-only">Previous</span>
                                        <i class="fas fa-chevron-left h-5 w-5" aria-hidden="true"></i>
                                    </span>
                                @else
                                    <a href="{{ $vendors->previousPageUrl() }}"
                                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <span class="sr-only">Previous</span>
                                        <i class="fas fa-chevron-left h-5 w-5" aria-hidden="true"></i>
                                    </a>
                                @endif

                                @foreach ($vendors->getUrlRange(1, $vendors->lastPage()) as $page => $url)
                                    @if ($page == $vendors->currentPage())
                                        <span aria-current="page"
                                            class="z-10 bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-600 dark:text-indigo-300 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-700 text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                @if ($vendors->hasMorePages())
                                    <a href="{{ $vendors->nextPageUrl() }}"
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <span class="sr-only">Next</span>
                                        <i class="fas fa-chevron-right h-5 w-5" aria-hidden="true"></i>
                                    </a>
                                @else
                                    <span
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <span class="sr-only">Next</span>
                                        <i class="fas fa-chevron-right h-5 w-5" aria-hidden="true"></i>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <div id="delete-vendor-modal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Delete Vendor</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-6">Are you sure you want to delete this vendor? This
                action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancel-delete-vendor"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
                <button id="confirm-delete-vendor"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </div>
        </div>

        <!-- Include Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Search functionality
                const searchInput = document.getElementById('search-input');
                const vendorsTableBody = document.getElementById('vendors-table-body');

                if (searchInput && vendorsTableBody) {
                    searchInput.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase();
                        const rows = vendorsTableBody.querySelectorAll('tr');

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

                // Modal functionality

                const statusModal = document.getElementById('status-modal');
                const statusSelect = document.getElementById('status');
                const commissionField = document.getElementById('commission-field');
                const saveStatusBtn = document.getElementById('save-status');
                const cancelStatusBtn = document.getElementById('cancel-status');

                // Handle edit button clicks
                document.querySelectorAll('.edit-status-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        statusModal.classList.remove('hidden');
                        // Get vendor ID from button ID or data attribute
                        const vendorId = this.getAttribute('data-vendor-id');
                        console.log(vendorId);

                        document.getElementById('vendor-id').value = vendorId;


                        // Set current status in dropdown
                        const currentStatus = this.getAttribute('data-vendor-status') || 'pending';
                        statusSelect.value = currentStatus;

                    });
                });

                // Delete vendor modal
                const deleteVendorModal = document.getElementById('delete-vendor-modal');
                const deleteVendorBtns = document.querySelectorAll('.delete-btn');
                const cancelDeleteVendorBtn = document.getElementById('cancel-delete-vendor');
                const confirmDeleteVendorBtn = document.getElementById('confirm-delete-vendor');

                let vendorToDelete = null;

                deleteVendorBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        deleteVendorModal.classList.remove('hidden');
                        const vendorId = this.getAttribute('data-vendor-id');
                        vendorToDelete = vendorId;
                        confirmDeleteVendorBtn.addEventListener('click', function() {
                            console.log(`Deleting vendor with ID: ${vendorToDelete}`);
                            fetch(`/admin/vendor/delete/${vendorToDelete}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (response.ok) {
                                        console.log(
                                            `Vendor with ID ${vendorToDelete} deleted successfully.`
                                        );
                                        // Optionally, you can remove the vendor row from the table here
                                        document.querySelector(
                                            `button.delete-btn[data-vendor-id="${vendorToDelete}"]`
                                        ).closest('tr').remove();
                                    } else {
                                        console.error(
                                            `Failed to delete vendor with ID ${vendorToDelete}.`
                                        );
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });

                            deleteVendorModal.classList.add('hidden');
                        });

                        cancelDeleteVendorBtn.addEventListener('click', function() {
                            deleteVendorModal.classList.add('hidden');
                        });
                    });
                })
            })
        </script>
    @endsection
