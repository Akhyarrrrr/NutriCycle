@extends('layouts.petugas')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-6">
        <h1 class="text-3xl font-black text-slate-900">Pengiriman Produk</h1>
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Warga</th><th class="px-4 py-3">Alamat</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Update</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transaksi as $item)
                        <tr>
                            <td class="px-4 py-4 font-bold text-slate-900">{{ $item->kode_transaksi }}</td>
                            <td class="px-4 py-4">{{ $item->user?->name }}</td>
                            <td class="px-4 py-4 max-w-sm">{{ $item->alamat_kirim }}</td>
                            <td class="px-4 py-4"><x-status-badge :status="$item->status_pengiriman" /></td>
                            <td class="px-4 py-4">
                                <form method="POST" action="{{ route('petugas.pengiriman.update', $item) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status_pengiriman" class="rounded-lg border border-slate-300 px-3 py-2">
                                        <option value="dikonfirmasi" @selected($item->status_pengiriman === 'dikonfirmasi')>Dikonfirmasi</option>
                                        <option value="dikirim" @selected($item->status_pengiriman === 'dikirim')>Dikirim</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                    <button class="rounded-lg bg-green-600 px-4 py-2 font-bold text-white hover:bg-green-700">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-slate-500">Tidak ada pengiriman aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $transaksi->links() }}</div>
    </section>
@endsection
