@extends('layouts.admin')

@section('title', 'Edit Admin Profile')

@section('styles')
    <style>
        .file-upload {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #eff6ff !important;
            color: #1d4ed8 !important;
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
@endsection

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-800">Edit Profile</h1>
                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-700">Update your profile information and documents
                    </p>
                </div>

            </div>

            <div>
                @include('partials.flash')
            </div>
        </div>
        <!-- Main Form -->
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
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
                        <span class="mt-2 text-xs font-medium text-blue-600">Basic Information</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <button type="button"
                            class="cursor-pointer flex items-center justify-center w-10 h-10 rounded-full progress-step"
                            data-tab="1">
                            2
                        </button>

                        <span class="mt-2 text-xs font-medium text-gray-500">Organization Details</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <button type="button"
                            class="cursor-pointer flex items-center justify-center w-10 h-10 rounded-full progress-step"
                            data-tab="2">
                            3
                        </button>
                        <span class="mt-2 text-xs font-medium text-gray-500">Documents</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <button type="button"
                            class="cursor-pointer flex items-center justify-center w-10 h-10 rounded-full progress-step"
                            data-tab="3">
                            4
                        </button>
                        <span class="mt-2 text-xs font-medium text-gray-500">Bank Accounts</span>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-6 sm:p-8">
                <!-- Tab 1 - Basic Information -->
                <div id="tab-1" class="space-y-6 tab-content active">
                    <div class="bg-white dark:bg-gray-500 rounded-xl shadow-lg overflow-hidden border border-gray-200 ">
                        <div class="p-6">
                            <h2
                                class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-indigo-600"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Basic Information
                            </h2>

                            <div class="md:col-span-2">
                                <label for="company_logo"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company
                                    Logo</label>
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if ($adminDetails && $adminDetails->company_logo)
                                            <div class="flex gap-6">
                                                <img id="company-logo-preview"
                                                    src="{{ asset('storage/' . $adminDetails->company_logo) }}"
                                                    alt="Company Logo"
                                                    class="h-16 w-16 rounded-full object-cover border-2 border-gray-300">
                                                <input type="file" id="company_logo" name="company_logo"
                                                    class="cursor-pointer block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                            </div>
                                        @else
                                            <div class="flex gap-6">
                                                <!-- Placeholder div instead of broken img when no logo exists -->
                                                <div id="company-logo-preview"
                                                    class="h-16 w-16 rounded-full bg-gray-200 border-2 border-gray-300 flex items-center justify-center">
                                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <input type="file" id="company_logo" name="company_logo"
                                                    class="cursor-pointer block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="company_name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company
                                        Name <span class="text-red-500">*</span></label>
                                    <input type="text" id="company_name" name="company_name"
                                        value="{{ old('company_name', $admin->name ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('company_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="contact_person"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contact
                                        Person <span class="text-red-500">*</span></label>
                                    <input type="text" id="contact_person" name="contact_person"
                                        value="{{ old('contact_person', $adminDetails->contact_person ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('contact_person')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Primary
                                        Phone <span class="text-red-500">*</span></label>
                                    <input type="tel" id="phone" name="phone"
                                        value="{{ old('phone', $admin->phone ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="alternate_phones"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alternate
                                        Phones</label>
                                    <input type="text" id="alternate_phones" name="alternate_phones"
                                        value="{{ old('alternate_phones', $adminDetails->alternate_phones ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('alternate_phones')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Primary
                                        Email</label>
                                    <input type="text" id="email" name="email"
                                        value="{{ old('email', $admin->email ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                        readonly>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="alternate_emails"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alternate
                                        Emails</label>
                                    <input type="email" id="alternate_emails" name="alternate_emails"
                                        value="{{ old('phone', $adminDetails->alternate_emails ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('alternate_emails')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="contact_person"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contact
                                        Person</label>
                                    <input type="text" id="contact_person" name="contact_person"
                                        value="{{ old('contact_person', $adminDetails->contact_person ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('contact_person')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>


                                @php
                                    $selectedType = old('admin_type', $adminDetails->admin_type ?? '');
                                @endphp

                                <div>
                                    <label for="admin_type"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company
                                        Type</label>
                                    <select name="admin_type"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                        <span class="text-red-500">*</span>>
                                        <option value="">Select Type</option>
                                        <option value="individual" @if ($selectedType == 'individual') selected @endif>
                                            Individual</option>
                                        <option value="company" @if ($selectedType == 'company') selected @endif>
                                            Company</option>
                                        <option value="partner" @if ($selectedType == 'partner') selected @endif>
                                            Partnership</option>
                                    </select>
                                    @error('admin_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="website"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Website</label>
                                    <input type="text" id="website" name="website"
                                        value="{{ old('website', $adminDetails->website ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('website')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="city"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                                    <input type="text" id="city" name="city"
                                        value="{{ old('city', $adminDetails->city ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="state"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">State</label>
                                    <input type="text" id="state" name="state"
                                        value="{{ old('state', $adminDetails->state ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('state')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="country"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country</label>
                                    <input type="text" id="country" name="country"
                                        value="{{ old('country', $adminDetails->country ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('country')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Postal
                                        Code</label>
                                    <input type="text" id="postal_code" name="postal_code"
                                        value="{{ old('postal_code', $adminDetails->postal_code ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                                    <textarea id="address" name="address" rows="2"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('address', $adminDetails->address ?? '') }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <button type="button"
                            class="next-tab cursor-pointer inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                            data-next="1">
                            Continue to Organization Details
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
                    <div
                        class="bg-white dark:bg-gray-500 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-500">
                        <div class="p-6">
                            <h2
                                class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-indigo-600"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                        clip-rule="evenodd" />
                                </svg>
                                Organization Details
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Contact Person -->
                                <div>
                                    <label for="alternate_contact_person"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alternate
                                        Contact
                                        Person</label>
                                    <input type="text" id="alternate_contact_person" name="alternate_contact_person"
                                        value="{{ old('alternate_contact_person', $adminDetails->alternate_contact_person ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('alternate_contact_person')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Designation -->
                                <div>
                                    <label for="designation"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Designation</label>
                                    <input type="text" id="designation" name="designation"
                                        value="{{ old('designation', $adminDetails->designation ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('designation')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>


                                <!-- PAN Number -->
                                <div>
                                    <label for="pan_number"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PAN
                                        Number <span class="text-red-500">*</span></label>
                                    <input type="text" id="pan_number" name="pan_number"
                                        value="{{ old('pan_number', $adminDetails->pan_number ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('pan_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- GST Number -->
                                <div>
                                    <label for="gst_number"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">GST
                                        Number <span class="text-red-500">*</span></label>
                                    <input type="text" id="gst_number" name="gst_number"
                                        value="{{ old('gst_number', $adminDetails->gst_number ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('gst_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="other_certificates"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Other
                                        Cetificates(Optional)</label>
                                    <input type="text" id="other_certificates" name="other_certificates"
                                        value="{{ old('other_certificates', $adminDetails->other_certificates ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    @error('other_certificates')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>



                                <!-- Header And Footer For Bill Generation -->
                                <div class="md:col-span-1">
                                    <label for="company_header"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Receipt
                                        Header</label>
                                    <textarea id="company_header" name="company_header" rows="2"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('company_header', $adminDetails->company_header ?? '') }}</textarea>
                                    @error('company_header')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:col-span-1">
                                    <label for="company_footer"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Receipt
                                        Footer</label>
                                    <textarea id="company_footer" name="company_footer" rows="2"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('company_footer', $adminDetails->company_footer ?? '') }}</textarea>
                                    @error('company_footer')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

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

                <!-- Tab 3 - Bank Information -->
                <div id="tab-2" class="space-y-6 tab-content hidden">
                    <div
                        class="bg-white dark:bg-gray-500 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-500">
                        <div class="p-6">
                            <div
                                class="flex justify-between items-center border-b border-b border-gray-200 dark:border-gray-700 mb-2">

                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-indigo-600"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Documents
                                </h2>

                            </div>



                            <div id="add-document-container" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- PAN Card -->
                                <div>
                                    <label for="pan_card_file"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PAN
                                        Card</label>
                                    <div class="flex items-center space-x-4">
                                        @if ($adminDetails && $adminDetails->pan_card_file)
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('storage/' . $adminDetails->pan_card_file) }}"
                                                    alt="PAN Card Preview"
                                                    class="h-16 w-16 object-contain border border-gray-300 rounded-md">
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input type="file" id="pan_card_file" name="pan_card_file"
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                            <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (Max: 5MB)</p>
                                            @error('pan_card_file')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- GST Certificate -->
                                <div>
                                    <label for="gst_certificate_file"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">GST
                                        Certificate</label>
                                    <div class="flex items-center space-x-4">
                                        @if ($adminDetails && $adminDetails->gst_certificate_file)
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('storage/' . $adminDetails->gst_certificate_file) }}"
                                                    alt="GST Certificate Preview"
                                                    class="h-16 w-16 object-contain border border-gray-300 rounded-md">
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input type="file" id="gst_certificate_file" name="gst_certificate_file"
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                            <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (Max: 5MB)</p>
                                            @error('gst_certificate_file')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Registration Document -->
                                <div>
                                    <label for="registration_doc_file"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Registration
                                        Document</label>
                                    <div class="flex items-center space-x-4">
                                        @if ($adminDetails && $adminDetails->registration_doc_file)
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('storage/' . $adminDetails->registration_doc_file) }}"
                                                    alt="Registration Doc Preview"
                                                    class="h-16 w-16 object-contain border border-gray-300 rounded-md">
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input type="file" id="registration_doc_file" name="registration_doc_file"
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                            <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (Max: 5MB)</p>
                                            @error('registration_doc_file')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Other Docs Cheque -->
                                <div>
                                    <label for="other_docs"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Other
                                        Documents</label>
                                    <div class="flex items-center space-x-4">
                                        @if ($adminDetails && $adminDetails->other_docs)
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('storage/' . $adminDetails->other_docs) }}"
                                                    alt="Other Documents Preview"
                                                    class="h-16 w-16 object-contain border border-gray-300 rounded-md">
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input type="file" id="other_docs" name="other_docs"
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                            <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (Max: 5MB)</p>
                                            @error('other_docs')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div></div>
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
                            Continue to Bank Accounts
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
                    <div
                        class="bg-white dark:bg-gray-500 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-500">
                        <div class="p-6">
                            <div
                                class="flex justify-between items-center mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-indigo-600"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                        <path fill-rule="evenodd"
                                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Bank Accounts
                                </h2>
                                <button type="button" id="add-bank-account"
                                    class="px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">+
                                    Add Account</button>
                            </div>

                            <div id="bank-accounts-container" class="space-y-4">
                                @foreach ($bankAccounts as $index => $account)
                                    <div class="bank-account border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                        <input type="hidden" name="bank_accounts[{{ $index }}][id]"
                                            value="{{ $account->id }}">

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Bank Name -->
                                            <div>
                                                <label for="bank_accounts_{{ $index }}_bank_name"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank
                                                    Name</label>
                                                <input type="text" id="bank_accounts_{{ $index }}_bank_name"
                                                    name="bank_accounts[{{ $index }}][bank_name]"
                                                    value="{{ old("bank_accounts.$index.bank_name", $account->bank_name) }}"
                                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                                @error("bank_accounts.$index.bank_name")
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Account Number -->
                                            <div>
                                                <label for="bank_accounts_{{ $index }}_account_number"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account
                                                    Number</label>
                                                <input type="text"
                                                    id="bank_accounts_{{ $index }}_account_number"
                                                    name="bank_accounts[{{ $index }}][account_number]"
                                                    value="{{ old("bank_accounts.$index.account_number", $account->account_number) }}"
                                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                                @error("bank_accounts.$index.account_number")
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Account Holder -->
                                            <div>
                                                <label for="bank_accounts_{{ $index }}_account_holder"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account
                                                    Holder</label>
                                                <input type="text"
                                                    id="bank_accounts_{{ $index }}_account_holder"
                                                    name="bank_accounts[{{ $index }}][account_holder]"
                                                    value="{{ old("bank_accounts.$index.account_holder", $account->account_holder) }}"
                                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                                @error("bank_accounts.$index.account_holder")
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- IFSC Code -->
                                            <div>
                                                <label for="bank_accounts_{{ $index }}_ifsc_code"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IFSC
                                                    Code</label>
                                                <input type="text" id="bank_accounts_{{ $index }}_ifsc_code"
                                                    name="bank_accounts[{{ $index }}][ifsc_code]"
                                                    value="{{ old("bank_accounts.$index.ifsc_code", $account->ifsc_code) }}"
                                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                                @error("bank_accounts.$index.ifsc_code")
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Branch Name -->
                                            <div>
                                                <label for="bank_accounts_{{ $index }}_branch_name"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Branch
                                                    Name</label>
                                                <input type="text" id="bank_accounts_{{ $index }}_branch_name"
                                                    name="bank_accounts[{{ $index }}][branch_name]"
                                                    value="{{ old("bank_accounts.$index.branch_name", $account->branch_name) }}"
                                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                                @error("bank_accounts.$index.branch_name")
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Notes -->
                                            <div>
                                                <label for="bank_accounts_{{ $index }}_notes"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                                                <input type="text" id="bank_accounts_{{ $index }}_notes"
                                                    name="bank_accounts[{{ $index }}][notes]"
                                                    value="{{ old("bank_accounts.$index.notes", $account->notes) }}"
                                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                                @error("bank_accounts.$index.notes")
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Is Primary -->
                                            <div class="flex items-center">
                                                <input type="checkbox" id="bank_accounts_{{ $index }}_is_primary"
                                                    name="bank_accounts[{{ $index }}][is_primary]" value="1"
                                                    {{ old("bank_accounts.$index.is_primary", $account->is_primary) ? 'checked' : '' }}
                                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <label for="bank_accounts_{{ $index }}_is_primary"
                                                    class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Primary
                                                    Account</label>
                                            </div>

                                            <!-- Remove Button -->
                                            <div class="flex justify-end">
                                                <button type="button"
                                                    class="remove-bank-account text-sm text-red-600 hover:text-red-800">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                            Save Changes
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




    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
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

                // Profile image preview
                const profileImageInput = document.getElementById('profile_image');
                const profileImagePreview = document.getElementById('profile-image-preview');

                if (profileImageInput && profileImagePreview) {
                    profileImageInput.addEventListener('change', function() {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                profileImagePreview.src = e.target.result;
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                }

                // Bank account management
                const bankAccountsContainer = document.getElementById('bank-accounts-container');
                const addBankAccountBtn = document.getElementById('add-bank-account');

                // Check if required elements exist
                if (!bankAccountsContainer) {
                    console.error('Bank accounts container not found!');
                    return;
                }

                if (!addBankAccountBtn) {
                    console.error('Add bank account button not found!');
                    return;
                }

                // Initialize bank account index - count existing accounts
                let bankAccountIndex = document.querySelectorAll('.bank-account').length;

                // Add new bank account
                addBankAccountBtn.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent form submission if button is inside a form

                    const template = `
            <div class="bank-account border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Bank Name -->
                    <div>
                        <label for="bank_accounts_${bankAccountIndex}_bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank Name</label>
                        <input type="text" id="bank_accounts_${bankAccountIndex}_bank_name" name="bank_accounts[${bankAccountIndex}][bank_name]" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Account Number -->
                    <div>
                        <label for="bank_accounts_${bankAccountIndex}_account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account Number</label>
                        <input type="text" id="bank_accounts_${bankAccountIndex}_account_number" name="bank_accounts[${bankAccountIndex}][account_number]" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Account Holder -->
                    <div>
                        <label for="bank_accounts_${bankAccountIndex}_account_holder" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account Holder</label>
                        <input type="text" id="bank_accounts_${bankAccountIndex}_account_holder" name="bank_accounts[${bankAccountIndex}][account_holder]" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- IFSC Code -->
                    <div>
                        <label for="bank_accounts_${bankAccountIndex}_ifsc_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IFSC Code</label>
                        <input type="text" id="bank_accounts_${bankAccountIndex}_ifsc_code" name="bank_accounts[${bankAccountIndex}][ifsc_code]" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Branch Name -->
                    <div>
                        <label for="bank_accounts_${bankAccountIndex}_branch_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Branch Name</label>
                        <input type="text" id="bank_accounts_${bankAccountIndex}_branch_name" name="bank_accounts[${bankAccountIndex}][branch_name]" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="bank_accounts_${bankAccountIndex}_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                        <input type="text" id="bank_accounts_${bankAccountIndex}_notes" name="bank_accounts[${bankAccountIndex}][notes]" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Is Primary -->
                    <div class="flex items-center">
                        <input type="checkbox" id="bank_accounts_${bankAccountIndex}_is_primary" name="bank_accounts[${bankAccountIndex}][is_primary]" 
                               value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="bank_accounts_${bankAccountIndex}_is_primary" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Primary Account</label>
                    </div>

                    <!-- Remove Button -->
                    <div class="flex justify-end">
                        <button type="button" class="remove-bank-account text-sm text-red-600 hover:text-red-800">Remove</button>
                    </div>
                </div>
            </div>
        `;

                    bankAccountsContainer.insertAdjacentHTML('beforeend', template);
                    bankAccountIndex++;
                });

                // Remove bank account (using event delegation)
                bankAccountsContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-bank-account')) {
                        e.preventDefault();
                        const bankAccountDiv = e.target.closest('.bank-account');
                        if (bankAccountDiv) {
                            bankAccountDiv.remove();
                            console.log('Bank account removed');
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
