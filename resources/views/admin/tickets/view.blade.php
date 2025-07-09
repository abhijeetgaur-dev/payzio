@extends('layouts.admin')
@php
    $previousUrl = url()->previous();
    $currentUrl = url()->current();
    $backUrl = $previousUrl !== $currentUrl ? $previousUrl : route('admin.tickets.raised');
@endphp


@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-start">
            <a href="{{ $backUrl }}"
                class="text-indigo-600 dark:text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400">
                <i class="fas fa-arrow-left text-2xl"></i>
            </a>
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-700">Ticket Details</h1>
            </div>
        </div>
        <div>
            @include('partials.flash')
        </div>

        <!-- Ticket Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Reference ID</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $ticket['reference_id'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Subject</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $ticket['subject'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Category</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $ticket['category'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Priority</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $ticket['priority'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $ticket['status'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Created At</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        {{ $ticket['created_at']->format('d M Y h:i A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Vendor</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $ticket['vendor']['vendor_name'] }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket['vendor']['email'] }}</p>
                </div>
                @if ($ticket['assigned_to'])
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Assigned To</p>
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            {{ $ticket['assigned_to']->name }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Assign Ticket -->

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <form method="POST" action="{{ route('admin.tickets.assign-ticket', $ticket['id']) }}">
                @csrf
                @method('PUT')
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Assign Ticket</h2>
                <div class="flex items-center gap-4">
                    <select name="assigned_to"
                        class="w-full md:w-1/2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <option value="">Select Admin</option>
                        @foreach ($admins as $admin)
                            <option value="{{ $admin->id }}"
                                {{ isset($ticket['assigned_to']) && $ticket['assigned_to']->id == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }} ({{ $admin->email }})
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Assign</button>
                </div>
            </form>
        </div>

        <!-- Change Status -->
        @if ($ticket['status'] !== 'Resolved')
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                <form method="POST" action="{{ route('admin.tickets.update-status', $ticket['id']) }}">
                    @csrf
                    @method('PUT')
                    <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Change Ticket Status</h2>
                    <div class="flex flex-col gap-4">
                        <div class="flex gap-4">
                            <select name="status" id="status-select"
                                class="w-full md:w-1/2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}"
                                        {{ $ticket['status'] === $status ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                @endforeach
                            </select>

                            <button type="submit"
                                class="w-fit px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update</button>

                        </div>
                        <!-- Resolution textarea -->
                        <div id="resolution-field" class="hidden flex-col">
                            <label for="resolution"
                                class="text-sm text-gray-500 dark:text-gray-400 p-3 hidden">Resolution</label>
                            <textarea name="resolution" id="resolution"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                rows="2" placeholder="Enter resolution details..."></textarea>
                        </div>

                    </div>
                </form>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6 ">
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Ticket Status</h2>
                <span class="inline-block bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded">
                    Resolved
                </span>
            </div>
        @endif

        <!-- Assign Priority-->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.tickets.update-priority', $ticket['id']) }}">
                @csrf
                @method('PUT')
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Change Ticket Priority</h2>
                <div class="flex items-center gap-4">
                    <select name="priority"
                        class="w-full md:w-1/2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority }}" {{ $ticket['priority'] === $priority ? 'selected' : '' }}>
                                {{ $priority }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update</button>
                </div>
            </form>
        </div>


    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status-select');
        const resolutionField = document.getElementById('resolution-field');

        function toggleResolutionField() {
            if (statusSelect.value === 'Resolved') {
                resolutionField.classList.remove('hidden');
            } else {
                resolutionField.classList.add('hidden');
            }
        }

        toggleResolutionField(); // Show/hide on load
        statusSelect.addEventListener('change', toggleResolutionField);
    });
</script>
