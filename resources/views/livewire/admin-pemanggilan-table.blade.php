<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-black text-slate-900">Data Pemanggilan</h2>
            <p class="mt-1 text-sm text-slate-500">Filter status untuk mempercepat triase operasional.</p>
        </div>
        <select wire:model.live="status" class="form-input max-w-xs">
            <option value="">Semua status</option>
            <option value="menunggu">Menunggu</option>
            <option value="dikonfirmasi">Dikonfirmasi</option>
            <option value="dijemput">Dijemput</option>
            <option value="selesai">Selesai</option>
            <option value="dibatalkan">Dibatalkan</option>
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
                    <th class="px-4 py-3">Warga</th>
                    <th class="px-4 py-3">Jadwal</th>
                    <th class="px-4 py-3">Estimasi</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($pemanggilan as $item)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-slate-50/70' }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 40 }}">
                        <td class="px-4 py-4 align-top">
                            <div class="font-bold text-slate-900">{{ $item->user?->name }}</div>
                            <div class="mt-1 max-w-xs text-slate-500">{{ $item->alamat }}</div>
                            @if ($item->petugas)
                                <div class="mt-2 text-xs font-bold text-green-700">Petugas: {{ $item->petugas->name }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 align-top text-slate-700">
                            <div class="font-semibold">{{ $item->jadwal_tanggal?->format('d M Y') }}</div>
                            <div class="mt-1 text-slate-500">{{ \Illuminate\Support\Str::limit($item->jadwal_jam, 5, '') }}</div>
                        </td>
                        <td class="px-4 py-4 align-top font-black text-green-700">{{ $item->estimasi_kg }} kg</td>
                        <td class="px-4 py-4 align-top">
                            <x-status-badge :status="$item->status" />
                        </td>
                        <td class="px-4 py-4 align-top">
                            <form method="POST" action="{{ route('admin.pemanggilan.update', $item) }}" class="grid min-w-[560px] grid-cols-[1fr_1fr_120px_auto] gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="petugas_id" class="form-input">
                                    <option value="">Belum ditugaskan</option>
                                    @foreach ($petugas as $petugasUser)
                                        <option value="{{ $petugasUser->id }}" @selected($item->petugas_id === $petugasUser->id)>{{ $petugasUser->name }}</option>
                                    @endforeach
                                </select>
                                <select name="status" class="form-input">
                                    @foreach (['menunggu', 'dikonfirmasi', 'dijemput', 'selesai', 'dibatalkan'] as $statusOption)
                                        <option value="{{ $statusOption }}" @selected($item->status === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                    @endforeach
                                </select>
                                <input type="number" min="0" name="poin_diberikan" value="{{ $item->poin_diberikan }}" class="form-input" aria-label="Poin diberikan">
                                <button type="submit" class="icon-button bg-green-600 text-white hover:bg-green-700 hover:text-white" title="Simpan update pemanggilan" aria-label="Simpan update pemanggilan">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-lg bg-green-50 text-green-700">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M8.25 18.75a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm7.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM3.75 6h11.5l3 4.5h2v5.25H18M3.75 6v9.75h3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div class="mt-4 font-bold text-slate-900">Belum ada pemanggilan</div>
                            <div class="mt-1 text-sm text-slate-500">Coba ubah filter status atau tunggu request warga baru.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div wire:loading.remove>{{ $pemanggilan->links() }}</div>
</div>
