@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-800">Admin Profile</h1>
                <p class="mt-1 text-sm text-gray-700 dark:text-gray-700">View and manage your complete profile information
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.settings.details.edit') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    Edit Profile
                </a>
            </div>
        </div>
        <div>
            @include('partials.flash')
        </div>

        <!-- Main Profile Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 mb-6">
            <div class="md:flex">
                <!-- Company logo Section -->
                <div
                    class="md:w-1/4 p-6 bg-gray-50 dark:bg-gray-700 border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-600">
                    <div class="flex flex-col items-center">
                        <div class="relative mb-4">
                            <div
                                class="w-40 h-40 rounded-full overflow-hidden border-4 border-white dark:border-gray-700 shadow-md">
                                <img src="{{ $adminDetails->company_logo ? asset('storage/' . $adminDetails->company_logo) : asset('storage/images/admin/default-image.jpg') }}"
                                    alt="Company Logo" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $admin->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $admin->email }}</p>

                    </div>
                </div>

                <!-- Profile Details Section -->
                <div class="md:w-3/4 p-6">
                    <div class="space-y-8">
                        <!-- Basic Information Section -->
                        <div>
                            <h3
                                class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-indigo-600"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Basic Information
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $admin->name }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $admin->email }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $admin->phone ?? 'Not provided' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Created</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $admin->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Company/Organization Details Section -->

                        <div>
                            <h3
                                class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-indigo-600"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                        clip-rule="evenodd" />
                                </svg>
                                Organization Details
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact Person</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $adminDetails->contact_person ?? 'Not provided' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Designation</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $adminDetails->designation ?? 'Not provided' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Website</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        @if ($adminDetails->website)
                                            <a href="{{ $adminDetails->website }}" target="_blank"
                                                class="text-indigo-600 hover:text-indigo-800">{{ $adminDetails->website }}</a>
                                        @else
                                            Not provided
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">PAN Number</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $adminDetails->pan_number ?? 'Not provided' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">GST Number</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $adminDetails->gst_number ?? 'Not provided' }}</p>
                                </div>


                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                                    <p class="mt-1 text-sm">
                                        @if ($adminDetails->status == '1')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Verified</span>
                                        @elseif($adminDetails->status == '0')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                            @if ($adminDetails->status_reason)
                                                <p class="text-xs text-gray-500 mt-1">Reason:
                                                    {{ $adminDetails->status_reason }}</p>
                                            @endif
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending
                                                Verification</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Admin Type</p>
                                    <p class="mt-1 text-sm">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">{{ $adminDetails->admin_type }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Address Section -->
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $adminDetails->address ?? 'Not provided' }}<br>
                                    @if ($adminDetails->city)
                                        {{ $adminDetails->city }},
                                    @endif
                                    @if ($adminDetails->state)
                                        {{ $adminDetails->state }},
                                    @endif
                                    @if ($adminDetails->country)
                                        {{ $adminDetails->country }}
                                    @endif
                                    @if ($adminDetails->postal_code)
                                        - {{ $adminDetails->postal_code }}
                                    @endif
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        @if ($adminDetails)
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 mb-6">
                <div class="p-6">
                    <h3
                        class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-indigo-600"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                clip-rule="evenodd" />
                        </svg>
                        Documents
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- PAN Card -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">PAN Card</h4>
                                @if ($adminDetails->pan_card_file)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Uploaded</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Missing</span>
                                @endif
                            </div>
                            @if ($adminDetails->pan_card_file)
                                <div class="h-32 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden mb-2">
                                    <img src="{{ asset('storage/' . $adminDetails->pan_card_file) }}" alt="PAN Card"
                                        class="w-full h-full object-contain">
                                </div>
                                <a href="{{ asset('storage/' . $adminDetails->pan_card_file) }}" target="_blank"
                                    class="text-sm text-indigo-600 hover:text-indigo-800">View Document</a>
                            @else
                                <div class="h-32 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- GST Certificate -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">GST Certificate</h4>
                                @if ($adminDetails->gst_certificate_file)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Uploaded</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Missing</span>
                                @endif
                            </div>
                            @if ($adminDetails->gst_certificate_file)
                                <div class="h-32 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden mb-2">
                                    <img src="{{ asset('storage/' . $adminDetails->gst_certificate_file) }}"
                                        alt="GST Certificate" class="w-full h-full object-contain">
                                </div>
                                <a href="{{ asset('storage/' . $adminDetails->gst_certificate_file) }}" target="_blank"
                                    class="text-sm text-indigo-600 hover:text-indigo-800">View Document</a>
                            @else
                                <div class="h-32 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Registration Document -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Registration Document</h4>
                                @if ($adminDetails->registration_doc_file)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Uploaded</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Missing</span>
                                @endif
                            </div>
                            @if ($adminDetails->registration_doc_file)
                                <div class="h-32 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden mb-2">
                                    <img src="{{ asset('storage/' . $adminDetails->registration_doc_file) }}"
                                        alt="Registration Document" class="w-full h-full object-contain">
                                </div>
                                <a href="{{ asset('storage/' . $adminDetails->registration_doc_file) }}" target="_blank"
                                    class="text-sm text-indigo-600 hover:text-indigo-800">View Document</a>
                            @else
                                <div class="h-32 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Cancelled Cheque -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Cancelled Cheque</h4>
                                @if ($adminDetails->cancelled_cheque_file)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Uploaded</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Missing</span>
                                @endif
                            </div>
                            @if ($adminDetails->cancelled_cheque_file)
                                <div class="h-32 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden mb-2">
                                    <img src="{{ asset('storage/' . $adminDetails->cancelled_cheque_file) }}"
                                        alt="Cancelled Cheque" class="w-full h-full object-contain">
                                </div>
                                <a href="{{ asset('storage/' . $adminDetails->cancelled_cheque_file) }}" target="_blank"
                                    class="text-sm text-indigo-600 hover:text-indigo-800">View Document</a>
                            @else
                                <div class="h-32 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 mb-6">
                <h3>No Details Provided. Please <a href="{{ route('admin.settings.details.edit') }}">Edit</a> Your Profile
                    Details
                </h3>
            </div>
        @endif

        <!-- Bank Accounts Section -->
        @if ($bankAccounts && $bankAccounts->count() > 0)
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h3
                        class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-indigo-600"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                            <path fill-rule="evenodd"
                                d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Bank Accounts
                    </h3>

                    <div class="space-y-4">
                        @foreach ($bankAccounts as $account)
                            <div
                                class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 @if ($account->is_primary) border-l-4 border-l-indigo-500 @endif">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $account->bank_name }}</h4>
                                        @if ($account->is_primary)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mt-1">
                                                Primary Account
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-900 dark:text-white font-mono">
                                            {{ $account->account_number }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">IFSC:
                                            {{ $account->ifsc_code }}</p>
                                    </div>
                                </div>

                                <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-2">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Account Holder</p>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $account->account_holder }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Branch</p>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $account->branch_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Notes</p>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $account->notes ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 mb-6">
                <h3>No Details Provided. Please <a href="{{ route('admin.settings.details.edit') }}">Edit</a> Your Profile
                    Details
                </h3>
            </div>

        @endif
    </div>
@endsection
