@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1fr_370px]">
        <section class="card p-5 sm:p-6" data-aos="fade-up">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Transaksi</p>
                    <h1 class="mt-2 text-2xl font-black text-slate-900">{{ $transaksi->kode_transaksi }}</h1>
                </div>
                <div class="flex flex-wrap gap-2"><x-status-badge :status="$transaksi->status_pembayaran" /><x-status-badge :status="$transaksi->status_pengiriman" /></div>
            </div>
            <div class="mt-6 divide-y divide-slate-100">
                @foreach ($transaksi->details as $detail)
                    <div class="flex gap-4 py-4" data-aos="fade-up">
                        <img src="{{ cloudinaryUrl($detail->produk?->gambar) }}" alt="{{ $detail->produk?->nama }}" class="h-20 w-20 rounded-xl object-cover shadow-sm">
                        <div class="flex-1">
                            <div class="font-black text-slate-900">{{ $detail->produk?->nama }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $detail->jumlah }} x Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</div>
                        </div>
                        <div class="font-black text-green-700">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>
        </section>
        <aside class="card h-fit p-6 lg:sticky lg:top-24" data-aos="fade-up" data-aos-delay="120">
            <h2 class="text-lg font-black text-slate-900">Ringkasan</h2>
            <div class="mt-5 space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-slate-500">Subtotal</span><span>Rp{{ number_format($transaksi->details->sum('subtotal'), 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Diskon poin</span><span>- Rp{{ number_format($transaksi->diskon_poin, 0, ',', '.') }}</span></div>
                <div class="flex justify-between rounded-xl bg-green-50 p-3 text-base font-black text-green-900"><span>Total</span><span>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span></div>
            </div>
            <div class="mt-5 rounded-xl bg-slate-50 p-4 text-sm leading-6 text-slate-600">{{ $transaksi->alamat_kirim }}</div>
            @if ($transaksi->status_pembayaran === 'pending' && $transaksi->snap_token)
                <button id="pay-button" class="btn-primary mt-5 w-full">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7.5 10.5V8.25a4.5 4.5 0 0 1 9 0v2.25m-11.25 0h13.5v9.75H5.25V10.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Bayar Sekarang
                </button>
            @elseif ($transaksi->status_pembayaran === 'pending')
                <div class="mt-5 rounded-xl bg-yellow-50 p-4 text-sm font-medium text-yellow-800">Snap token belum tersedia. Pastikan ENV Midtrans sudah terisi.</div>
            @endif
        </aside>
    </div>
@endsection

@if ($transaksi->status_pembayaran === 'pending' && $transaksi->snap_token)
    @push('scripts')
        <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            document.getElementById('pay-button')?.addEventListener('click', function () {
                window.snap.pay(@json($transaksi->snap_token), {
                    onSuccess: function () { window.location.reload(); },
                    onPending: function () { window.location.reload(); },
                    onError: function () { window.location.reload(); },
                    onClose: function () {}
                });
            });
        </script>
    @endpush
@endif
