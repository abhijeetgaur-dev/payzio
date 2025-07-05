@php
    use Illuminate\Support\Facades\Request;

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
                ['text' => 'All Codes', 'icon' => 'fas fa-layer-group', 'path' => '/admin/qr/index'],
            ],
        ],
        [
            'text' => 'Transactions',
            'icon' => 'fas fa-exchange-alt',
            'subItems' => [
                ['text' => 'All Transactions', 'icon' => 'fas fa-list', 'path' => '/admin/transactions/all'],
                ['text' => 'Completed', 'icon' => 'fas fa-check-circle', 'path' => '/admin/transactions/completed'],
                ['text' => 'Pending', 'icon' => 'fas fa-clock', 'path' => '/admin/transactions/pending'],
            ],
        ],
        [
            'text' => 'Reports',
            'icon' => 'fa-solid fa-chart-pie',
            'subItems' => [
                ['text' => 'Commission Payment', 'icon' => 'fa-solid fa-coins', 'path' => '/admin/reports/commissions'],
                [
                    'text' => 'Vendor Payment Report',
                    'icon' => 'fa-solid fa-medal',
                    'path' => '/admin/reports/vendorpayment',
                ],
            ],
        ],
        [
            'text' => 'Settlements',
            'icon' => 'fa-solid fa-hand-holding-dollar',
            'subItems' => [
                ['text' => 'Pending', 'icon' => 'fas fa-hourglass-half', 'path' => '/admin/settlements/pending'],
                ['text' => 'Completed', 'icon' => 'fas fa-check-circle', 'path' => '/admin/settlements/completed'],
            ],
        ],
        [
            'text' => 'Support Tickets',
            'icon' => 'fas fa-ticket',
            'subItems' => [
                ['text' => 'Tickets Raised', 'icon' => 'fas fa-exclamation-circle', 'path' => '/admin/tickets/raised'],
                ['text' => 'Tickets Closed', 'icon' => 'fas fa-check-circle', 'path' => '/admin/tickets/closed'],
            ],
        ],
        [
            'text' => 'Settings',
            'icon' => 'fas fa-cog',
            'subItems' => [
                ['text' => 'Create Company', 'icon' => 'fas fa-building', 'path' => '/admin/settings/edit'],
                ['text' => 'Change Password', 'icon' => 'fas fa-key', 'path' => '/admin/settings/change-password'],
            ],
        ],
    ];
@endphp


@php

    function isActiveRoute($route)
    {
        return Request::is(ltrim($route, '/'))
            ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-800 dark:text-white font-semibold'
            : 'text-gray-600 dark:text-gray-300';
    }
@endphp


<aside x-data="{
    openMenu: '{{ collect($menuItems)->filter(fn($item) => isset($item['subItems']) && collect($item['subItems'])->pluck('path')->contains(fn($p) => Request::is(ltrim($p, '/'))))->first()['text'] ?? '' }}'
}"
    class="w-64 h-screen bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 fixed flex flex-col">
    <!-- Logo -->
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-700">
        <a href="/admin/dashboard" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">Payzio</a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-2 py-4">
        <ul class="space-y-1">
            @foreach ($menuItems as $item)
                @php
                    $isSubMenuActive =
                        isset($item['subItems']) &&
                        collect($item['subItems'])->pluck('path')->contains(fn($p) => Request::is(ltrim($p, '/')));
                @endphp

                @if (isset($item['subItems']))
                    <li class="mb-1">
                        <button
                            @click="openMenu === '{{ $item['text'] }}' ? openMenu = null : openMenu = '{{ $item['text'] }}'"
                            class="flex items-center justify-between w-full px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 text-sm font-medium transition-all duration-200
                            {{ $isSubMenuActive ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-800 dark:text-white' : 'text-gray-700 dark:text-gray-200' }}">
                            <span class="flex items-center">
                                <i class="{{ $item['icon'] }} text-base mr-2"></i>
                                {{ $item['text'] }}
                            </span>
                            <i :class="openMenu === '{{ $item['text'] }}' ? 'fa-chevron-down' : 'fa-chevron-right'"
                                class="fas text-xs"></i>
                        </button>

                        <ul x-show="openMenu === '{{ $item['text'] }}'" x-transition.duration.200ms
                            class="mt-1 space-y-1 ml-5 border-l border-gray-200 dark:border-gray-700 pl-3" x-cloak>
                            @foreach ($item['subItems'] as $subItem)
                                <li>
                                    <a href="{{ $subItem['path'] }}"
                                        class="flex items-center px-2 py-2 rounded-md transition text-sm {{ Request::is(ltrim($subItem['path'], '/')) ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-700 dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-300' }}">
                                        <i class="{{ $subItem['icon'] }} text-xs mr-2"></i>
                                        {{ $subItem['text'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ $item['path'] }}"
                            class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ Request::is(ltrim($item['path'], '/')) ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-800 dark:text-white font-semibold' : 'text-gray-700 dark:text-gray-200' }}">
                            <i class="{{ $item['icon'] }} text-base mr-3"></i>
                            {{ $item['text'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>

    <!-- Footer Profile -->
    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-800 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-indigo-700 dark:text-indigo-200 text-lg"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ auth('admin')->user()?->name }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ auth('admin')->user()?->email }}
                </p>
                <form method="GET" action="{{ route('admin.logout') }}" class="mt-1">
                    @csrf
                    <button class="text-xs text-red-500 hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </div>
</aside>
