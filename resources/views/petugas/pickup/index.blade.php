@extends('layouts.petugas')

@section('content')
    <section class="space-y-5">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Pickup</p>
            <h1 class="mt-2 text-3xl font-black text-slate-900">Pickup Sampah</h1>
            <p class="mt-2 text-sm text-slate-500">Kartu pekerjaan pickup yang sedang ditugaskan ke akun Anda.</p>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            @forelse ($pemanggilan as $item)
                <article class="card p-5" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <div class="text-sm font-semibold text-slate-500">Warga</div>
                            <h2 class="mt-1 text-xl font-black text-slate-900">{{ $item->user?->name }}</h2>
                        </div>
                        <x-status-badge :status="$item->status" />
                    </div>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase tracking-wide text-slate-500">Jadwal</div>
                            <div class="mt-2 font-bold text-slate-900">{{ $item->jadwal_tanggal?->format('d M Y') }}</div>
                            <div class="text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($item->jadwal_jam, 5, '') }}</div>
                        </div>
                        <div class="rounded-lg bg-green-50 p-4">
                            <div class="text-xs font-black uppercase tracking-wide text-green-700">Estimasi</div>
                            <div class="mt-2 text-2xl font-black text-green-700">{{ $item->estimasi_kg }} kg</div>
                        </div>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-200 p-4 text-sm leading-6 text-slate-600">{{ $item->alamat }}</div>

                    <form method="POST" action="{{ route('petugas.pickup.update', $item) }}" class="mt-5 flex flex-col gap-3 sm:flex-row">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-input">
                            <option value="dijemput" @selected($item->status === 'dijemput')>Dijemput</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                        <button type="submit" class="btn-primary w-full sm:w-auto">Update Status</button>
                    </form>
                </article>
            @empty
                <div class="card border-dashed p-10 text-center lg:col-span-2" data-aos="fade-up">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-lg bg-green-50 text-green-700">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M8.25 18.75a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm7.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM3.75 6h11.5l3 4.5h2v5.25H18M3.75 6v9.75h3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h2 class="mt-4 text-lg font-black text-slate-900">Tidak ada pickup aktif</h2>
                    <p class="mt-2 text-sm text-slate-500">Pekerjaan baru akan muncul setelah admin menugaskan Anda.</p>
                </div>
            @endforelse
        </div>

        <div>{{ $pemanggilan->links() }}</div>
    </section>
@endsection
