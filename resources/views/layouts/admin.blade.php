<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Payzio') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .sidebar.collapsed {
            width: 20px;
        }

        .sidebar {
            width: 80px;
        }

        input[readonly]:not([type="file"]) {
            background-color: #f0f0f0;
            color: #525252;
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>

<body class="min-h-screen">
    <!-- Sidebar (fixed position) -->
    <div class="fixed top-0 left-0 z-50 text-gray-700 shadow-2xl">
        @include('admin.includes.sidebar')
    </div>

    <!-- Main content area -->
    <div class="flex flex-col min-h-screen">
        <div class="bg-gray-300 flex flex-col flex-1 transition-all duration-300">
            <div class="flex-grow ml-20 ">
                @yield('content')
            </div>
        </div>
    </div>
    <div>
        @include('admin.includes.footer')
    </div>

    <!-- Responsive behavior script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let isMobile = window.innerWidth < 768;
            let isCollapsed = isMobile;

            function handleResize() {
                isMobile = window.innerWidth < 768;
                isCollapsed = isMobile;
                // You may need to update the sidebar state here if needed
                // This would require additional JavaScript or Livewire/Alpine components
            }

            window.addEventListener('resize', handleResize);

            // Toggle collapse function
            window.toggleSidebarCollapse = function() {
                isCollapsed = !isCollapsed;
                // Update the sidebar state
                // This would require additional JavaScript or Livewire/Alpine components
            };
        });
    </script>
</body>

</html>
