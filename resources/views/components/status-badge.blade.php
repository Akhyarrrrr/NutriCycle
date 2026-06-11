@props(['status'])

@php
    $statusValue = (string) ($status ?? '-');

    $classes = match ($statusValue) {
        'menunggu', 'pending' => 'bg-yellow-100 text-yellow-800 ring-yellow-200',
        'dikonfirmasi' => 'bg-blue-100 text-blue-800 ring-blue-200',
        'dijemput', 'dikirim' => 'bg-orange-100 text-orange-800 ring-orange-200',
        'selesai', 'paid' => 'bg-green-100 text-green-800 ring-green-200',
        'dibatalkan', 'failed', 'deny', 'cancel', 'expire' => 'bg-red-100 text-red-800 ring-red-200',
        default => 'bg-slate-100 text-slate-700 ring-slate-200',
    };

    $dot = match ($statusValue) {
        'menunggu', 'pending' => 'bg-yellow-500',
        'dikonfirmasi' => 'bg-blue-500',
        'dijemput', 'dikirim' => 'bg-orange-500',
        'selesai', 'paid' => 'bg-green-500',
        'dibatalkan', 'failed', 'deny', 'cancel', 'expire' => 'bg-red-500',
        default => 'bg-slate-400',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset shadow-sm '.$classes]) }}>
    <span class="h-1.5 w-1.5 rounded-full {{ $dot }}"></span>
    {{ ucfirst($statusValue) }}
</span>
