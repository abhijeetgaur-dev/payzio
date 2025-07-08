@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-2xl">
        <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-6">
                Set Commission for <span class="text-indigo-600">{{ $vendor->vendor_name }}</span>
            </h1>

            @include('partials.flash')

            <form action="{{ route('admin.vendor.update-commission', $vendor->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                @if ($activeCommission)
                    <div
                        class="p-5 rounded-xl bg-indigo-50 dark:bg-gray-800 border border-indigo-200 dark:border-gray-600 shadow-inner">
                        <h2 class="text-lg font-semibold text-indigo-700 dark:text-indigo-300 mb-3">
                            Active Commission Details
                        </h2>
                        <div class="space-y-2 text-sm text-gray-800 dark:text-gray-300">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Commission Rate:</span>
                                <span class="text-base font-bold text-green-600">{{ $activeCommission->commission }}%</span>

                            </div>
                            @if ($activeCommission->note)
                                <div class="flex justify-between items-center">
                                    <span class="text-base">Note: </span>
                                    <span class="text-base font-bold ">{{ $activeCommission->note }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Active From:</span>
                                <span>{{ $activeCommission->active_date->format('d M Y') }}
                                    {{ $activeCommission->created_at->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div>
                    <label for="commission" class="block text-sm font-semibold text-gray-200 dark:text-gray-200 mb-1">
                        Commission Rate (%)
                    </label>
                    <input type="number" id="commission" name="commission" value="" min="0" max="100"
                        step="0.1"
                        class="text-gray-200 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Enter commission rate" required>
                    @error('commission')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="note" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                        Notes (Optional)
                    </label>
                    <textarea id="note" name="note" rows="3"
                        class="text-gray-200  w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Any notes for this commission..."></textarea>
                    @error('note')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.vendors') }}"
                        class="px-5 py-2 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
