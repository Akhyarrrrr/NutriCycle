@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between" data-aos="fade-up">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Dashboard Warga</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900 sm:text-4xl">Halo, {{ $user->name }}</h1>
                <p class="mt-2 text-sm text-slate-500">Pantau poin, pemanggilan, dan transaksi terakhir Anda.</p>
            </div>
            <a href="{{ route('pemanggilan.create') }}" class="btn-primary">Panggil Petugas</a>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="card card-hover p-6" data-aos="fade-up">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-bold text-slate-500">Saldo Poin</div>
                    <span class="rounded-lg bg-green-100 p-2 text-green-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 6v12m6-6H6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </span>
                </div>
                <div class="mt-3 text-4xl font-black text-green-700">{{ number_format($user->poin) }}</div>
                <p class="mt-2 text-xs font-semibold text-slate-500">1 poin = Rp10 diskon</p>
            </div>
            <div class="card card-hover p-6" data-aos="fade-up" data-aos-delay="80">
                <div class="text-sm font-bold text-slate-500">Total Transaksi</div>
                <div class="mt-3 text-4xl font-black text-slate-900">{{ number_format($user->transaksi()->count()) }}</div>
                <a href="{{ route('transaksi.index') }}" class="mt-3 inline-flex text-sm font-bold text-green-700">Lihat transaksi</a>
            </div>
            <div class="card card-hover p-6" data-aos="fade-up" data-aos-delay="160">
                <div class="text-sm font-bold text-slate-500">Total Pemanggilan</div>
                <div class="mt-3 text-4xl font-black text-slate-900">{{ number_format($user->pemanggilan()->count()) }}</div>
                <a href="{{ route('pemanggilan.index') }}" class="mt-3 inline-flex text-sm font-bold text-green-700">Lihat pemanggilan</a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <section class="card p-6" data-aos="fade-up">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-lg font-black text-slate-900">Timeline Pemanggilan</h2>
                    <a href="{{ route('pemanggilan.index') }}" class="text-sm font-bold text-green-700">Semua</a>
                </div>
                <div class="space-y-5">
                    @forelse ($pemanggilan as $item)
                        <div class="relative flex gap-4">
                            <div class="flex flex-col items-center">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-green-700">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M8.25 18.75a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm7.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM3.75 6h11.5l3 4.5h2v5.25H18M3.75 6v9.75h3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </span>
                                @if (! $loop->last)
                                    <span class="mt-2 h-full min-h-10 w-px bg-slate-200"></span>
                                @endif
                            </div>
                            <div class="flex-1 rounded-xl bg-slate-50 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="font-black text-slate-900">{{ $item->jadwal_tanggal?->format('d M Y') }}</div>
                                    <x-status-badge :status="$item->status" />
                                </div>
                                <div class="mt-1 text-sm text-slate-500">{{ $item->estimasi_kg }} kg - {{ \Illuminate\Support\Str::limit($item->alamat, 64) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-slate-300 p-6 text-center text-sm text-slate-500">Belum ada pemanggilan.</div>
                    @endforelse
                </div>
            </section>

            <section class="card p-6" data-aos="fade-up" data-aos-delay="120">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-lg font-black text-slate-900">Order Terakhir</h2>
                    <a href="{{ route('transaksi.index') }}" class="text-sm font-bold text-green-700">Semua</a>
                </div>
                <div class="table-shell">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-black uppercase tracking-wide text-slate-500">
                            <tr><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Status</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($transaksi as $item)
                                <tr class="odd:bg-white even:bg-slate-50">
                                    <td class="px-4 py-4 font-bold text-slate-900"><a href="{{ route('transaksi.show', $item->kode_transaksi) }}">{{ $item->kode_transaksi }}</a></td>
                                    <td class="px-4 py-4 font-semibold text-slate-700">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4"><x-status-badge :status="$item->status_pembayaran" /></td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-4 py-10 text-center text-slate-500">Belum ada transaksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection
