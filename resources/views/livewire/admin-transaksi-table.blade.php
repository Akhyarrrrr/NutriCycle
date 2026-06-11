<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-black text-slate-900">Data Transaksi</h2>
            <p class="mt-1 text-sm text-slate-500">Filter berdasarkan status pengiriman.</p>
        </div>
        <select wire:model.live="status" class="form-input max-w-xs">
            <option value="">Semua pengiriman</option>
            <option value="menunggu">Menunggu</option>
            <option value="dikonfirmasi">Dikonfirmasi</option>
            <option value="dikirim">Dikirim</option>
            <option value="selesai">Selesai</option>
        </select>
    </div>

    <div wire:loading class="space-y-3">
        <x-skeleton class="h-12 w-full" />
        <x-skeleton class="h-20 w-full" />
        <x-skeleton class="h-20 w-full" />
        <x-skeleton class="h-20 w-full" />
    </div>

    <div wire:loading.remove class="table-shell">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-900 text-left text-xs font-semibold uppercase tracking-wide text-white">
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
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-slate-50/70' }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 40 }}">
                        <td class="px-4 py-4 align-top">
                            <div class="font-black text-slate-900">{{ $item->kode_transaksi }}</div>
                            @if ($item->petugas)
                                <div class="mt-2 text-xs font-bold text-green-700">Petugas: {{ $item->petugas->name }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 align-top text-slate-700">{{ $item->user?->name }}</td>
                        <td class="px-4 py-4 align-top font-black text-green-700">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 align-top"><x-status-badge :status="$item->status_pembayaran" /></td>
                        <td class="px-4 py-4 align-top"><x-status-badge :status="$item->status_pengiriman" /></td>
                        <td class="px-4 py-4 align-top">
                            <form method="POST" action="{{ route('admin.transaksi.update', $item) }}" class="grid min-w-[460px] grid-cols-[1fr_1fr_auto] gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="petugas_id" class="form-input">
                                    <option value="">Belum ditugaskan</option>
                                    @foreach ($petugas as $petugasUser)
                                        <option value="{{ $petugasUser->id }}" @selected($item->petugas_id === $petugasUser->id)>{{ $petugasUser->name }}</option>
                                    @endforeach
                                </select>
                                <select name="status_pengiriman" class="form-input">
                                    @foreach (['menunggu', 'dikonfirmasi', 'dikirim', 'selesai'] as $statusOption)
                                        <option value="{{ $statusOption }}" @selected($item->status_pengiriman === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="icon-button bg-green-600 text-white hover:bg-green-700 hover:text-white" title="Simpan update transaksi" aria-label="Simpan update transaksi">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-lg bg-green-50 text-green-700">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                            </div>
                            <div class="mt-4 font-bold text-slate-900">Belum ada transaksi</div>
                            <div class="mt-1 text-sm text-slate-500">Coba ubah filter status pengiriman.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div wire:loading.remove>{{ $transaksi->links() }}</div>
</div>
