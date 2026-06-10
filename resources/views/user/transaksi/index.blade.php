@extends('layouts.app')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-6">
        <h1 class="text-3xl font-black text-slate-900">Transaksi</h1>
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Pembayaran</th><th class="px-4 py-3">Pengiriman</th><th class="px-4 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transaksi as $item)
                        <tr>
                            <td class="px-4 py-4 font-semibold">{{ $item->kode_transaksi }}</td>
                            <td class="px-4 py-4">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-4"><x-status-badge :status="$item->status_pembayaran" /></td>
                            <td class="px-4 py-4"><x-status-badge :status="$item->status_pengiriman" /></td>
                            <td class="px-4 py-4 text-right"><a href="{{ route('transaksi.show', $item->kode_transaksi) }}" class="font-bold text-green-700">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $transaksi->links() }}</div>
    </section>
@endsection
