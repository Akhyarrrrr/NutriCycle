<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-lg font-semibold text-slate-900">Data Transaksi</h2>
        <select wire:model.live="status" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700">
            <option value="">Semua pengiriman</option>
            <option value="menunggu">Menunggu</option>
            <option value="dikonfirmasi">Dikonfirmasi</option>
            <option value="dikirim">Dikirim</option>
            <option value="selesai">Selesai</option>
        </select>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Warga</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Pembayaran</th>
                    <th class="px-4 py-3">Pengiriman</th>
                    <th class="px-4 py-3">Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($transaksi as $item)
                    <tr>
                        <td class="px-4 py-4 align-top font-semibold text-slate-900">{{ $item->kode_transaksi }}</td>
                        <td class="px-4 py-4 align-top text-slate-700">{{ $item->user?->name }}</td>
                        <td class="px-4 py-4 align-top text-slate-700">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 align-top"><x-status-badge :status="$item->status_pembayaran" /></td>
                        <td class="px-4 py-4 align-top"><x-status-badge :status="$item->status_pengiriman" /></td>
                        <td class="px-4 py-4 align-top">
                            <form method="POST" action="{{ route('admin.transaksi.update', $item) }}" class="grid min-w-[430px] grid-cols-[1fr_1fr_auto] gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="petugas_id" class="rounded-lg border border-slate-300 px-3 py-2">
                                    <option value="">Belum ditugaskan</option>
                                    @foreach ($petugas as $petugasUser)
                                        <option value="{{ $petugasUser->id }}" @selected($item->petugas_id === $petugasUser->id)>{{ $petugasUser->name }}</option>
                                    @endforeach
                                </select>
                                <select name="status_pengiriman" class="rounded-lg border border-slate-300 px-3 py-2">
                                    @foreach (['menunggu', 'dikonfirmasi', 'dikirim', 'selesai'] as $status)
                                        <option value="{{ $status }}" @selected($item->status_pengiriman === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="rounded-lg bg-green-600 px-4 py-2 font-semibold text-white hover:bg-green-700">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-slate-500">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $transaksi->links() }}
</div>
