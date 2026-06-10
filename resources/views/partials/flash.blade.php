@foreach (['success' => 'green', 'error' => 'red', 'warning' => 'yellow', 'status' => 'blue'] as $key => $color)
    @if (session($key))
        @php
            $classes = match ($color) {
                'green' => 'border-green-200 bg-green-50 text-green-800',
                'red' => 'border-red-200 bg-red-50 text-red-800',
                'yellow' => 'border-yellow-200 bg-yellow-50 text-yellow-800',
                default => 'border-blue-200 bg-blue-50 text-blue-800',
            };
        @endphp
        <div class="mb-6 rounded-lg border px-4 py-3 text-sm font-medium {{ $classes }}">
            {{ session($key) }}
        </div>
    @endif
@endforeach
