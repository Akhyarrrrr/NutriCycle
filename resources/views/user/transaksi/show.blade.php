@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
        <section class="rounded-lg border border-slate-200 bg-white p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-green-700">Transaksi</p>
                    <h1 class="mt-2 text-2xl font-black text-slate-900">{{ $transaksi->kode_transaksi }}</h1>
                </div>
                <div class="flex gap-2"><x-status-badge :status="$transaksi->status_pembayaran" /><x-status-badge :status="$transaksi->status_pengiriman" /></div>
            </div>
            <div class="mt-6 divide-y divide-slate-100">
                @foreach ($transaksi->details as $detail)
                    <div class="flex gap-4 py-4">
                        <img src="{{ cloudinaryUrl($detail->produk?->gambar) }}" alt="{{ $detail->produk?->nama }}" class="h-20 w-20 rounded-lg object-cover">
                        <div class="flex-1">
                            <div class="font-bold text-slate-900">{{ $detail->produk?->nama }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $detail->jumlah }} x Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</div>
                        </div>
                        <div class="font-bold text-slate-900">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>
        </section>
        <aside class="h-fit rounded-lg border border-slate-200 bg-white p-6">
            <h2 class="text-lg font-bold text-slate-900">Ringkasan</h2>
            <div class="mt-5 space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-slate-500">Subtotal</span><span>Rp{{ number_format($transaksi->details->sum('subtotal'), 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Diskon poin</span><span>- Rp{{ number_format($transaksi->diskon_poin, 0, ',', '.') }}</span></div>
                <div class="border-t border-slate-200 pt-3 flex justify-between text-base font-black"><span>Total</span><span>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span></div>
            </div>
            <div class="mt-5 rounded-lg bg-slate-50 p-4 text-sm text-slate-600">{{ $transaksi->alamat_kirim }}</div>
            @if ($transaksi->status_pembayaran === 'pending' && $transaksi->snap_token)
                <button id="pay-button" class="mt-5 w-full rounded-lg bg-green-600 px-5 py-3 font-bold text-white hover:bg-green-700">Bayar Sekarang</button>
            @elseif ($transaksi->status_pembayaran === 'pending')
                <div class="mt-5 rounded-lg bg-yellow-50 p-4 text-sm font-medium text-yellow-800">Snap token belum tersedia. Pastikan ENV Midtrans sudah terisi.</div>
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
