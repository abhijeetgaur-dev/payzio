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

        <div>
            @include('partials.flash')
        </div>


        <!-- Search and Filter Bar -->

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
            <form action="" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Vendor Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vendor</label>
                        <div class="relative flex-1 md:mr-4">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search-input" placeholder="Search QR codes by vendor name or token..."
                                class="pl-10 pr-4 py-2 w-full border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                        </div>
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
                                    <form id="status-form-{{ $qrCode->is_active }}"
                                        action="{{ route('admin.vendor.status.update', $qrCode->id) }}" method="POST"
                                        class="ml-4">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" id="status-select-{{ $qrCode->id }}"
                                            onchange="this.form.submit()"
                                            class="appearance-none pl-3 pr-8 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                                {{ $qrCode->is_active == 1
                                                    ? 'bg-green-100 text-green-800 border-green-300'
                                                    : 'bg-red-100 text-red-800 border-red-300' }} ">
                                            <option value="1" {{ $qrCode->is_active == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $qrCode->is_active == 0 ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                    </form>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.qr.show', $qrCode->id) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <button
                                            class="delete-btn text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                            data-qr-id="{{ $qrCode->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
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


        </div>
    </div>

    <div id="delete-qr-modal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Delete Qr</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-6">Are you sure you want to delete this Qr? This
                action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancel-delete-qr"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
                <button id="confirm-delete-qr"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </div>
        </div>


        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Delete Qr modal
                    const deleteQrModal = document.getElementById('delete-qr-modal');
                    const deleteQrBtns = document.querySelectorAll('.delete-btn');
                    const cancelDeleteQrBtn = document.getElementById('cancel-delete-qr');
                    const confirmDeleteQrBtn = document.getElementById('confirm-delete-qr');

                    let qrToDelete = null;

                    deleteQrBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            console.log('button clicked');
                            deleteQrModal.classList.remove('hidden');
                            const qrId = this.getAttribute('data-qr-id');
                            qrToDelete = qrId;
                            confirmDeleteQrBtn.addEventListener('click', function() {
                                console.log(`Deleting Qr with ID: ${qrToDelete}`);
                                fetch(`/admin/qr/delete/${qrToDelete}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        }
                                    })
                                    .then(response => {
                                        if (response.ok) {
                                            console.log(
                                                `Qr with ID ${qrToDelete} deleted successfully.`
                                            );
                                            // Optionally, you can remove the qr row from the table here
                                            document.querySelector(
                                                `button.delete-btn[data-qr-id="${qrToDelete}"]`
                                            ).closest('tr').remove();
                                        } else {
                                            console.error(
                                                `Failed to delete qr with ID ${qrToDelete}.`
                                            );
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });

                                deleteQrModal.classList.add('hidden');
                            });

                            cancelDeleteQrBtn.addEventListener('click', function() {
                                deleteQrModal.classList.add('hidden');
                            });
                        });
                    })


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
