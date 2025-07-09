@extends('layouts.vendor')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-10 px-4">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Raise New Ticket</h2>
                <p class="text-sm text-indigo-200">Submit your issue and our team will assist you shortly.</p>
            </div>

            <!-- Body -->
            <div class="px-6 py-8">
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('vendor.tickets.store') }}">
                    @csrf

                    <!-- Subject -->
                    <div class="mb-5">
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject
                            *</label>
                        <input type="text" name="subject" id="subject"
                            class="mt-1 block w-full px-4 py-2 text-sm border rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('subject') border-red-500 @enderror"
                            value="{{ old('subject') }}" required>
                        @error('subject')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-5">
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category
                            *</label>
                        <select name="category" id="category"
                            class="mt-1 block w-full px-4 py-2 text-sm border rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('category') border-red-500 @enderror"
                            required>
                            <option value="" disabled {{ old('category') == '' ? 'selected' : '' }}>Select Category
                            </option>
                            <option value="technical" {{ old('category') == 'payment' ? 'selected' : '' }}>Payment
                            </option>
                            <option value="billing" {{ old('category') == 'technical' ? 'selected' : '' }}>Technical
                            </option>
                            <option value="general" {{ old('category') == 'account' ? 'selected' : '' }}>Account
                            </option>
                            <option value="feature_request" {{ old('category') == 'other' ? 'selected' : '' }}>
                                Other</option>
                        </select>
                        @error('category')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description *</label>
                        <textarea id="description" name="description" rows="5"
                            class="mt-1 block w-full px-4 py-2 text-sm border rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('description') border-red-500 @enderror"
                            required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
