@extends('layouts.petugas')

@section('content')
    <div class="space-y-8">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-green-700">Petugas</p>
            <h1 class="mt-2 text-3xl font-black text-slate-900">Dashboard</h1>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <a href="{{ route('petugas.pickup.index') }}" class="rounded-lg border border-slate-200 bg-white p-6 hover:border-green-200">
                <div class="text-sm font-semibold text-slate-500">Pickup aktif</div>
                <div class="mt-2 text-4xl font-black text-green-700">{{ number_format($pickupCount) }}</div>
            </a>
            <a href="{{ route('petugas.pengiriman.index') }}" class="rounded-lg border border-slate-200 bg-white p-6 hover:border-green-200">
                <div class="text-sm font-semibold text-slate-500">Pengiriman aktif</div>
                <div class="mt-2 text-4xl font-black text-green-700">{{ number_format($deliveryCount) }}</div>
            </a>
        </div>
    </div>
@endsection
