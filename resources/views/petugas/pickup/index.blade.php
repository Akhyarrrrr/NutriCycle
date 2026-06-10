@extends('layouts.petugas')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-6">
        <h1 class="text-3xl font-black text-slate-900">Pickup Sampah</h1>
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-4 py-3">Warga</th><th class="px-4 py-3">Jadwal</th><th class="px-4 py-3">Estimasi</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Update</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pemanggilan as $item)
                        <tr>
                            <td class="px-4 py-4"><div class="font-bold text-slate-900">{{ $item->user?->name }}</div><div class="max-w-xs text-slate-500">{{ $item->alamat }}</div></td>
                            <td class="px-4 py-4">{{ $item->jadwal_tanggal?->format('d M Y') }}<br><span class="text-slate-500">{{ \Illuminate\Support\Str::limit($item->jadwal_jam, 5, '') }}</span></td>
                            <td class="px-4 py-4">{{ $item->estimasi_kg }} kg</td>
                            <td class="px-4 py-4"><x-status-badge :status="$item->status" /></td>
                            <td class="px-4 py-4">
                                <form method="POST" action="{{ route('petugas.pickup.update', $item) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="rounded-lg border border-slate-300 px-3 py-2">
                                        <option value="dijemput" @selected($item->status === 'dijemput')>Dijemput</option>
                                        <option value="selesai">Selesai</option>
                                        <option value="dibatalkan">Dibatalkan</option>
                                    </select>
                                    <button class="rounded-lg bg-green-600 px-4 py-2 font-bold text-white hover:bg-green-700">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-slate-500">Tidak ada pickup aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $pemanggilan->links() }}</div>
    </section>
@endsection
