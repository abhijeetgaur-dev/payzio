@extends('layouts.admin')

@section('content')
    {{-- <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 text-gray-800 m-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Set Commission</h2>
    </div> --}}
    <div class="container mx-auto px-4 py-8 max-w-md mt-20 ">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Set Commission for {{ $vendor->vendor_name }}</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.vendor.update-commission', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="commission" class="block text-sm font-medium text-gray-700 mb-1">
                        Commission Rate (%)
                    </label>
                    <input type="number" id="commission" name="commission" value="" min="0" max="100"
                        step="0.01"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                    @error('commission')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="note" class="block text-sm font-medium text-gray-700 mb-1">
                        Notes (Optional)
                    </label>
                    <textarea id="note" name="note" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    @error('note')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.vendors') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
