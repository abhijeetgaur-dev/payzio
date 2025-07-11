<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payzio Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        .swiper {
            width: 90%;
            height: 90%;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-pagination-bullet-active {
            background-color: #4f46e5 !important;
        }


        .container {
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gray-50 ">
    <!-- Header -->
    <header class="bg-white shadow-sm px-5">
        <div class="container px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-800">Payzio</h1>
                </div>
            </a>
            {{-- <div class="flex items-center space-x-4">
                <a href="/vendor/login"
                    class="px-4 py-2 rounded-lg font-medium transition-colors duration-200 text-indigo-600 hover:bg-indigo-50">
                    Vendor Sign In
                </a>
                <a href="/vendor/signup"
                    class="px-4 py-2 rounded-lg font-medium transition-colors duration-200 bg-indigo-600 hover:bg-indigo-700 text-white">
                    Vendor Sign Up
                </a>
            </div> --}}
        </div>
    </header>
    <div class="flex justify-center mt-6">
        <div class="w-full max-w-xl">
            @include('partials.flash')
        </div>
    </div>

    <main class="flex-grow ">
        <!-- Hero Section -->
        <section class="py-12 px-20">
            <div class="container flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2 space-y-6 pl-20">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                        Modern QR Payments <br>for Your Business
                    </h1>
                    <p class="text-lg text-gray-600 max-w-lg">
                        A secure, scalable platform for vendors to accept digital payments with minimal effort and
                        maximum efficiency.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-2">
                        <a href="#"
                            class="px-6 py-3 rounded-lg font-medium transition-colors duration-200 bg-indigo-600 hover:bg-indigo-700 text-white text-center">
                            Get Started
                        </a>
                        <button
                            class="px-6 py-3 rounded-lg font-medium transition-colors duration-200 border border-indigo-600 text-indigo-600 hover:bg-indigo-50">
                            Learn More
                        </button>
                    </div>
                </div>

                <!-- Image Slider -->
                <div class="lg:w-1/2 w-full">
                    <div class="swiper max-w-md mx-auto">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="m-2">
                                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                                        <img src="https://images.unsplash.com/photo-1706759755964-b0aa57a58c5a?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            alt="Image 1" class="w-full h-64 rounded-lg object-cover">

                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="bg-white p-6 rounded-2xl shadow-lg">
                                    <img src="https://images.unsplash.com/photo-1706759755851-6163305080f0?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        alt="Mobile Payment" class="w-full h-64 rounded-lg object-cover">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="bg-white p-6 rounded-2xl shadow-lg">
                                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                        alt="Payment Processing" class="w-full h-64 rounded-lg object-cover">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Auth Cards -->
        <section class="py-16 px-6 bg-white">
            <div class="container">
                <div class="mx-[300px]">

                    <!-- Signup Card -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                        <div class="p-8 space-y-6">
                            <div class="flex items-center justify-center">


                            </div>
                            <p class="text-gray-700 text-center text-4xl font-extrabold">Are you looking for Payment
                                Application
                                Service from
                                Payzio?</p>
                            <div class="flex gap-4  items-center justify-center pt-10">
                                <a href="/vendor/signup" class="block">
                                    <button
                                        class="font-extrabold px-3 w-full bg-white border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 py-3 rounded-lg font-medium transition-all duration-200 shadow hover:shadow-md">
                                        <span class="font-extrabold">New Vendor</span>
                                    </button>
                                </a>
                                <a href="/vendor/login" class="block">
                                    <button
                                        class=" px-3 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-medium transition-all duration-200 shadow hover:shadow-md">
                                        <span class="font-extrabold">Existing Vendor</span>
                                    </button>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 px-20 ">
            <div class="container">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Why Choose Payzio Payment?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-blue-50 rounded-xl p-6 hover:shadow-md transition duration-300">
                        <div class="text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800">QR Code Generation</h3>
                        <p class="text-gray-600">Unique QR codes for each vendor, easily distributed to customers.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-blue-50 rounded-xl p-6 hover:shadow-md transition duration-300">
                        <div class="text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Secure Transactions</h3>
                        <p class="text-gray-600">Enterprise-grade security for all your payments.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-blue-50 rounded-xl p-6 hover:shadow-md transition duration-300">
                        <div class="text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Commission Management</h3>
                        <p class="text-gray-600">Automated commission calculations with flexible rules.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-blue-50 rounded-xl p-6 hover:shadow-md transition duration-300">
                        <div class="text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Fast Settlements</h3>
                        <p class="text-gray-600">Timely payouts through integrated banking APIs.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-5 mb-4">
            <div class="mt-16 text-center">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Need help or facing an issue?</h3>
                <p class="text-gray-600 mb-6">Raise a support ticket and our team will assist you promptly.</p>
                <a href="{{ route('raise-ticket.index') }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                    Raise a Ticket
                </a>
            </div>
            <section>
    </main>

    <!-- Footer -->
    <footer class="text-white py-10 bg-slate-950">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pl-20 ">
                <div>
                    <h3 class="text-xl font-bold mb-4">Payzio Payment</h3>
                    <p class="text-gray-400">Enabling smooth, secure, and scalable digital transactions for businesses.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Terms & Conditions</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Disclaimer</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Complaints</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Connect</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Feedback</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Suggestions</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Social</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>

                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 mx-5">
                <p>©2025 Payzio Payment Infrastructure. Developed by Ananta Business Services.</p>
            </div>
        </div>
    </footer>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
</body>

</html>
