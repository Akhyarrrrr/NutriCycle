@props(['status'])

@php
    $classes = match ($status) {
        'menunggu', 'pending' => 'bg-yellow-100 text-yellow-800 ring-yellow-200',
        'dikonfirmasi' => 'bg-blue-100 text-blue-800 ring-blue-200',
        'dijemput', 'dikirim' => 'bg-orange-100 text-orange-800 ring-orange-200',
        'selesai', 'paid' => 'bg-green-100 text-green-800 ring-green-200',
        'dibatalkan', 'failed' => 'bg-red-100 text-red-800 ring-red-200',
        default => 'bg-slate-100 text-slate-700 ring-slate-200',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset '.$classes]) }}>
    {{ ucfirst($status) }}
</span>
