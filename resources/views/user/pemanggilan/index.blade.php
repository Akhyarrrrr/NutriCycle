@extends('layouts.app')

@section('content')
    <section class="card p-5 sm:p-6" data-aos="fade-up">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Pemanggilan</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900">Riwayat Pickup</h1>
            </div>
            <a href="{{ route('pemanggilan.create') }}" class="btn-primary">Buat Pemanggilan</a>
        </div>
        <div class="mt-6 table-shell">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-black uppercase tracking-wide text-slate-500">
                    <tr><th class="px-4 py-3">Jadwal</th><th class="px-4 py-3">Alamat</th><th class="px-4 py-3">Estimasi</th><th class="px-4 py-3">Poin</th><th class="px-4 py-3">Status</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pemanggilan as $item)
                        <tr class="odd:bg-white even:bg-slate-50" data-aos="fade-up">
                            <td class="px-4 py-4 font-bold text-slate-900">{{ $item->jadwal_tanggal?->format('d M Y') }}<br><span class="font-medium text-slate-500">{{ \Illuminate\Support\Str::limit($item->jadwal_jam, 5, '') }}</span></td>
                            <td class="max-w-sm px-4 py-4 text-slate-600">{{ $item->alamat }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-700">{{ $item->estimasi_kg }} kg</td>
                            <td class="px-4 py-4 font-semibold text-green-700">{{ $item->poin_diberikan }}</td>
                            <td class="px-4 py-4"><x-status-badge :status="$item->status" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-12 text-center text-slate-500">Belum ada pemanggilan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $pemanggilan->links() }}</div>
    </section>
@endsection
