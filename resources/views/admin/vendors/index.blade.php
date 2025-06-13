@extends('layouts.admin')

@section('title', 'Vendors List')

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 text-gray-800">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Vendors List</h2>
            <div class="flex space-x-3">
                <button
                    class="cursor-pointer flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
                <a href="/vendor/signup"
                    class="cursor-pointer flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Add Vendor
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
                    <input type="text" id="search-input" placeholder="Search vendors by name, email or phone..."
                        class="pl-10 pr-4 py-2 w-full border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                </div>
                <div class="flex space-x-3">
                    <select
                        class="border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Pending</option>
                        <option>Suspended</option>
                    </select>
                    <button
                        class="flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-filter mr-2"></i>
                        Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Vendors Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm ">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Vendor
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Contact
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Joined
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
                                                    {{ $vendor->name }}</div>
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
                                        {{ \Carbon\Carbon::parse($vendor->joined)->format('m/d/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                1 => 'bg-green-100 text-green-800',
                                                0 => 'bg-yellow-100 text-yellow-800',
                                                'suspended' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$vendor->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $vendor->status ? 'Active' : 'Pending' }}
                                        </span>
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
            @if (count($vendors) > 0)
                <div
                    class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <button id="prev-page-mobile"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            Previous
                        </button>
                        <button id="next-page-mobile"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            Next
                        </button>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Showing <span class="font-medium">1</span> to
                                <span class="font-medium">{{ min(5, count($vendors)) }}</span> of
                                <span class="font-medium">{{ count($vendors) }}</span> vendors
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <button id="prev-page"
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left h-5 w-5" aria-hidden="true"></i>
                                </button>
                                @for ($i = 1; $i <= ceil(count($vendors) / 5); $i++)
                                    <button data-page="{{ $i }}"
                                        class="page-btn relative inline-flex items-center px-4 py-2 border text-sm font-medium {{ $i == 1 ? 'z-10 bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-600 dark:text-indigo-300' : 'bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-700 text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600' }}">
                                        {{ $i }}
                                    </button>
                                @endfor
                                <button id="next-page"
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right h-5 w-5" aria-hidden="true"></i>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Vendor Modal -->
    {{-- <div id="add-vendor-modal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Add New Vendor</h3>
                    <button id="close-modal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        <i class="fas fa-times cursor-pointer" style="font-size: 24px;"></i>
                    </button>
                </div>
                <form id="add-vendor-form" action="{{ route('vendors.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Business Name
                            </label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Email Address
                            </label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Phone Number
                            </label>
                            <input type="tel" id="phone" name="phone" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                        </div>
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" id="cancel-add-vendor"
                                class="cursor-pointer px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit"
                                class="cursor-pointer px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Vendor
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

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
                const addVendorModal = document.getElementById('add-vendor-modal');
                const closeModalBtn = document.getElementById('close-modal');
                const cancelAddVendorBtn = document.getElementById('cancel-add-vendor');

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

                // Open modal (you'll need to add a button with id="open-modal" somewhere in your HTML)
                document.getElementById('open-modal')?.addEventListener('click', function() {
                    addVendorModal.classList.remove('hidden');
                });

                // Close modal
                if (closeModalBtn) {
                    closeModalBtn.addEventListener('click', function() {
                        addVendorModal.classList.add('hidden');
                    });
                }

                if (cancelAddVendorBtn) {
                    cancelAddVendorBtn.addEventListener('click', function() {
                        addVendorModal.classList.add('hidden');
                    });
                }

                // Pagination functionality (simplified)
                const pageButtons = document.querySelectorAll('.page-btn');
                const prevPageBtn = document.getElementById('prev-page');
                const nextPageBtn = document.getElementById('next-page');
                const prevPageMobileBtn = document.getElementById('prev-page-mobile');
                const nextPageMobileBtn = document.getElementById('next-page-mobile');

                let currentPage = 1;
                const itemsPerPage = 5;
                const totalItems = {{ count($vendors) }};
                const totalPages = Math.ceil(totalItems / itemsPerPage);

                function updatePagination() {
                    // Update active page button
                    pageButtons.forEach(btn => {
                        if (parseInt(btn.dataset.page) === currentPage) {
                            btn.classList.add('z-10', 'bg-indigo-50', 'dark:bg-indigo-900', 'border-indigo-500',
                                'text-indigo-600', 'dark:text-indigo-300');
                            btn.classList.remove('bg-white', 'dark:bg-gray-700', 'text-gray-500',
                                'dark:text-gray-300');
                        } else {
                            btn.classList.remove('z-10', 'bg-indigo-50', 'dark:bg-indigo-900',
                                'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-300');
                            btn.classList.add('bg-white', 'dark:bg-gray-700', 'text-gray-500',
                                'dark:text-gray-300');
                        }
                    });

                    // Update disabled state of prev/next buttons
                    const prevButtons = [prevPageBtn, prevPageMobileBtn];
                    const nextButtons = [nextPageBtn, nextPageMobileBtn];

                    prevButtons.forEach(btn => {
                        if (btn) {
                            btn.disabled = currentPage === 1;
                        }
                    });

                    nextButtons.forEach(btn => {
                        if (btn) {
                            btn.disabled = currentPage === totalPages;
                        }
                    });

                    // Update showing text
                    const showingText = document.querySelector('.text-sm.text-gray-700.dark\\:text-gray-300');
                    if (showingText) {
                        const startItem = (currentPage - 1) * itemsPerPage + 1;
                        const endItem = Math.min(currentPage * itemsPerPage, totalItems);
                        showingText.textContent = `Showing ${startItem} to ${endItem} of ${totalItems} vendors`;
                    }
                }

                // Initialize pagination
                if (pageButtons.length > 0) {
                    pageButtons.forEach(btn => {
                        btn.addEventListener('click', function() {
                            currentPage = parseInt(this.dataset.page);
                            updatePagination();
                        });
                    });

                    if (prevPageBtn) prevPageBtn.addEventListener('click', function() {
                        if (currentPage > 1) {
                            currentPage--;
                            updatePagination();
                        }
                    });

                    if (nextPageBtn) nextPageBtn.addEventListener('click', function() {
                        if (currentPage < totalPages) {
                            currentPage++;
                            updatePagination();
                        }
                    });

                    if (prevPageMobileBtn) prevPageMobileBtn.addEventListener('click', function() {
                        if (currentPage > 1) {
                            currentPage--;
                            updatePagination();
                        }
                    });

                    if (nextPageMobileBtn) nextPageMobileBtn.addEventListener('click', function() {
                        if (currentPage < totalPages) {
                            currentPage++;
                            updatePagination();
                        }
                    });

                    updatePagination();
                }
            });
        </script>
    @endsection
