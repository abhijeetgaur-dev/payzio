<!-- resources/views/components/sidebar.blade.php -->
@props(['isMobile' => false, 'isCollapsed' => false])

@php
    $menuItems = [
        [
            'text' => 'Dashboard',
            'icon' => 'fa-light fa-home',
            'path' => '/dashboard',
        ],
        [
            'text' => 'Vendors',
            'icon' => 'fa-light fa-users',
            'path' => '/vendors',
        ],
        [
            'text' => 'QR Codes',
            'icon' => 'fa-light fa-qrcode',
            'subItems' => [
                ['text' => 'Generate QR', 'icon' => 'fa-light fa-plus-circle', 'path' => '/qr/generate'],
                ['text' => 'All Codes', 'icon' => 'fa-light fa-layers', 'path' => '/qr/list'],
            ],
        ],
        [
            'text' => 'Payments',
            'icon' => 'fa-light fa-currency-inr',
            'subItems' => [
                ['text' => 'Customer', 'icon' => 'fa-light fa-user', 'path' => '/pages/CustomerPayments'],
                ['text' => 'Vendor', 'icon' => 'fa-light fa-users', 'path' => '/pages/VendorPayments'],
            ],
        ],
        [
            'text' => 'Settings',
            'icon' => 'fa-light fa-gear',
            'path' => '/pages/Settings',
        ],
    ];

    // Initialize open submenus state
    $openSubmenus = session()->get('openSubmenus', []);
@endphp

<div
    class="{{ $isCollapsed ? 'w-20' : 'w-64' }} bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 h-screen transition-all duration-300 ease-in-out relative">
    <!-- Header -->
    <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800">
        @if (!$isCollapsed)
            <a href="/dashboard" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                XYZPay
            </a>
        @endif
        <button onclick="toggleSidebarCollapse()"
            class="cursor-pointer p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400">
            @if ($isCollapsed)
                <x-icon name="menu" class="w-5 h-5" />
            @else
                <x-icon name="x" class="w-5 h-5" />
            @endif
        </button>
    </div>

    <!-- Navigation -->
    <nav class="p-2">
        <ul class="space-y-1">
            @foreach ($menuItems as $item)
                <li key="{{ $item['text'] }}">
                    @if (isset($item['subItems']))
                        <button onclick="toggleSubmenu('{{ $item['text'] }}')"
                            class="flex items-center justify-between w-full p-3 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 {{ in_array($item['text'], $openSubmenus) ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300' }}">
                            <div class="flex items-center">
                                <span class="{{ $isCollapsed ? 'mx-3' : 'mr-3' }}">
                                    <i class="{{ $item['icon'] }} w-4 h-4" />
                                </span>
                                @if (!$isCollapsed)
                                    <span class="font-medium">{{ $item['text'] }}</span>
                                @endif
                            </div>
                            @if (!$isCollapsed)
                                @if (in_array($item['text'], $openSubmenus))
                                    <x-icon name="chevron-down" class="w-4 h-4" />
                                @else
                                    <x-icon name="chevron-right" class="w-4 h-4" />
                                @endif
                            @endif
                        </button>

                        @if (!$isCollapsed && in_array($item['text'], $openSubmenus))
                            <ul class="ml-8 mt-1 space-y-1">
                                @foreach ($item['subItems'] as $subItem)
                                    <li key="{{ $subItem['text'] }}">
                                        <a href="{{ $subItem['path'] }}"
                                            class="flex items-center w-full p-2 pl-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-sm text-gray-600 dark:text-gray-400 transition-colors duration-200">
                                            <span class="mr-2">
                                                <x-icon name="{{ $subItem['icon'] }}" class="w-3 h-3" />
                                            </span>
                                            {{ $subItem['text'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @else
                        <a href="{{ $item['path'] }}"
                            class="flex items-center w-full p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 transition-colors duration-200 {{ $isCollapsed ? 'justify-center' : '' }}">
                            <span class="{{ $isCollapsed ? '' : 'mr-3' }}">
                                <x-icon name="{{ $item['icon'] }}" class="w-4 h-4" />
                            </span>
                            @if (!$isCollapsed)
                                <span class="font-medium">{{ $item['text'] }}</span>
                            @endif
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>

    <!-- User Profile - Only shown when not collapsed -->
    @if (!$isCollapsed)
        <div class="absolute bottom-0 h-20 w-full border-t border-gray-200 dark:border-gray-800 mb-5">
            <div class="flex items-center p-3 pt-4">
                <div
                    class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-bold mr-3">
                    <x-icon name="user" class="w-4 h-4" />
                </div>
                <div>
                    <p class="font-medium text-gray-800 dark:text-gray-200">Admin</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">admin@xyzpay.com</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-sm font-bold cursor-pointer text-gray-500 dark:text-gray-400 py-1 mb-3 hover:text-gray-300">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Add this script to your main layout or a separate JS file -->
<script>
    function toggleSidebarCollapse() {
        // This would be handled by Livewire or Alpine.js in a real implementation
        console.log('Toggle sidebar collapse');
        // You would typically emit an event or make an AJAX call here
    }

    function toggleSubmenu(itemText) {
        // Store open/closed state in session or local storage
        const currentSubmenus = JSON.parse(sessionStorage.getItem('openSubmenus') || '[]');
        const index = currentSubmenus.indexOf(itemText);

        if (index === -1) {
            currentSubmenus.push(itemText);
        } else {
            currentSubmenus.splice(index, 1);
        }

        sessionStorage.setItem('openSubmenus', JSON.stringify(currentSubmenus));

        // For a full page reload implementation, you would submit a form or make an AJAX call
        // to persist this state to the server
        window.location.reload();
    }

    // Initialize submenu states on load
    document.addEventListener('DOMContentLoaded', function() {
        const openSubmenus = JSON.parse(sessionStorage.getItem('openSubmenus') || '[]');
        // You would typically send this to the server to maintain state between page loads
    });
</script>
