@extends('layouts.admin')

@section('title', 'Edit Vendor')

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.vendors') }}"
                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Vendor</h2>
            </div>
            <div>
                <button onclick="window.location.href='{{ route('admin.vendor.show', $vendor->id) }}'"
                    class="flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    View Vendor
                </button>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            <form action="{{ route('admin.vendor.update', $vendor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Information Section -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Basic Information</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Vendor Name -->
                    <div>
                        <label for="vendor_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vendor Name *</label>
                        <input type="text" id="vendor_name" name="vendor_name"
                            value="{{ old('vendor_name', $vendor->vendor_name) }}" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Vendor Type -->
                    <div>
                        <label for="vendor_type"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vendor Type *</label>
                        <select id="vendor_type" name="vendor_type" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            <option value="individual"
                                {{ old('vendor_type', $vendor->vendor_type) === 'individual' ? 'selected' : '' }}>Individual
                            </option>
                            <option value="company"
                                {{ old('vendor_type', $vendor->vendor_type) === 'company' ? 'selected' : '' }}>Company
                            </option>
                            <option value="partner"
                                {{ old('vendor_type', $vendor->vendor_type) === 'partner' ? 'selected' : '' }}>Partner
                            </option>
                        </select>
                    </div>

                    <!-- Business Category -->
                    <div>
                        <label for="business_category"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Business
                            Category</label>
                        <input type="text" id="business_category" name="business_category"
                            value="{{ old('business_category', $vendor->business_category) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Business Description -->
                    <div class="md:col-span-2">
                        <label for="business_description"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Business
                            Description</label>
                        <textarea id="business_description" name="business_description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('business_description', $vendor->business_description) }}</textarea>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Contact Information</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Contact Person -->
                    <div>
                        <label for="contact_person"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contact Person</label>
                        <input type="text" id="contact_person" name="contact_person"
                            value="{{ old('contact_person', $vendor->contact_person) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Designation -->
                    <div>
                        <label for="designation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Designation</label>
                        <input type="text" id="designation" name="designation"
                            value="{{ old('designation', $vendor->designation) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                            *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $vendor->email) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone
                            *</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $vendor->phone) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Website</label>
                        <input type="url" id="website" name="website" value="{{ old('website', $vendor->website) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>
                </div>

                <!-- Address Information Section -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Address Information</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                        <textarea id="address" name="address" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('address', $vendor->address) }}</textarea>
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $vendor->city) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">State</label>
                        <input type="text" id="state" name="state" value="{{ old('state', $vendor->state) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country</label>
                        <input type="text" id="country" name="country"
                            value="{{ old('country', $vendor->country) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Postal Code</label>
                        <input type="text" id="postal_code" name="postal_code"
                            value="{{ old('postal_code', $vendor->postal_code) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>
                </div>

                <!-- Tax & Bank Information Section -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tax & Bank Information</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- PAN Number -->
                    <div>
                        <label for="pan_number"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PAN Number</label>
                        <input type="text" id="pan_number" name="pan_number"
                            value="{{ old('pan_number', $vendor->pan_number) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- GST Number -->
                    <div>
                        <label for="gst_number"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">GST Number</label>
                        <input type="text" id="gst_number" name="gst_number"
                            value="{{ old('gst_number', $vendor->gst_number) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Bank Name -->
                    <div>
                        <label for="bank_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank Name</label>
                        <input type="text" id="bank_name" name="bank_name"
                            value="{{ old('bank_name', $vendor->bank_name) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Account Number -->
                    <div>
                        <label for="account_number"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account Number</label>
                        <input type="text" id="account_number" name="account_number"
                            value="{{ old('account_number', $vendor->account_number) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Account Holder -->
                    <div>
                        <label for="account_holder"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account Holder
                            Name</label>
                        <input type="text" id="account_holder" name="account_holder"
                            value="{{ old('account_holder', $vendor->account_holder) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- IFSC Code -->
                    <div>
                        <label for="ifsc_code"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IFSC Code</label>
                        <input type="text" id="ifsc_code" name="ifsc_code"
                            value="{{ old('ifsc_code', $vendor->ifsc_code) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>

                    <!-- Branch Name -->
                    <div>
                        <label for="branch_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Branch Name</label>
                        <input type="text" id="branch_name" name="branch_name"
                            value="{{ old('branch_name', $vendor->branch_name) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                    </div>
                </div>

                <!-- Document Uploads Section -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Document Uploads</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Upload or replace documents (PDF, JPG, PNG)
                    </p>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- PAN Card File -->
                    <div>
                        <label for="pan_card_file"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PAN Card</label>
                        <input type="file" id="pan_card_file" name="pan_card_file" accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700" />
                        @if ($vendor->pan_card_file)
                            <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                <span>Current file: {{ basename($vendor->pan_card_file) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- GST Certificate File -->
                    <div>
                        <label for="gst_certificate_file"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">GST Certificate</label>
                        <input type="file" id="gst_certificate_file" name="gst_certificate_file"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700" />
                        @if ($vendor->gst_certificate_file)
                            <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                <span>Current file: {{ basename($vendor->gst_certificate_file) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Registration Doc File -->
                    <div>
                        <label for="registration_doc_file"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Registration
                            Document</label>
                        <input type="file" id="registration_doc_file" name="registration_doc_file"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700" />
                        @if ($vendor->registration_doc_file)
                            <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                <span>Current file: {{ basename($vendor->registration_doc_file) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Cancelled Cheque File -->
                    <div>
                        <label for="cancelled_cheque_file"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cancelled
                            Cheque</label>
                        <input type="file" id="cancelled_cheque_file" name="cancelled_cheque_file"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700" />
                        @if ($vendor->cancelled_cheque_file)
                            <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-file-image text-blue-500 mr-2"></i>
                                <span>Current file: {{ basename($vendor->cancelled_cheque_file) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
                    <button type="button"
                        onclick="window.location.href='{{ route('admin.vendors.show', $vendor->id) }}'"
                        class="mr-3 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
