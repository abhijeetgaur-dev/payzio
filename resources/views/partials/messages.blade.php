@php
    $messageTypes = [
        'success' => 'green',
        'error' => 'red',
    ];
@endphp

@foreach ($messageTypes as $type => $color)
    @if (Session::has($type))
        <div class="mb-4 px-4 py-3 rounded border border-{{ $color }}-300 bg-{{ $color }}-100 text-{{ $color }}-800">
            {{ Session::get($type) }}
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="mb-4 px-4 py-3 rounded border border-red-300 bg-red-100 text-red-800">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
