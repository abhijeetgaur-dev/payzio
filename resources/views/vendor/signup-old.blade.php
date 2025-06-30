<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Signup | Payzio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --dark-bg: #0f172a;
            --dark-card: #1e293b;
            --dark-text: #f8fafc;
            --dark-border: #334155;
        }

        input {
            border: 2px solid purple;
            outline: none;
        }

        input:focus {
            border-color: purple;
            box-shadow: 0 0 0 2px rgba(128, 0, 128, 0.3);
            /* optional purple glow */
        }

        select {
            border: 2px solid purple;
            outline: none;
        }

        select:focus {
            border-color: purple;
            box-shadow: 0 0 0 2px rgba(128, 0, 128, 0.3);
            /* optional purple glow */
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--dark-bg);
            color: var(--dark-text);
        }

        .card {
            background-color: var(--dark-card);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            border: 1px solid var(--dark-border);
        }

        .form-input {
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            background-color: #1e293b;
            border-color: var(--dark-border);
            color: var(--dark-text);
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
            border-color: var(--primary);
        }

        .form-input::placeholder {
            color: #64748b;
        }

        .btn-primary {
            background: var(--primary);
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        }

        .file-upload {
            transition: all 0.3s ease;
            border-color: var(--dark-border);
            background-color: #1e293b;
        }

        .file-upload:hover {
            border-color: var(--primary);
            background-color: #1e293b;
        }

        .file-upload-label {
            transition: all 0.3s ease;
            border-color: var(--dark-border);
            background-color: #1e293b;
        }

        .file-upload-label:hover {
            background-color: #334155;
            border-color: var(--primary);
        }

        .gradient-text {
            background: linear-gradient(90deg, #818cf8, #a78bfa);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .error-message {
            background-color: #7f1d1d;
            border-left: 4px solid #ef4444;
            padding: 0.5rem;
            border-radius: 0 4px 4px 0;
            margin-top: 0.25rem;
        }

        .section-number {
            background-color: var(--primary-dark);
            color: white;
        }

        .file-name {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #818cf8;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-xl">
        <div class="text-center mb-8">
            <div class="flex justify-center">
                <a href="{{ route('home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                    </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-100 mt-4">Join <span class="gradient-text">Payzio</span></h1>
            </a>
            <p class="mt-2 text-gray-400">Start accepting payments in minutes</p>
        </div>

        <div class="card p-8">
            <div>@include('partials.flash')</div>
            <form action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Business Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-100 mb-4 flex items-center">
                            <span
                                class="section-number flex items-center justify-center w-6 h-6 rounded-full mr-2 text-sm font-medium">1</span>
                            Business Information
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label for="vendor_name" class="block text-sm font-medium text-gray-300 mb-1">
                                    Business Name <span class="text-red-400">*</span>
                                </label>
                                <input type="text" id="vendor_name" name="vendor_name" required
                                    class="form-input block w-full rounded-lg py-2.5 px-3.5 focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Your business name" value="{{ old('vendor_name') }}">
                                @error('vendor_name')
                                    <p class="error-message text-sm text-red-200">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="business_category" class="block text-sm font-medium text-gray-300 mb-1">
                                        Category <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text" id="business_category" name="business_category" required
                                        class="form-input block w-full rounded-lg py-2.5 px-3.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="e.g. Retail" value="{{ old('business_category') }}">
                                    @error('business_category')
                                        <p class="error-message text-sm text-red-200">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="vendor_type" class="block text-sm font-medium text-gray-300 mb-1">
                                        Type <span class="text-red-400">*</span>
                                    </label>
                                    <select id="vendor_type" name="vendor_type" required
                                        class="form-input block w-full rounded-lg py-2.5 px-3.5 focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="" class="bg-gray-800">Select</option>
                                        <option value="individual" @if (old('vendor_type') == 'individual') selected @endif
                                            class="bg-gray-800">Individual</option>
                                        <option value="company" @if (old('vendor_type') == 'company') selected @endif
                                            class="bg-gray-800">Company</option>
                                        <option value="partner" @if (old('vendor_type') == 'partner') selected @endif
                                            class="bg-gray-800">Partnership</option>
                                    </select>
                                    @error('vendor_type')
                                        <p class="error-message text-sm text-red-200">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-100 mb-4 flex items-center">
                            <span
                                class="section-number flex items-center justify-center w-6 h-6 rounded-full mr-2 text-sm font-medium">2</span>
                            Contact Information
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label for="contact_person" class="block text-sm font-medium text-gray-300 mb-1">
                                    Contact Person <span class="text-red-400">*</span>
                                </label>
                                <input type="text" id="contact_person" name="contact_person" required
                                    class="form-input block w-full rounded-lg py-2.5 px-3.5 focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Full name" value="{{ old('contact_person') }}">
                                @error('contact_person')
                                    <p class="error-message text-sm text-red-200">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1">
                                        Email <span class="text-red-400">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" required
                                        class="form-input block w-full rounded-lg py-2.5 px-3.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="you@example.com" value="{{ old('email') }}">
                                    @error('email')
                                        <p class="error-message text-sm text-red-200">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-300 mb-1">
                                        Phone <span class="text-red-400">*</span>
                                    </label>
                                    <input type="tel" id="phone" name="phone" required
                                        class="form-input block w-full rounded-lg py-2.5 px-3.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="+91 9876543210" value="{{ old('phone') }}">
                                    @error('phone')
                                        <p class="error-message text-sm text-red-200">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1">
                                        Password <span class="text-red-400">*</span>
                                    </label>
                                    <input type="password" id="password" name="password" required
                                        class="form-input block w-full rounded-lg py-2.5 px-3.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="••••••••">
                                    @error('password')
                                        <p class="error-message text-sm text-red-200">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-300 mb-1">
                                        Confirm Password <span class="text-red-400">*</span>
                                    </label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        required
                                        class="form-input block w-full rounded-lg py-2.5 px-3.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="••••••••">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-100 mb-4 flex items-center">
                            <span
                                class="section-number flex items-center justify-center w-6 h-6 rounded-full mr-2 text-sm font-medium">3</span>
                            Verification
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label for="pan_number" class="block text-sm font-medium text-gray-300 mb-1">
                                    PAN Number <span class="text-red-400">*</span>
                                </label>
                                <input type="text" id="pan_number" name="pan_number" required
                                    class="form-input block w-full rounded-lg py-2.5 px-3.5 focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="ABCDE1234F" value="{{ old('pan_number') }}">
                                @error('pan_number')
                                    <p class="error-message text-sm text-red-200">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">
                                    PAN Card Upload <span class="text-red-400">*</span>
                                </label>
                                <label for="pan_card_file"
                                    class="file-upload-label flex flex-col items-center justify-center w-full p-5 border-2 border-dashed rounded-xl cursor-pointer hover:border-indigo-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-10 h-10 mb-3 text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                        <p class="text-sm text-gray-400 text-center">
                                            <span class="font-medium text-indigo-400">Click to upload</span><br>
                                            or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">PDF, JPG, or PNG (max 5MB)</p>
                                    </div>
                                    <input id="pan_card_file" name="pan_card_file" type="file" class="hidden"
                                        accept=".pdf,.jpg,.jpeg,.png" required />
                                </label>
                                <div id="file-name-display" class="file-name"></div>
                                @error('pan_card_file')
                                    <p class="error-message text-sm text-red-200">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="btn-primary w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Vendor Account
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-6 text-center text-sm text-gray-400">
            <p>Already have an account? <a href="/vendor/login"
                    class="font-medium text-indigo-400 hover:text-indigo-300">Sign in</a></p>
            <p class="mt-2">By registering, you agree to our <a href="/terms"
                    class="font-medium text-indigo-400 hover:text-indigo-300">Terms</a> and <a href="/privacy"
                    class="font-medium text-indigo-400 hover:text-indigo-300">Privacy Policy</a></p>
        </div>
    </div>

    <script>
        // Display the selected file name
        document.getElementById('pan_card_file').addEventListener('change', function(e) {
            const fileNameDisplay = document.getElementById('file-name-display');
            if (this.files.length > 0) {
                fileNameDisplay.textContent = 'Selected file: ' + this.files[0].name;
            } else {
                fileNameDisplay.textContent = '';
            }

            // Validate file size (5MB max)
            if (this.files.length > 0) {
                const fileSize = this.files[0].size / 1024 / 1024; // in MB
                if (fileSize > 5) {
                    fileNameDisplay.textContent = 'File size exceeds 5MB limit';
                    fileNameDisplay.style.color = '#ef4444';
                    this.value = ''; // clear the file input
                } else {
                    fileNameDisplay.style.color = '#818cf8';
                }
            }
        });

        // Handle drag and drop for file upload
        const fileUploadLabel = document.querySelector('.file-upload-label');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileUploadLabel.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileUploadLabel.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileUploadLabel.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            fileUploadLabel.classList.add('border-indigo-400');
            fileUploadLabel.classList.add('bg-gray-800');
        }

        function unhighlight() {
            fileUploadLabel.classList.remove('border-indigo-400');
            fileUploadLabel.classList.remove('bg-gray-800');
        }

        fileUploadLabel.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            const input = document.getElementById('pan_card_file');
            input.files = files;

            // Trigger the change event
            const event = new Event('change');
            input.dispatchEvent(event);
        }
    </script>
</body>

</html>
