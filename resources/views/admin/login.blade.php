<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Payzio Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include any additional CSS or JS files needed -->
</head>

<body
    class="min-h-screen bg-gradient-to-br from-indigo-50 to-white dark:from-gray-900 dark:to-gray-700 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class='absolute top-0 right-0 p-4'>
        <a href="{{ route('vendor.signup') }}"
            class="font-semibold bg-gradient-to-br from-purple-500 to-pink-600 
            hover:from-zinc-800 hover:to-zinc-900 
            rounded-sm cursor-pointer text-sm text-zinc-200 
            hover:text-white mr-4 px-3 py-2 
            transition duration-200 ease-in-out">
            Vendor Sign Up
        </a>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <!-- Logo would go here -->
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
            Secure Admin Portal
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
            Enter your credentials to access the dashboard
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div
            class="bg-white dark:bg-gray-800 py-8 px-4 shadow-lg sm:rounded-lg sm:px-10 border border-gray-200 dark:border-gray-700">
            <!-- Login Tabs -->
            <div class="flex border-b border-gray-200 dark:border-gray-700 mb-6">
                <button type="button" onclick="setActiveTab('email')" id="email-tab"
                    class="cursor-pointer flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm border-indigo-500 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400">
                    <div class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email Login
                    </div>
                </button>
                <button type="button" onclick="setActiveTab('phone')" id="phone-tab"
                    class="cursor-pointer flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <div class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Phone Login
                    </div>
                </button>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.auth') }}" class="space-y-6">
                @csrf

                @if ($errors->any())
                    <div class="rounded-md bg-red-50 dark:bg-red-900 dark:bg-opacity-20 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400 dark:text-red-300"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                    {{ $errors->first() }}
                                </h3>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Email Login -->
                <div id="email-form">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email address
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            value="{{ old('email') }}"
                            class="py-3 pl-10 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                            placeholder="admin@xyzfintech.com" />
                    </div>
                </div>

                <!-- Phone Login (hidden by default) -->
                <div id="phone-form" class="hidden">
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Phone number
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input id="phone" name="phone" type="tel" autocomplete="tel"
                            value="{{ old('phone') }}"
                            class="py-3 pl-10 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                            placeholder="+1 (555) 123-4567" />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password"
                            required
                            class="py-3 pl-10 pr-10 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                            placeholder="••••••••" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePasswordVisibility()"
                                class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" id="show-password-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" id="hide-password-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700" />
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href=""
                            class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="cursor-pointer w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign in to dashboard
                        <span class="px-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-3 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </span>

                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                            Advanced security
                        </span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <div>
                        <a href=""
                            class="w-full inline-flex justify-center items-center py-2 px-4 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-5 h-5" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path fill="#4285F4"
                                    d="M533.5 278.4c0-17.4-1.6-34.1-4.6-50.4H272v95.4h146.9c-6.4 34.6-25.4 63.9-54 83.5v68h87.3c51.1-47.1 81.3-116.4 81.3-196.5z" />
                                <path fill="#34A853"
                                    d="M272 544.3c73.4 0 135-24.4 179.9-66.5l-87.3-68c-24.2 16.3-55.1 25.9-92.6 25.9-71 0-131-47.9-152.4-112.1H29.8v70.6C74.3 483 166.3 544.3 272 544.3z" />
                                <path fill="#FBBC04"
                                    d="M119.6 323.6c-10.2-30.5-10.2-63.4 0-93.9v-70.6H29.8c-41.1 82.1-41.1 179.3 0 261.4l89.8-70.6z" />
                                <path fill="#EA4335"
                                    d="M272 107.7c39.9 0 75.7 13.7 103.8 40.7l77.8-77.8C407 24.4 345.4 0 272 0 166.3 0 74.3 61.3 29.8 154.1l89.8 70.6C141 155.6 201 107.7 272 107.7z" />
                            </svg>
                        </a>
                    </div>

                    <div>
                        <a href=""
                            class="w-full inline-flex justify-center items-center py-2 px-4 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path
                                    d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
            <p>
                Need help?{' '}
                <a href=""
                    class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                    Contact our support team
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline ml-1 h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </p>
        </div>
    </div>

    <script>
        function setActiveTab(tab) {
            // Update tabs
            document.getElementById('email-tab').classList.remove('border-indigo-500', 'text-indigo-600',
                'dark:text-indigo-400', 'dark:border-indigo-400');
            document.getElementById('email-tab').classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400',
                'hover:text-gray-700', 'dark:hover:text-gray-300');

            document.getElementById('phone-tab').classList.remove('border-indigo-500', 'text-indigo-600',
                'dark:text-indigo-400', 'dark:border-indigo-400');
            document.getElementById('phone-tab').classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400',
                'hover:text-gray-700', 'dark:hover:text-gray-300');

            if (tab === 'email') {
                document.getElementById('email-tab').classList.add('border-indigo-500', 'text-indigo-600',
                    'dark:text-indigo-400', 'dark:border-indigo-400');
                document.getElementById('email-tab').classList.remove('border-transparent', 'text-gray-500',
                    'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300');
                document.getElementById('email-form').classList.remove('hidden');
                document.getElementById('phone-form').classList.add('hidden');
            } else {
                document.getElementById('phone-tab').classList.add('border-indigo-500', 'text-indigo-600',
                    'dark:text-indigo-400', 'dark:border-indigo-400');
                document.getElementById('phone-tab').classList.remove('border-transparent', 'text-gray-500',
                    'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300');
                document.getElementById('phone-form').classList.remove('hidden');
                document.getElementById('email-form').classList.add('hidden');
            }
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const showIcon = document.getElementById('show-password-icon');
            const hideIcon = document.getElementById('hide-password-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showIcon.classList.add('hidden');
                hideIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                showIcon.classList.remove('hidden');
                hideIcon.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
