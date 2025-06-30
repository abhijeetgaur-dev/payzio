{{-- Success Message --}}
@if (session('success'))
    <div
        class="flex items-center justify-between p-4 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-lg">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-800 hover:text-green-900 text-sm">✕</button>
    </div>
@endif

{{-- Error Message --}}
@if (session('error'))
    <div class="flex items-center justify-between p-4 mb-4 text-red-800 bg-red-100 border border-red-300 rounded-lg">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-red-800 hover:text-red-900 text-sm">✕</button>
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="p-4 mb-4 text-yellow-900 bg-yellow-100 border border-yellow-300 rounded-lg">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14" />
            </svg>
            <span>There were some validation errors:</span>
        </div>
        <ul class="list-disc list-inside text-sm text-yellow-800">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
