@extends('layouts.vendor')

@section('content')
    <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8 space-y-8">
                <!-- Header -->
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">QR Code Details</h1>
                        <p class="mt-1 text-sm text-gray-500">
                            <spam>QR ID: {{ $qr->id }}</span>
                        </p>

                    </div>

                    <div>

                        <a href="{{ route('vendor.qr.index') }}"
                            class="px-4 py-2 rounded-md text-sm font-medium border border-gray-300 text-gray-700 bg-white hover:bg-gray-100 transition">
                            Back to List
                        </a>

                    </div>
                </div>

                <!-- Main Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- QR Code Box -->
                    <div class="flex justify-center">
                        <div
                            class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-6 shadow-sm w-full max-w-sm">
                            @if (Storage::disk('public')->exists('qr_codes/' . $qr->qr_code_url))
                                <img src="{{ asset('storage/qr_codes/' . $qr->qr_code_url) }}" alt="QR Code"
                                    class="w-full h-auto object-contain">
                            @else
                                <div class="h-48 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-qrcode text-4xl"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Info Section -->
                    <div>
                        <!-- Vendor Info -->
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-800 border-b pb-1 mb-3">Vendor Information</h2>
                            <ul class="space-y-1 text-gray-700">
                                <li><strong>Name:</strong> {{ $vendor->vendor_name }}</li>
                                <li><strong>Email:</strong> {{ $vendor->email }}</li>
                                <li><strong>Phone:</strong> {{ $vendor->phone }}</li>
                            </ul>
                        </div>

                        <!-- QR Info -->
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-800 border-b pb-1 mb-3">QR Code Information</h2>
                            <ul class="space-y-1 text-gray-700">
                                <li><strong>Created on:</strong> {{ $qr->created_at->format('M d, Y') }}</li>
                            </ul>
                        </div>

                        <!-- Status  -->
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-2xl font-semibold 
                                @if ($qr->is_active == '1') bg-green-100 text-green-700 
                                @else bg-red-100 text-red-700 @endif">
                            {{ $qr->is_active == '1' ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3">

                    <a href="{{ asset('storage/qr_codes/' . $qr->qr_code_url) }}" download="QR_{{ $qr->id }}.png"
                        class="px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        Download QR
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
