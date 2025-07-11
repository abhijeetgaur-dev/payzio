@extends('layouts.main')

@section('title', 'Raise Ticket')
@section('header', 'Raise Ticket')

@section('content')
    <div class="min-h-screen bg-gray-100 py-10 px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-indigo-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Raise a Complaint</h2>
                <p class="text-sm text-indigo-200">Having trouble with a transaction? Let us help you out.</p>
            </div>

            <!-- Body -->
            <div class="px-6 py-8">
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('raise-ticket.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name <span
                                class="text-red-500 font-bold">*</span></label>
                        <input type="text" name="name" id="name"
                            class="mt-1 block w-full px-4 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-5">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number <span
                                class="text-red-500 font-bold">*</span></label>
                        <input type="tel" name="phone" id="phone"
                            class="mt-1 block w-full px-4 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('phone') border-red-500 @enderror"
                            value="{{ old('phone') }}" required>
                        @error('phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span
                                class="text-red-500 font-bold">*</span></label>
                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full px-4 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div class="mb-5">
                        <label for="subject" class="block text-sm font-medium text-gray-700">Subject <span
                                class="text-red-500 font-bold">*</span></label>
                        <input type="text" name="subject" id="subject"
                            class="mt-1 block w-full px-4 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('subject') border-red-500 @enderror"
                            value="{{ old('subject') }}" required>
                        @error('subject')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-5">
                        <label for="category" class="block text-sm font-medium text-gray-700">Category <span
                                class="text-red-500 font-bold">*</span></label>
                        <select name="category" id="category"
                            class="mt-1 block w-full px-4 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('category') border-red-500 @enderror"
                            required>
                            <option value="" disabled {{ old('category') == '' ? 'selected' : '' }}>Select Category
                            </option>
                            <option value="payment" {{ old('category') == 'payment' ? 'selected' : '' }}>Payment</option>
                            <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Technical
                            </option>
                            <option value="account" {{ old('category') == 'account' ? 'selected' : '' }}>Account</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description <span
                                class="text-red-500 font-bold">*</span></label>
                        <textarea id="description" name="description" rows="5"
                            class="mt-1 block w-full px-4 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('description') border-red-500 @enderror"
                            required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Attachments -->
                    <div class="mb-6">
                        <label for="attachments" class="block text-sm font-medium text-gray-700">Attachments
                            (optional)</label>
                        <input type="file" name="attachments[]" id="attachments" multiple
                            class="mt-2 block w-full text-sm text-gray-600 border border-gray-300 rounded-md cursor-pointer focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <p class="text-xs text-gray-500 mt-1">You can upload multiple files (PDF, image, or receipt).</p>
                        @error('attachments')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Complaint
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
