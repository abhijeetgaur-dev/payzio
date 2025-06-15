@extends('layouts.admin')

@section('title', 'Generate QR code')

@section('content')
    <div class="p-6 bg-linear-120 to-zinc-200 from-gray-400">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
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
                                Select Vendor
                            </label>
                            <select id="vendor-select"
                                class="text-gray-200 w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                <option value="">Select a vendor</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" data-email="{{ $vendor->email }}"
                                        data-phone="{{ $vendor->phone }}" data-name="{{ $vendor->vendor_name }}">
                                        {{ $vendor->vendor_name }} ({{ $vendor->id }})
                                    </option>
                                @endforeach
                            </select>
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
                                    <p id="vendor-name-display"
                                        class="text-sm font-medium text-gray-900 dark:text-gray-800"></p>
                                    <p id="vendor-email-display" class="text-xs text-gray-500  mt-1 max-w-xs truncate"></p>
                                    <p id="vendor-phone-display" class="text-xs text-gray-500 mt-1 max-w-xs truncate"></p>
                                    <p id="description-display" class="text-xs text-gray-500  mt-1 max-w-xs truncate"></p>
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
                                <button id="save-btn"
                                    class="cursor-pointer flex-1 py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i>
                                    Save QR
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
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission handler
            document.getElementById('qr-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const vendorId = document.getElementById('vendor-select').value;
                const vendorEmail = document.getElementById('vendor-select').selectedOptions[0].dataset
                    .email;
                const vendorPhone = document.getElementById('vendor-select').selectedOptions[0].dataset
                    .phone;
                const vendorName = document.getElementById('vendor-select').selectedOptions[0].dataset.name;
                const description = document.getElementById('description').value;

                if (!vendorId) {
                    alert('Please select a vendor');
                    return;
                }

                // Generate QR data
                let qrData = `xyzpay:/vendor/${vendorId}?phone=${vendorPhone}&email=${vendorEmail}`;
                if (description) {
                    qrData += `?note=${encodeURIComponent(description)}`;
                }

                // Generate QR code
                const qr = qrcode(0, 'H');
                qr.addData(qrData);
                qr.make();

                // Display QR code
                document.getElementById('qr-svg-container').innerHTML = qr.createSvgTag(6);
                document.getElementById('vendor-name-display').textContent = vendorName;
                document.getElementById('vendor-email-display').textContent = vendorEmail;
                document.getElementById('vendor-phone-display').textContent = vendorPhone;
                document.getElementById('description-display').textContent = description ?
                    `Description: ${description}` : '';
                document.getElementById('qr-data-text').textContent = qrData;

                // Show result container and hide preview
                document.getElementById('qr-preview-container').classList.add('hidden');
                document.getElementById('qr-result-container').classList.remove('hidden');
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
                    const vendorId = document.getElementById('vendor-select').value;
                    link.download = `QR-${vendorId}-${Date.now()}.png`;
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                });
            });

            // Reset form handler
            document.getElementById('reset-btn').addEventListener('click', function() {
                document.getElementById('vendor-select').value = '';
                document.getElementById('description').value = '';
                document.getElementById('qr-preview-container').classList.remove('hidden');
                document.getElementById('qr-result-container').classList.add('hidden');
            });

            // Save to vendor handler 
            document.getElementById('save-btn').addEventListener('click', function() {
                const qrDisplay = document.getElementById('qr-code-display');
                const vendorId = document.getElementById('vendor-select').value;

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
                            .then(response => {
                                if (response.ok) {
                                    alert('QR code saved successfully.');
                                } else {
                                    alert('Failed to save QR code.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Something went wrong.');
                            });
                    }, 'image/png');
                });
            });
        });
    </script>
@endsection
