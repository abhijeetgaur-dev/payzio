@extends('layouts.admin')

@section('title', 'Admin Settings')

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Admin Settings</h2>
            </div>
        </div>

        <!-- Settings Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Profile Picture Section -->
                    <div class="md:w-1/3">
                        <div class="flex flex-col items-center">
                            <div class="relative mb-4">
                                <img id="profile-preview"
                                    src="{{ $admin->profile_image ? asset('storage/' . $admin->profile_image) : asset('storage/images/admin/default-image.jpg') }}"
                                    alt="Profile Image"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-600">
                                <label for="profile_image"
                                    class="absolute bottom-0 right-0 bg-indigo-600 text-white rounded-full p-2 cursor-pointer hover:bg-indigo-700 transition-colors">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" id="profile_image" name="profile_image" class="hidden"
                                        accept="image/*">
                                </label>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $admin->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $admin->email }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Last login:
                                {{ $admin->last_login_at ? $admin->last_login_at->format('M d, Y h:i A') : 'Never' }}
                            </p>
                        </div>
                    </div>

                    <!-- Account Settings Form -->
                    <div class="md:w-2/3">
                        <form id="admin-settings-form" action="{{ route('admin.settings.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <!-- Basic Information Section -->
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Basic Information
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="name"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 ">Full
                                                Name *</label>
                                            <input type="text" id="name" name="name"
                                                value="{{ old('name', $admin->name) }}" required
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                                readonly>
                                        </div>
                                        <div>
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                                                *</label>
                                            <input type="email" id="email" name="email"
                                                value="{{ old('email', $admin->email) }}" required
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                                readonly>
                                        </div>
                                        <div>
                                            <label for="phone"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                                            <input type="tel" id="phone" name="phone"
                                                value="{{ old('phone', $admin->phone) }}"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Change Section -->
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Change Password</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="current_password"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current
                                                Password</label>
                                            <input type="password" id="current_password" name="current_password"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                                readonly>
                                        </div>
                                        <div>
                                            <label for="new_password"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New
                                                Password</label>
                                            <input type="password" id="new_password" name="new_password"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank to keep
                                                current password</p>
                                        </div>
                                        <div>
                                            <label for="new_password_confirmation"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm
                                                New Password</label>
                                            <input type="password" id="new_password_confirmation"
                                                name="new_password_confirmation"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Status -->
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Account Status</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $admin->status ? 'Active' : 'Inactive' }}
                                        </p>
                                    </div>
                                    <div class="flex items-center">
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full {{ $admin->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $admin->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="flex justify-end pt-4">
                                    <button type="button" onclick="window.location.href='{{ route('admin.dashboard') }}'"
                                        class="mr-3 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
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

                    if (newPassword && newPassword !== confirmPassword) {
                        e.preventDefault();
                        alert('New password and confirmation do not match!');
                    }
                });
            });
        </script>
    @endpush
@endsection
