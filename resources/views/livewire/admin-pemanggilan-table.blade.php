<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-lg font-semibold text-slate-900">Data Pemanggilan</h2>
        <select wire:model.live="status" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700">
            <option value="">Semua status</option>
            <option value="menunggu">Menunggu</option>
            <option value="dikonfirmasi">Dikonfirmasi</option>
            <option value="dijemput">Dijemput</option>
            <option value="selesai">Selesai</option>
            <option value="dibatalkan">Dibatalkan</option>
        </select>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
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
                    <tr>
                        <td class="px-4 py-4 align-top">
                            <div class="font-semibold text-slate-900">{{ $item->user?->name }}</div>
                            <div class="mt-1 max-w-xs text-slate-500">{{ $item->alamat }}</div>
                        </td>
                        <td class="px-4 py-4 align-top text-slate-700">
                            {{ $item->jadwal_tanggal?->format('d M Y') }}<br>
                            <span class="text-slate-500">{{ \Illuminate\Support\Str::limit($item->jadwal_jam, 5, '') }}</span>
                        </td>
                        <td class="px-4 py-4 align-top text-slate-700">{{ $item->estimasi_kg }} kg</td>
                        <td class="px-4 py-4 align-top">
                            <x-status-badge :status="$item->status" />
                        </td>
                        <td class="px-4 py-4 align-top">
                            <form method="POST" action="{{ route('admin.pemanggilan.update', $item) }}" class="grid min-w-[520px] grid-cols-[1fr_1fr_110px_auto] gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="petugas_id" class="rounded-lg border border-slate-300 px-3 py-2">
                                    <option value="">Belum ditugaskan</option>
                                    @foreach ($petugas as $petugasUser)
                                        <option value="{{ $petugasUser->id }}" @selected($item->petugas_id === $petugasUser->id)>{{ $petugasUser->name }}</option>
                                    @endforeach
                                </select>
                                <select name="status" class="rounded-lg border border-slate-300 px-3 py-2">
                                    @foreach (['menunggu', 'dikonfirmasi', 'dijemput', 'selesai', 'dibatalkan'] as $status)
                                        <option value="{{ $status }}" @selected($item->status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <input type="number" min="0" name="poin_diberikan" value="{{ $item->poin_diberikan }}" class="rounded-lg border border-slate-300 px-3 py-2" aria-label="Poin diberikan">
                                <button type="submit" class="rounded-lg bg-green-600 px-4 py-2 font-semibold text-white hover:bg-green-700">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada pemanggilan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $pemanggilan->links() }}
</div>
