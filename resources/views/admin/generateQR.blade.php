@extends('layouts.admin')

@section('title', 'Generate QR code')

@section('content')
    <div class="p-6 bg-linear-120 to-zinc-200 from-gray-400">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            <div>
                <div id="success-message"class="hidden mb-4 p-4 rounded-lg bg-green-100 text-green-800 text-sm font-medium">
                </div>

                <div id="error-message" class="hidden mb-4 p-4 rounded-lg bg-red-100 text-red-800 text-sm font-medium">
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Generate QR Code</h2>
                    <p class="text-gray-600">
                        Create payment QR codes for your vendors
                    </p>
                </div>
                <button id="reset-btn"
                    class="cursor-pointer flex items-center px-4 py-2 mt-4 md:mt-0 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Reset
                </button>
            </div>

            <div>
                @include('partials.flash')
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Configuration Panel -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-cog mr-2 text-indigo-600 dark:text-indigo-400"></i>
                        QR Configuration
                    </h3>

                    <form id="qr-form">
                        <!-- Vendor Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Search Vendor
                            </label>
                            <div class="relative">
                                <input type="text" id="vendor-search"
                                    class="text-gray-200 w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Type to search vendors..." autocomplete="off">

                                <!-- Hidden input to store the selected vendor ID -->
                                <input type="hidden" id="vendor-id" name="vendor_id">

                                <!-- Dropdown results container -->
                                <div id="vendor-results"
                                    class="hidden absolute z-10 mt-1 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-auto">
                                    <!-- Results will be populated here -->
                                </div>
                            </div>

                            <!-- Selected vendor details (optional) -->
                            <div id="selected-vendor-details" class="mt-2 hidden">
                                <div class="text-gray-300 text-sm">
                                    <span id="vendor-name-display"></span>
                                    <span id="vendor-email-display" class="ml-2"></span>
                                    <span id="vendor-phone-display" class="ml-2"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Payment Description (Optional)
                            </label>
                            <input type="text" id="description"
                                class="w-full text-gray-200 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. Invoice #12345" />
                        </div>

                        <!-- Generate Button -->
                        <button type="submit"
                            class="cursor-pointer w-full py-3 px-4 mt-auto bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors flex items-center justify-center">
                            Generate QR Code
                        </button>
                    </form>
                </div>

                <!-- QR Display Panel -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-user mr-2 text-indigo-600 dark:text-indigo-400"></i>
                        QR Code Preview
                    </h3>

                    <div id="qr-preview-container">
                        <div class="flex flex-col items-center justify-center py-12">
                            <div
                                class="w-48 h-48 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-rupee-sign text-gray-400 dark:text-gray-500 text-4xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-center">
                                Configure the QR code settings and click "Generate" to create a payment QR code
                            </p>
                        </div>
                    </div>

                    <!-- This will be populated by JavaScript -->
                    <div id="qr-result-container" class="hidden">
                        <div class="flex flex-col items-center">
                            <!-- QR Code Display -->
                            <div id="qr-code-display"
                                class="p-4 bg-white rounded-lg border border-gray-200 dark:border-gray-700 mb-6 flex flex-col items-center">
                                <div id="qr-svg-container" class="h-[200px] "></div>
                                <div class="mt-40 text-center text-gray-500">
                                    <p id="vendor-name-display-qr"
                                        class="text-sm font-medium text-gray-900 dark:text-gray-800"></p>
                                    <p id="vendor-email-display-qr" class="text-xs text-gray-500  mt-1 max-w-xs truncate">
                                    </p>
                                    <p id="vendor-phone-display-qr" class="text-xs text-gray-500 mt-1 max-w-xs truncate">
                                    </p>
                                    <p id="description-display" class="text-xs text-gray-500  mt-1 max-w-xs truncate">
                                    </p>
                                </div>
                            </div>

                            <!-- QR Data Info -->
                            <div class="w-full bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">QR Data:</p>
                                <div class="flex items-center justify-between">
                                    <code id="qr-data-text"
                                        class="text-sm text-gray-800 dark:text-gray-200 break-all"></code>
                                    <button id="copy-btn"
                                        class="ml-2 p-2 text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                                        title="Copy to clipboard">
                                        <i id="copy-icon" class="far fa-copy"></i>
                                        <i id="check-icon" class="fas fa-check text-green-500 hidden"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 w-full">
                                <button id="download-btn"
                                    class="cursor-pointer flex-1 py-2 px-4 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center justify-center">
                                    <i class="fas fa-download mr-2"></i>
                                    Download PNG
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Instructions -->
            <div class="mt-12 bg-gray-900/50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">
                    How to use these QR codes
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                        <div class="text-indigo-600 dark:text-indigo-400 font-bold text-lg mb-2">1</div>
                        <h4 class="font-medium text-gray-800 dark:text-white mb-2">Print & Display</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Download the QR code and print it for your vendor to display at their checkout counter.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                        <div class="text-indigo-600 dark:text-indigo-400 font-bold text-lg mb-2">2</div>
                        <h4 class="font-medium text-gray-800 dark:text-white mb-2">Digital Sharing</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Send the QR code image digitally for online payments or invoice attachments.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                        <div class="text-indigo-600 dark:text-indigo-400 font-bold text-lg mb-2">3</div>
                        <h4 class="font-medium text-gray-800 dark:text-white mb-2">POS Integration</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Integrate with POS systems using the QR data for seamless payment processing.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include required libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>

    <script>
        function showSuccess(message) {
            const successEl = document.getElementById('success-message');
            successEl.textContent = message;
            successEl.classList.remove('hidden');
            setTimeout(() => {
                successEl.classList.add('hidden');
            }, 5000); // Hide after 5 seconds
        }

        function showError(message) {
            const errorEl = document.getElementById('error-message');
            errorEl.textContent = message;
            errorEl.classList.remove('hidden');
            setTimeout(() => {
                errorEl.classList.add('hidden');
            }, 7000); // Hide after 7 seconds
        }
        document.addEventListener('DOMContentLoaded', function() {
            let qrGenerated = 0;
            let venddorChangeFlag = 0;
            //vendor search bar
            const vendorSearch = document.getElementById('vendor-search');
            const vendorResults = document.getElementById('vendor-results');
            const vendorIdInput = document.getElementById('vendor-id');
            const selectedVendorDetails = document.getElementById('selected-vendor-details');

            const vendors = [
                @foreach ($vendors as $vendor)
                    {
                        id: "{{ $vendor->id }}",
                        name: "{{ $vendor->vendor_name }}",
                        email: "{{ $vendor->email }}",
                        phone: "{{ $vendor->phone }}",
                        displayText: "{{ $vendor->vendor_name }} ({{ $vendor->id }})"
                    },
                @endforeach
            ];

            function resetPage() {
                document.getElementById('description').value = '';
                document.getElementById('qr-preview-container').classList.remove('hidden');
                document.getElementById('qr-result-container').classList.add('hidden');

                document.getElementById('vendor-name-display').textContent = '';
                document.getElementById('vendor-email-display').textContent = '';
                document.getElementById('vendor-phone-display').textContent = '';
                selectedVendorDetails.classList.add('hidden');
                vendorSearch.value = '';
                vendorIdInput.value = '';

            }

            vendorSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                if (searchTerm.length < 1) {
                    vendorResults.classList.add('hidden');
                    return;
                }

                const filteredVendors = vendors.filter(vendor =>
                    vendor.name.toLowerCase().includes(searchTerm) ||
                    vendor.id.toLowerCase().includes(searchTerm)
                );

                if (filteredVendors.length > 0) {
                    vendorResults.innerHTML = filteredVendors.map(vendor => `
                <div class="px-4 text-white py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer vendor-option" 
                     data-id="${vendor.id}" 
                     data-name="${vendor.name}"
                     data-email="${vendor.email}"
                     data-phone="${vendor.phone}">
                    ${vendor.displayText}
                </div>
            `).join('');
                    vendorResults.classList.remove('hidden');
                } else {
                    vendorResults.innerHTML =
                        '<div class="px-4 text-gray-500 py-2 text-gray-500">No vendors found</div>';
                    vendorResults.classList.remove('hidden');
                }
            });

            ///////////////////// Handle click on a vendor option/////////////////////////////////
            vendorResults.addEventListener('click', function(e) {
                if (e.target.classList.contains('vendor-option')) {
                    const vendor = e.target;
                    vendorSearch.value = vendor.textContent.trim();
                    vendorIdInput.value = vendor.dataset.id;

                    // Update displayed vendor details
                    document.getElementById('vendor-name-display').textContent = vendor.dataset.name;
                    document.getElementById('vendor-email-display').textContent = vendor.dataset.email;
                    document.getElementById('vendor-phone-display').textContent = vendor.dataset.phone;
                    selectedVendorDetails.classList.remove('hidden');

                    vendorResults.classList.add('hidden');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!vendorSearch.contains(e.target) && !vendorResults.contains(e.target)) {
                    vendorResults.classList.add('hidden');
                }
            });

            // Form submission handler
            document.getElementById('qr-form').addEventListener('submit', function(e) {
                e.preventDefault();


                const vendorId = vendorIdInput.value;
                const vendorEmail = document.getElementById('vendor-email-display').textContent;
                const vendorPhone = document.getElementById('vendor-phone-display').textContent;
                const vendorName = document.getElementById('vendor-name-display').textContent;
                const description = document.getElementById('description').value;

                if (!vendorId) {
                    alert('Please select a vendor');
                    return;
                } else if (qrGenerated == 1 && vendorChangeFlag == vendorId) {
                    alert(
                        'QR code already generated and saved for this vendor. Please select another Vendor'
                    );
                    return;
                }

                // Generate QR data
                let qrData = `payzio:/vendor/${vendorId}?phone=${vendorPhone}&email=${vendorEmail}`;
                if (description) {
                    qrData += `?note=${encodeURIComponent(description)}`;
                }

                // Generate QR code
                const qr = qrcode(0, 'H');
                qr.addData(qrData);
                qr.make();

                // Display QR code
                document.getElementById('qr-svg-container').innerHTML = qr.createSvgTag(6);
                document.getElementById('vendor-name-display-qr').textContent = vendorName;
                document.getElementById('vendor-email-display-qr').textContent = vendorEmail;
                document.getElementById('vendor-phone-display-qr').textContent = vendorPhone;
                document.getElementById('description-display').textContent = description ?
                    `Description: ${description}` : '';
                document.getElementById('qr-data-text').textContent = qrData;

                // Show result container and hide preview
                document.getElementById('qr-preview-container').classList.add('hidden');
                document.getElementById('qr-result-container').classList.remove('hidden');

                // Auto-save QR code using html2canvas and AJAX
                const qrDisplay = document.getElementById('qr-code-display');

                // Wait a tick for the DOM to fully render QR
                setTimeout(() => {
                    html2canvas(qrDisplay).then(canvas => {
                        canvas.toBlob(function(blob) {
                            const formData = new FormData();
                            formData.append('vendor_id', vendorId);
                            formData.append('qr_image', blob,
                                `qr-${vendorId}-${Date.now()}.png`);

                            fetch("{{ route('admin.qr.save') }}", {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')
                                            .content
                                    },
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        qrGenerated = 1;
                                        vendorChangeFlag = vendorId;
                                        showSuccess(data.message);
                                    } else {
                                        showError(data.message ||
                                            'Something went wrong.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    showError('An unexpected error occurred.');
                                });
                        }, 'image/png');
                    });
                }, 200); // short delay to ensure SVG is rendered
            });

            // Copy QR data handler
            document.getElementById('copy-btn').addEventListener('click', function() {
                const qrData = document.getElementById('qr-data-text').textContent;
                navigator.clipboard.writeText(qrData).then(() => {
                    document.getElementById('copy-icon').classList.add('hidden');
                    document.getElementById('check-icon').classList.remove('hidden');
                    setTimeout(() => {
                        document.getElementById('copy-icon').classList.remove('hidden');
                        document.getElementById('check-icon').classList.add('hidden');
                    }, 2000);
                });
            });

            // Download QR code handler
            document.getElementById('download-btn').addEventListener('click', function() {
                const qrDisplay = document.getElementById('qr-code-display');
                html2canvas(qrDisplay).then(canvas => {
                    const link = document.createElement('a');
                    const vendorId = document.getElementById('vendor-id').value;
                    link.download = `QR-${vendorId}-${Date.now()}.png`;
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                });
            });

            // Reset form handler
            document.getElementById('reset-btn').addEventListener('click', function() {
                resetPage();
            });

            // Save to vendor handler 
            document.getElementById('save-btn').addEventListener('click', function() {
                const qrDisplay = document.getElementById('qr-code-display');
                const vendorId = document.getElementById('vendor-id').value;

                if (!vendorId) {
                    alert('Please select a vendor first.');
                    return;
                }

                html2canvas(qrDisplay).then(canvas => {
                    canvas.toBlob(function(blob) {
                        const formData = new FormData();
                        formData.append('vendor_id', vendorId);
                        formData.append('qr_image', blob,
                            `qr-${vendorId}-${Date.now()}.png`);

                        fetch("{{ route('admin.qr.save') }}", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showSuccess(data.message);
                                } else {
                                    showError(data.message ||
                                        'Something went wrong.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showError('An unexpected error occurred.');
                            });
                    }, 'image/png');
                });
            });
        });
    </script>
@endsection
