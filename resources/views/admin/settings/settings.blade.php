@extends('layouts.admin')

@section('title', 'Admin Settings')

@section('content')
    <div class="p-6 max-w-6xl mx-auto">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-800">Admin Settings</h1>
                <p class="mt-1 text-sm text-gray-700 dark:text-gray-700">Manage your account settings and preferences</p>
            </div>
            <div class="flex items-center space-x-3">
            </div>
            <div>
                @include('partials.flash');
            </div>
        </div>

        <!-- Settings Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="md:flex">
                <!-- Profile Picture Section -->
                <div
                    class="md:w-1/4 p-6 bg-gray-50 dark:bg-gray-700 border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-600">
                    <div class="flex flex-col items-center">
                        <div class="relative mb-4 group">
                            <div
                                class="w-40 h-40 rounded-full overflow-hidden border-4 border-white dark:border-gray-700 shadow-md">
                                <img id="profile-preview"
                                    src="{{ $admin->profile_image ? asset('storage/' . $admin->profile_image) : asset('storage/images/admin/default-image.jpg') }}"
                                    alt="Profile Image"
                                    class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-75">
                            </div>
                            <label for="profile_image"
                                class="absolute bottom-3 right-3 bg-indigo-600 text-white rounded-full p-2 cursor-pointer hover:bg-indigo-700 transition-all duration-200 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                </svg>
                                <input type="file" id="profile_image" name="profile_image" class="hidden"
                                    accept="image/*">
                            </label>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $admin->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $admin->email }}</p>

                        <div class="mt-4 text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-100">
                                Last login:
                                <span class="font-medium text-gray-700 dark:text-gray-300">
                                    {{ $admin->last_login_at ? $admin->last_login_at->format('M d, Y h:i A') : 'Never' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Account Settings Form -->
                <div class="md:w-3/4 p-6">
                    <form id="admin-settings-form" action="{{ route('admin.settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
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
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Full Name
                                        </label>
                                        <div class="relative">
                                            <input type="text" id="name" name="name"
                                                value="{{ old('name', $admin->name) }}" required
                                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="email" id="email" name="email"
                                                value="{{ old('email', $admin->email) }}" required readonly
                                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white bg-gray-100 dark:bg-gray-600">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Contact support to change
                                            your email</p>
                                    </div>

                                    <div>
                                        <label for="phone"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Phone Number
                                        </label>
                                        <div class="relative">
                                            <input type="tel" id="phone" name="phone"
                                                value="{{ old('phone', $admin->phone) }}"
                                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                    <div>
                                        <label for="current_password"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Current Password
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="current_password" name="current_password"
                                                placeholder="Enter your current password to update your password"
                                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="new_password"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            New Password
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="new_password" name="new_password"
                                                placeholder="Enter your new password"
                                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank to keep
                                            current password</p>
                                    </div>

                                    <div>
                                        <label for="new_password_confirmation"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Confirm New Password
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="new_password_confirmation"
                                                name="new_password_confirmation" placeholder="Verify your new password"
                                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div>
                                <a href="{{ route('admin.settings.details.show') }}"
                                    class="px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 flex items-center">
                                    <!-- Pencil/Edit Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M17.414 2.586a2 2 0 010 2.828L8.414 14.414a1 1 0 01-.707.293H5a1 1 0 01-1-1v-2.707a1 1 0 01.293-.707L14.586 2.586a2 2 0 012.828 0zM5 13.586V15h1.414l9-9L14 4.586l-9 9z" />
                                    </svg>

                                    Edit Details
                                </a>
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
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Profile image preview
                const profileImageInput = document.getElementById('profile_image');
                const profilePreview = document.getElementById('profile-preview');

                profileImageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profilePreview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });

                // Form validation
                const form = document.getElementById('admin-settings-form');
                form.addEventListener('submit', function(e) {
                    const newPassword = document.getElementById('new_password').value;
                    const confirmPassword = document.getElementById('new_password_confirmation').value;
                    const currentPassword = document.getElementById('current_password').value;

                    if (newPassword && !currentPassword) {
                        e.preventDefault();
                        alert('Please enter your current password to change it!');
                        return;
                    }

                    if (newPassword && newPassword !== confirmPassword) {
                        e.preventDefault();
                        alert('New password and confirmation do not match!');
                    }
                });
            });
        </script>
    @endpush
@endsection
