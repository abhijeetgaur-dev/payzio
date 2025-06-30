<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .file-upload {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #eff6ff;
            color: #1d4ed8;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
        }

        .file-upload:hover {
            background-color: #dbeafe;
        }

        .progress-step.active {
            background-color: #2563eb;
            color: white;
        }

        .progress-step.completed {
            background-color: #d1fae5;
            color: #065f46;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-zinc-200 to-gray-400 py-12 px-4 sm:px-6 lg:px-8">
    <div class="absolute top-0 right-0 p-4">
        <a href="/"
            class="font-semibold bg-gradient-to-br from-purple-500 to-pink-600 hover:from-zinc-800 hover:to-zinc-900 rounded-sm text-sm text-zinc-200 hover:text-white mr-4 px-3 py-2 transition duration-200 ease-in-out">
            Home
        </a>
    </div>

    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-8">
            <a href="/" class="text-5xl font-extrabold inline-block mb-4 text-gray-800">
                Payzio Payments
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900">
                Join Our Vendor Network
            </h1>
            <p class="mt-2 text-lg text-gray-600 max-w-2xl mx-auto">
                Register your business to start accepting QR code payments with competitive rates and fast settlements.
            </p>
        </div>
        <div>
            @include('partials.flash')
        </div>

        <form action={{ route('vendor.store') }} method="POST" enctype="multipart/form-data"
            class="bg-gray-200 text-gray-800 shadow-xl rounded-2xl overflow-hidden">
            @csrf
            <!-- Progress Steps -->
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <div class="flex flex-col items-center">
                        <button type="button"
                            class="cursor-pointer flex items-center justify-center w-10 h-10 rounded-full progress-step active"
                            data-tab="0">
                            1
                        </button>
                        <span class="mt-2 text-xs font-medium text-blue-600">Basic Info</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <button type="button"
                            class="cursor-pointer flex items-center justify-center w-10 h-10 rounded-full progress-step"
                            data-tab="1">
                            2
                        </button>

                        <span class="mt-2 text-xs font-medium text-gray-500">Contact</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <button type="button"
                            class="cursor-pointer flex items-center justify-center w-10 h-10 rounded-full progress-step"
                            data-tab="2">
                            3
                        </button>
                        <span class="mt-2 text-xs font-medium text-gray-500">Bank Details</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <button type="button"
                            class="cursor-pointer flex items-center justify-center w-10 h-10 rounded-full progress-step"
                            data-tab="3">
                            4
                        </button>
                        <span class="mt-2 text-xs font-medium text-gray-500">Documents</span>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-6 sm:p-8">
                <!-- Tab 1 - Basic Information -->
                <div id="tab-0" class="space-y-6 tab-content active">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-1">Business Information</h2>
                        <p class="text-gray-800 mb-6">Tell us about your business</p>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Vendor Name *</label>
                                <input type="text" name="vendor_name"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="Your business name" value="{{ old('vendor_name') }}">
                                @error('vendor_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Vendor Type *</label>
                                <select name="vendor_type"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border bg-white">
                                    <option value="">Select Type</option>
                                    <option value="individual" @if (old('vendor_type') == 'individual') selected @endif>
                                        Individual</option>
                                    <option value="company" @if (old('vendor_type') == 'company') selected @endif>Company
                                    </option>
                                    <option value="partner" @if (old('vendor_type') == 'partner') selected @endif>
                                        Partnership</option>
                                </select>
                                @error('vendor_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Business Category *</label>
                            <input type="text" name="business_category"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                placeholder="e.g. Retail, Restaurant, Services" value="{{ old('business_category') }}">
                            @error('business_category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Business Description</label>
                            <textarea rows="3" name="business_description"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                placeholder="Brief description of your business activities">{{ old('business_description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <div></div>
                        <button type="button"
                            class="next-tab cursor-pointer inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                            data-next="1">
                            Continue to Contact
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tab 2 - Contact Information -->
                <div id="tab-1" class="space-y-6 tab-content hidden">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-1">Contact Information</h2>
                        <p class="text-gray-600 mb-6">How can we reach you?</p>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person *</label>
                                <input type="text" name="contact_person"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="Full name" value="{{ old('contact_person') }}">
                                @error('contact_person')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                                <input type="text" name="designation"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="Your position" value="{{ old('designation') }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" name="email"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="business@example.com" value="{{ old('email') }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                                <input type="tel" name="phone"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="+91 9876543210" value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                            <input type="url" name="website"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                placeholder="https://yourbusiness.com" value="{{ old('website') }}">
                        </div>
                    </div>

                    <div class="pt-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-1">Business Address</h3>
                        <p class="text-gray-600 mb-6">Where is your business located?</p>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                            <textarea rows="3" name="address"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                placeholder="Street address, building, floor, etc.">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                <input type="text" name="city"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="City" value="{{ old('city') }}">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                                <input type="text" name="state"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="State" value="{{ old('state') }}">
                                @error('state')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                                <select name="country"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border bg-white">
                                    <option value="">Select Country</option>
                                    <option value="India" @if (old('country') == 'India') selected @endif>India
                                    </option>
                                    <option value="USA" @if (old('country') == 'USA') selected @endif>United
                                        States</option>
                                    <option value="UK" @if (old('country') == 'UK') selected @endif>United
                                        Kingdom</option>
                                    <option value="Canada" @if (old('country') == 'Canada') selected @endif>Canada
                                    </option>
                                    <option value="Australia" @if (old('country') == 'Australia') selected @endif>
                                        Australia</option>
                                </select>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                                <input type="text" name="postal_code"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="PIN/ZIP Code" value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <button type="button"
                            class="prev-tab cursor-pointer inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                            data-prev="0">
                            <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Back
                        </button>
                        <button type="button"
                            class="next-tab cursor-pointer inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                            data-next="2">
                            Continue to Bank Details
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tab 3 - Bank Information -->
                <div id="tab-2" class="space-y-6 tab-content hidden">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-1">Tax Information</h2>
                        <p class="text-gray-600 mb-6">Required for compliance and settlements</p>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">PAN Number *</label>
                                <input type="text" name="pan_number"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="ABCDE1234F" value="{{ old('pan_number') }}">
                                @error('pan_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">GST Number</label>
                                <input type="text" name="gst_number"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="22ABCDE1234F1Z5" value="{{ old('gst_number') }}">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-1">Bank Account Details</h3>
                        <p class="text-gray-600 mb-6">Where should we transfer your settlements?</p>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name *</label>
                            <input type="text" name="bank_name"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                placeholder="e.g. State Bank of India" value="{{ old('bank_name') }}">
                            @error('bank_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Account Number *</label>
                                <input type="text" name="account_number"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="1234567890" value="{{ old('account_number') }}">
                                @error('account_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Account Holder Name
                                    *</label>
                                <input type="text" name="account_holder"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="As per bank records" value="{{ old('account_holder') }}">
                                @error('account_holder')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">IFSC Code *</label>
                                <input type="text" name="ifsc_code"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="SBIN0001234" value="{{ old('ifsc_code') }}">
                                @error('ifsc_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Branch Name</label>
                                <input type="text" name="branch_name"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 px-4 py-3 border"
                                    placeholder="Main Branch" value="{{ old('branch_name') }}">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <button type="button"
                            class="prev-tab cursor-pointer inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                            data-prev="1">
                            <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Back
                        </button>
                        <button type="button"
                            class="next-tab cursor-pointer inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                            data-next="3">
                            Continue to Documents
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tab 4 - Documents -->
                <div id="tab-3" class="space-y-6 tab-content hidden">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-1">Document Verification</h2>
                        <p class="text-gray-600 mb-6">Upload required documents for KYC and compliance</p>

                        <div class="space-y-6">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">PAN Card *</label>
                                <p class="text-xs text-gray-500 mb-3">Upload clear scan of your PAN card (PDF, JPG,
                                    PNG)</p>
                                <input type="file" name="pan_card_file"
                                    class="cursor-pointer block w-full text-sm text-gray-500 file-upload"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                @error('pan_card_file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">GST Certificate (if
                                    applicable)</label>
                                <p class="text-xs text-gray-500 mb-3">Upload your GST registration certificate</p>
                                <input type="file" name="gst_certificate_file"
                                    class="cursor-pointer block w-full text-sm text-gray-500 file-upload"
                                    accept=".pdf,.jpg,.jpeg,.png">
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Business Registration
                                    Document</label>
                                <p class="text-xs text-gray-500 mb-3">For companies/LLPs - Certificate of
                                    Incorporation, Partnership Deed, etc.</p>
                                <input type="file" name="registration_doc_file"
                                    class="cursor-pointer block w-full text-sm text-gray-500 file-upload"
                                    accept=".pdf,.jpg,.jpeg,.png">
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cancelled Cheque *</label>
                                <p class="text-xs text-gray-500 mb-3">Upload clear image/scan of a cancelled cheque
                                    with your account details</p>
                                <input type="file" name="cancelled_cheque_file"
                                    class="cursor-pointer block w-full text-sm text-gray-500 file-upload"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                @error('cancelled_cheque_file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <button type="button"
                            class="prev-tab cursor-pointer inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                            data-prev="2">
                            <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Back
                        </button>
                        <button type="submit"
                            class="cursor-pointer inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                            Submit Application
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-8 text-center text-sm text-gray-500">
        <p>Already have an account? <a href="/vendor/login" class="text-blue-600 hover:text-blue-500 font-medium">Sign
                in here</a></p>
        <p class="mt-2">By registering, you agree to our <a href="/terms"
                class="text-blue-600 hover:text-blue-500">Terms of Service</a> and <a href="/privacy"
                class="text-blue-600 hover:text-blue-500">Privacy Policy</a></p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab navigation
            const tabs = document.querySelectorAll('.tab-content');
            const progressSteps = document.querySelectorAll('.progress-step');

            // Show first tab by default
            tabs[0].classList.add('active');

            // Tab buttons
            document.querySelectorAll('[data-tab]').forEach(button => {
                button.addEventListener('click', function() {
                    const tabIndex = parseInt(this.getAttribute('data-tab'));

                    // Hide all tabs
                    tabs.forEach(tab => tab.classList.add('hidden'));
                    tabs.forEach(tab => tab.classList.remove('active'));

                    // Show selected tab
                    tabs[tabIndex].classList.remove('hidden');
                    tabs[tabIndex].classList.add('active');

                    // Update progress steps
                    progressSteps.forEach((step, index) => {
                        step.classList.remove('active', 'completed');
                        if (index === tabIndex) {
                            step.classList.add('active');
                        } else if (index < tabIndex) {
                            step.classList.add('completed');
                        }
                    });
                });
            });

            // Next buttons
            document.querySelectorAll('.next-tab').forEach(button => {
                button.addEventListener('click', function() {
                    const nextTabIndex = parseInt(this.getAttribute('data-next'));
                    document.querySelector(`[data-tab="${nextTabIndex}"]`).click();
                });
            });

            // Previous buttons
            document.querySelectorAll('.prev-tab').forEach(button => {
                button.addEventListener('click', function() {
                    const prevTabIndex = parseInt(this.getAttribute('data-prev'));
                    document.querySelector(`[data-tab="${prevTabIndex}"]`).click();
                });
            });
        });
    </script>
</body>

</html>
