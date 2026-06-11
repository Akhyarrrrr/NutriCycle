@extends('layouts.app')

@section('content')
    <section class="card p-5 sm:p-6" data-aos="fade-up">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Transaksi</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900">Riwayat Order</h1>
            </div>
            <a href="{{ route('produk.index') }}" class="btn-secondary">Belanja Lagi</a>
        </div>
        <div class="mt-6 table-shell">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-black uppercase tracking-wide text-slate-500">
                    <tr><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Pembayaran</th><th class="px-4 py-3">Pengiriman</th><th class="px-4 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transaksi as $item)
                        <tr class="odd:bg-white even:bg-slate-50" data-aos="fade-up">
                            <td class="px-4 py-4 font-black text-slate-900">{{ $item->kode_transaksi }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-700">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-4"><x-status-badge :status="$item->status_pembayaran" /></td>
                            <td class="px-4 py-4"><x-status-badge :status="$item->status_pengiriman" /></td>
                            <td class="px-4 py-4 text-right"><a href="{{ route('transaksi.show', $item->kode_transaksi) }}" class="btn-secondary px-3 py-2">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-12 text-center text-slate-500">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $transaksi->links() }}</div>
    </section>
@endsection
