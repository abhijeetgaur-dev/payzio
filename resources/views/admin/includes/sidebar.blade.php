<!-- resources/views/components/sidebar.blade.php -->

@php
    $menuItems = [
        [
            'text' => 'Dashboard',
            'icon' => 'fas fa-home',
            'path' => '/admin/dashboard',
        ],
        [
            'text' => 'Vendors',
            'icon' => 'fas fa-users',
            'path' => '/admin/vendors',
        ],
        [
            'text' => 'QR Codes',
            'icon' => 'fas fa-qrcode',
            'subItems' => [
                ['text' => 'Generate QR', 'icon' => 'fas fa-plus-circle', 'path' => '/admin/qr/generate'],
                ['text' => 'All Codes', 'icon' => 'fas fa-layer-group', 'path' => '#'],
            ],
        ],
        [
            'text' => 'Payments',
            'icon' => 'fas fa-rupee-sign',
            'subItems' => [
                ['text' => 'Customer', 'icon' => 'fas fa-user', 'path' => '#'],
                ['text' => 'Vendor', 'icon' => 'fas fa-users', 'path' => '#'],
            ],
        ],
        [
            'text' => 'Settings',
            'icon' => 'fas fa-cog',
            'path' => '#',
        ],
    ];

    // Initialize open submenus state
    $openSubmenus = session()->get('openSubmenus', []);
@endphp

<!-- Add Font Awesome to your layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div id="sidebar"
    class="bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 h-screen transition-all duration-300 ease-in-out relative collapsed">
    <!-- Header -->
    <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800">
        <a href="/admin/dashboard" class="text-xl font-bold text-indigo-600 dark:text-indigo-400 sidebar-logo">
            Payzio
        </a>
        <button id="collapse-btn"
            class="cursor-pointer p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400">
            <i class="fas fa-times text-lg collapse-icon hidden"></i>
            <i class="fas fa-bars  text-lg expand-icon "></i>
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
                                <span class="sidebar-icon-only mx-auto">
                                    <i class="{{ $item['icon'] }} text-lg"></i>
                                </span>
                                <span class="font-medium sidebar-text">{{ $item['text'] }}</span>
                            </div>
                            <span class="sidebar-text" id="dd-btn">
                                @if (in_array($item['text'], $openSubmenus))
                                    <i class="fas fa-chevron-down text-sm"></i>
                                @else
                                    <i class="fas fa-chevron-right text-sm"></i>
                                @endif
                            </span>
                        </button>

                        <ul class="ml-8 mt-1 space-y-1 sidebar-submenu""
                            style="{{ in_array($item['text'], $openSubmenus) ? '' : 'display: none;' }}">
                            @foreach ($item['subItems'] as $subItem)
                                <li key="{{ $subItem['text'] }}" id="dd-ul">
                                    <a href="{{ $subItem['path'] }}"
                                        class="flex items-center w-full p-2 pl-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-sm text-gray-600 dark:text-gray-400 transition-colors duration-200">
                                        <span class="mr-2">
                                            <i class="{{ $subItem['icon'] }} text-sm"></i>
                                        </span>
                                        <span class="sidebar-submenu-text">{{ $subItem['text'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <a href="{{ $item['path'] }}"
                            class="flex items-center w-full p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 transition-colors duration-200">
                            <span class="sidebar-icon-only">
                                <i class="{{ $item['icon'] }} text-lg"></i>
                            </span>
                            <span class="font-medium sidebar-text">{{ $item['text'] }}</span>
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>

    <!-- User Profile -->
    <div class="absolute bottom-0 left-0 right-0 h-20 border-t border-gray-200 dark:border-gray-800 sidebar-profile">
        <div class="flex items-center p-3 pt-4">
            <div
                class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-bold mr-3">
                <i class="fas fa-user text-lg"></i>
            </div>
            <div class="sidebar-profile-text">
                <p class="font-medium text-gray-800 dark:text-gray-200">Admin</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">admin@payzio.com</p>
                <a href="{{ route('logout') }}">
                    @csrf
                    <button
                        class="text-sm font-bold cursor-pointer text-gray-500 dark:text-gray-400 py-1 hover:text-gray-300">
                        Logout
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const collapseBtn = document.getElementById('collapse-btn');
        const dropdownul = document.querySelectorAll('#dd-ul');

        // Check localStorage for collapsed state
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
        }

        // Toggle sidebar collapse
        collapseBtn.addEventListener('click', function() {
            // Save state to localStorage
            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
                dropdownul.forEach(ul => {
                    if (ul.classList.contains('hidden')) {
                        ul.classList.remove('hidden');
                    }
                });
            } else {
                sidebar.classList.add('collapsed');
                dropdownul.forEach(ul => {
                    ul.classList.add('hidden');
                });

            }
        });

        // Initialize submenu states
        const openSubmenus = JSON.parse(localStorage.getItem('openSubmenus') || '[]');
        openSubmenus.forEach(itemText => {
            const submenu = document.querySelector(`button[onclick="toggleSubmenu('${itemText}')"]`);
            if (submenu) {
                const submenuList = submenu.nextElementSibling;

                if (isCollapsed) {
                    submenuList.style.display = 'none';
                } else if (submenuList && submenuList.classList.contains('sidebar-submenu')) {
                    submenuList.style.display = 'block';
                }
            }
        });
    });

    function toggleSubmenu(itemText) {
        const submenu = document.querySelector(`button[onclick="toggleSubmenu('${itemText}')"]`);
        if (!submenu) return;

        const submenuList = submenu.nextElementSibling;
        if (!submenuList || !submenuList.classList.contains('sidebar-submenu')) return;

        const isOpen = submenuList.style.display === 'block';
        submenuList.style.display = isOpen ? 'none' : 'block';

        // Update the chevron icon
        const chevron = submenu.querySelector('.fa-chevron-right, .fa-chevron-down');
        if (chevron) {
            if (isOpen) {
                chevron.classList.replace('fa-chevron-down', 'fa-chevron-right');
            } else {
                chevron.classList.replace('fa-chevron-right', 'fa-chevron-down');
            }
        }

        // Save open submenus to localStorage
        const currentSubmenus = JSON.parse(localStorage.getItem('openSubmenus') || '[]');
        const index = currentSubmenus.indexOf(itemText);

        if (isOpen) {
            if (index !== -1) {
                currentSubmenus.splice(index, 1);
            }
        } else {
            if (index === -1) {
                currentSubmenus.push(itemText);
            }
        }

        localStorage.setItem('openSubmenus', JSON.stringify(currentSubmenus));
    }
</script>

<style>
    #sidebar.collapsed {
        width: 4.5rem;
    }

    #sidebar:not(.collapsed) {
        width: 16rem;
    }

    #sidebar.collapsed .sidebar-text,
    #sidebar.collapsed .sidebar-submenu-text,
    #sidebar.collapsed .sidebar-profile-text,
    #sidebar.collapsed .sidebar-logo,
    #sidebar.collapsed .sidebar-submenu {
        display: none;
    }

    #sidebar.collapsed .sidebar-icon-only {
        margin-right: 0;
    }

    #sidebar:not(.collapsed) .sidebar-icon-only {
        margin-right: 0.75rem;
    }

    #sidebar.collapsed .expand-icon {
        display: inline-block;
    }

    #sidebar.collapsed .collapse-icon {
        display: none;
    }

    #sidebar:not(.collapsed) .expand-icon {
        display: none;
    }

    #sidebar:not(.collapsed) .collapse-icon {
        display: inline-block;
    }
</style>
