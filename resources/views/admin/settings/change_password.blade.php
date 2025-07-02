@extends('layouts.admin')

@section('title', 'Change Password')

@section('content')
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-700">Change Password</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-700">Update your account password securely</p>
            </div>
        </div>

        <!-- Flash Messages -->
        @include('partials.flash')
        <!-- Settings Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <form id="admin-settings-form" action="{{ route('admin.settings.change-password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Password Change Section -->
                        <div>
                            <h3
                                class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-indigo-600"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Password Settings
                            </h3>

                            <div class="space-y-4">
                                <!-- Current Password -->
                                <div>
                                    <label for="current_password"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Current Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="current_password" name="current_password"
                                            placeholder="Enter your current password" value="{{ old('current_password') }}"
                                            class="w-full pl-10 pr-4 py-2 border @error('current_password') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                            required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div>
                                    <label for="new_password"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        New Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="new_password" name="new_password"
                                            placeholder="Enter your new password (min. 8 characters)"
                                            class="w-full pl-10 pr-4 py-2 border @error('new_password') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                            required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('new_password')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm New Password -->
                                <div>
                                    <label for="new_password_confirmation"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Confirm New Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="new_password_confirmation"
                                            name="new_password_confirmation" placeholder="Confirm your new password"
                                            class="w-full pl-10 pr-4 py-2 border @error('new_password_confirmation') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                            required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('new_password_confirmation')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password Requirements -->
                                <div
                                    class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                    <div class="flex">
                                        <svg class="flex-shrink-0 h-5 w-5 text-blue-400" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Password
                                                Requirements</h3>
                                            <div class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                                                <ul class="list-disc list-inside space-y-1">
                                                    <li>Minimum 8 characters long</li>
                                                    <li>Must be different from current password</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" onclick="window.location.href='{{ route('admin.dashboard') }}'"
                                class="mr-3 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('admin-settings-form');
                const newPassword = document.getElementById('new_password');
                const confirmPassword = document.getElementById('new_password_confirmation');
                const currentPassword = document.getElementById('current_password');

                // Real-time password confirmation validation
                function validatePasswordMatch() {
                    if (newPassword.value && confirmPassword.value) {
                        if (newPassword.value !== confirmPassword.value) {
                            confirmPassword.setCustomValidity('Passwords do not match');
                        } else {
                            confirmPassword.setCustomValidity('');
                        }
                    }
                }

                newPassword.addEventListener('input', validatePasswordMatch);
                confirmPassword.addEventListener('input', validatePasswordMatch);

                // Form submission validation
                form.addEventListener('submit', function(e) {
                    if (!currentPassword.value.trim()) {
                        e.preventDefault();
                        currentPassword.focus();
                        alert('Please enter your current password');
                        return false;
                    }

                    if (!newPassword.value.trim()) {
                        e.preventDefault();
                        newPassword.focus();
                        alert('Please enter a new password');
                        return false;
                    }

                    if (newPassword.value !== confirmPassword.value) {
                        e.preventDefault();
                        confirmPassword.focus();
                        alert('New password and confirmation do not match');
                        return false;
                    }

                    if (newPassword.value.length < 8) {
                        e.preventDefault();
                        newPassword.focus();
                        alert('Password must be at least 8 characters long');
                        return false;
                    }
                });
            });
        </script>
    @endpush
@endsection
