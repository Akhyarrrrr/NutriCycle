@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between" data-aos="fade-up">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Produk</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900 sm:text-4xl">Pakan Daur Ulang</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Pilih produk hasil olahan sampah organik untuk kebutuhan ternak dan budidaya.</p>
            </div>
            <form method="GET" action="{{ route('produk.index') }}" class="card flex flex-col gap-2 p-3 sm:flex-row sm:items-center">
                <select name="kategori" class="form-input min-w-48">
                    <option value="">Semua kategori</option>
                    @foreach ($kategoriList as $item)
                        <option value="{{ $item }}" @selected($kategori === $item)>{{ $item }}</option>
                    @endforeach
                </select>
                <button class="btn-primary py-2.5">Filter</button>
            </form>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($produk as $item)
                @php
                    $stockClass = $item->stok <= 0 ? 'bg-red-100 text-red-700' : ($item->stok <= 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-700');
                @endphp
                <article class="card card-hover group overflow-hidden" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 80 }}">
                    <div class="relative overflow-hidden">
                        <a href="{{ route('produk.show', $item->slug) }}">
                            <img src="{{ cloudinaryUrl($item->gambar) }}" alt="{{ $item->nama }}" class="aspect-square w-full rounded-t-xl object-cover transition-all duration-300 group-hover:scale-105">
                        </a>
                        <span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-black text-green-700 shadow-sm backdrop-blur">{{ $item->kategori }}</span>
                        <span class="absolute right-3 top-3 rounded-full px-3 py-1 text-xs font-black shadow-sm {{ $stockClass }}">Stok {{ $item->stok }}</span>
                        <a href="{{ route('produk.show', $item->slug) }}" class="absolute inset-x-4 bottom-4 translate-y-4 rounded-lg bg-green-600 px-4 py-2 text-center text-sm font-bold text-white opacity-0 shadow-md transition-all duration-200 group-hover:translate-y-0 group-hover:opacity-100">Lihat Detail</a>
                    </div>
                    <div class="flex min-h-64 flex-col p-5">
                        <h2 class="text-lg font-black text-slate-900"><a href="{{ route('produk.show', $item->slug) }}">{{ $item->nama }}</a></h2>
                        <p class="mt-2 flex-1 text-sm leading-6 text-slate-500">{{ \Illuminate\Support\Str::limit($item->deskripsi, 108) }}</p>
                        <div class="mt-4 text-xl font-black text-green-700">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
                        <form method="POST" action="{{ route('keranjang.add', $item) }}" class="mt-4">
                            @csrf
                            <button class="btn-primary w-full" @disabled($item->stok <= 0)>
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6.5 7h14l-1.8 8.2a2 2 0 0 1-2 1.6H9.1a2 2 0 0 1-2-1.7L5.8 5.8A2 2 0 0 0 3.8 4H3M9 20.5h.01M17 20.5h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="card border-dashed p-10 text-center sm:col-span-2 lg:col-span-3">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-green-50 text-green-700">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20.25 7.5 12 2.25 3.75 7.5m16.5 0L12 12.75m8.25-5.25v9L12 21.75m0-9L3.75 7.5m8.25 5.25v9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h2 class="mt-4 text-lg font-black text-slate-900">Produk belum tersedia</h2>
                    <p class="mt-1 text-sm text-slate-500">Coba kategori lain atau kembali lagi nanti.</p>
                </div>
            @endforelse
        </div>

        {{ $produk->links() }}
    </div>
@endsection
