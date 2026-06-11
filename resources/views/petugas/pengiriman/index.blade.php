@extends('layouts.petugas')

@section('content')
    <section class="space-y-5">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Pengiriman</p>
            <h1 class="mt-2 text-3xl font-black text-slate-900">Pengiriman Produk</h1>
            <p class="mt-2 text-sm text-slate-500">Kartu pengiriman produk yang sedang ditugaskan ke akun Anda.</p>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            @forelse ($transaksi as $item)
                <article class="card p-5" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <div class="text-sm font-semibold text-slate-500">Kode Transaksi</div>
                            <h2 class="mt-1 text-xl font-black text-slate-900">{{ $item->kode_transaksi }}</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $item->user?->name }}</p>
                        </div>
                        <x-status-badge :status="$item->status_pengiriman" />
                    </div>

                    <div class="mt-5 rounded-lg border border-slate-200 p-4 text-sm leading-6 text-slate-600">{{ $item->alamat_kirim }}</div>

                    <form method="POST" action="{{ route('petugas.pengiriman.update', $item) }}" class="mt-5 flex flex-col gap-3 sm:flex-row">
                        @csrf
                        @method('PATCH')
                        <select name="status_pengiriman" class="form-input">
                            <option value="dikonfirmasi" @selected($item->status_pengiriman === 'dikonfirmasi')>Dikonfirmasi</option>
                            <option value="dikirim" @selected($item->status_pengiriman === 'dikirim')>Dikirim</option>
                            <option value="selesai">Selesai</option>
                        </select>
                        <button type="submit" class="btn-primary w-full sm:w-auto">Update Status</button>
                    </form>
                </article>
            @empty
                <div class="card border-dashed p-10 text-center lg:col-span-2" data-aos="fade-up">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-lg bg-green-50 text-green-700">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3.75 7.5h10.5v9H3.75v-9Zm10.5 3h3l3 3v3h-6v-6Zm-7.5 8.25h.01m10.5 0h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h2 class="mt-4 text-lg font-black text-slate-900">Tidak ada pengiriman aktif</h2>
                    <p class="mt-2 text-sm text-slate-500">Order baru akan muncul setelah admin menugaskan Anda.</p>
                </div>
            @endforelse
        </div>

        <div>{{ $transaksi->links() }}</div>
    </section>
@endsection
