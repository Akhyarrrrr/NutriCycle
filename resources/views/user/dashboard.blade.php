@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-green-700">Dashboard</p>
            <h1 class="text-3xl font-black text-slate-900">Halo, {{ $user->name }}</h1>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-6">
                <div class="text-sm font-semibold text-slate-500">Poin tersedia</div>
                <div class="mt-2 text-4xl font-black text-green-700">{{ number_format($user->poin) }}</div>
            </div>
            <a href="{{ route('pemanggilan.create') }}" class="rounded-lg border border-green-200 bg-green-50 p-6 hover:border-green-300">
                <div class="text-sm font-semibold text-green-700">Aksi cepat</div>
                <div class="mt-2 text-xl font-black text-green-900">Panggil Petugas</div>
            </a>
            <a href="{{ route('produk.index') }}" class="rounded-lg border border-slate-200 bg-white p-6 hover:border-green-200">
                <div class="text-sm font-semibold text-slate-500">Belanja</div>
                <div class="mt-2 text-xl font-black text-slate-900">Lihat Produk</div>
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="rounded-lg border border-slate-200 bg-white p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900">Pemanggilan Terakhir</h2>
                    <a href="{{ route('pemanggilan.index') }}" class="text-sm font-bold text-green-700">Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse ($pemanggilan as $item)
                        <div class="flex items-center justify-between gap-4 rounded-lg bg-slate-50 p-4">
                            <div>
                                <div class="font-semibold text-slate-900">{{ $item->jadwal_tanggal?->format('d M Y') }}</div>
                                <div class="text-sm text-slate-500">{{ $item->estimasi_kg }} kg</div>
                            </div>
                            <x-status-badge :status="$item->status" />
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada pemanggilan.</p>
                    @endforelse
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900">Transaksi Terakhir</h2>
                    <a href="{{ route('transaksi.index') }}" class="text-sm font-bold text-green-700">Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse ($transaksi as $item)
                        <a href="{{ route('transaksi.show', $item->kode_transaksi) }}" class="flex items-center justify-between gap-4 rounded-lg bg-slate-50 p-4 hover:bg-green-50">
                            <div>
                                <div class="font-semibold text-slate-900">{{ $item->kode_transaksi }}</div>
                                <div class="text-sm text-slate-500">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</div>
                            </div>
                            <x-status-badge :status="$item->status_pembayaran" />
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
