@extends('layouts.app')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-3xl font-black text-slate-900">Pemanggilan</h1>
            <a href="{{ route('pemanggilan.create') }}" class="rounded-lg bg-green-600 px-4 py-2 text-center text-sm font-bold text-white hover:bg-green-700">Buat Pemanggilan</a>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-4 py-3">Jadwal</th><th class="px-4 py-3">Alamat</th><th class="px-4 py-3">Estimasi</th><th class="px-4 py-3">Poin</th><th class="px-4 py-3">Status</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pemanggilan as $item)
                        <tr>
                            <td class="px-4 py-4">{{ $item->jadwal_tanggal?->format('d M Y') }}<br><span class="text-slate-500">{{ \Illuminate\Support\Str::limit($item->jadwal_jam, 5, '') }}</span></td>
                            <td class="px-4 py-4 max-w-sm">{{ $item->alamat }}</td>
                            <td class="px-4 py-4">{{ $item->estimasi_kg }} kg</td>
                            <td class="px-4 py-4">{{ $item->poin_diberikan }}</td>
                            <td class="px-4 py-4"><x-status-badge :status="$item->status" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada pemanggilan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $pemanggilan->links() }}</div>
    </section>
@endsection
