<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen">
    <!-- Sidebar (fixed position) -->
    <div class="fixed top-0 left-0 z-50 text-gray-700 shadow-2xl">
        @include('admin.includes.sidebar', [
            'isMobile' => $isMobile ?? false,
            'isCollapsed' => $isCollapsed ?? false,
        ])
    </div>

    <!-- Main content area -->
    <div class="flex min-h-screen">
        <div class="flex flex-col flex-1 ml-20 bg-gray-100 transition-all duration-300">
            <div class="flex-grow">
                @yield('content')
            </div>
            <div>
                @include('admin.includes.footer')
            </div>
        </div>
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
