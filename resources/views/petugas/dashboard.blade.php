@extends('layouts.petugas')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Petugas</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900">Dashboard Lapangan</h1>
                <p class="mt-2 text-sm text-slate-500">Pekerjaan aktif untuk pickup dan pengiriman produk.</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <a href="{{ route('petugas.pickup.index') }}" class="card card-hover p-6" data-aos="fade-up">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-sm font-semibold text-slate-500">Pickup aktif</div>
                        <div class="mt-3 text-4xl font-black text-green-700">{{ number_format($pickupCount) }}</div>
                        <div class="mt-3 text-sm text-slate-500">Request sampah yang perlu ditindaklanjuti.</div>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-50 text-green-700">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M8.25 18.75a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm7.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM3.75 6h11.5l3 4.5h2v5.25H18M3.75 6v9.75h3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
            </a>

            <a href="{{ route('petugas.pengiriman.index') }}" class="card card-hover p-6" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-sm font-semibold text-slate-500">Pengiriman aktif</div>
                        <div class="mt-3 text-4xl font-black text-green-700">{{ number_format($deliveryCount) }}</div>
                        <div class="mt-3 text-sm text-slate-500">Order produk yang sedang diproses.</div>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-50 text-blue-700">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3.75 7.5h10.5v9H3.75v-9Zm10.5 3h3l3 3v3h-6v-6Zm-7.5 8.25h.01m10.5 0h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
