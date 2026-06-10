@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-green-700">Produk</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900">Pakan Daur Ulang</h1>
            </div>
            <form method="GET" action="{{ route('produk.index') }}" class="flex gap-2">
                <select name="kategori" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                    <option value="">Semua kategori</option>
                    @foreach ($kategoriList as $item)
                        <option value="{{ $item }}" @selected($kategori === $item)>{{ $item }}</option>
                    @endforeach
                </select>
                <button class="rounded-lg bg-green-600 px-4 py-2 text-sm font-bold text-white hover:bg-green-700">Filter</button>
            </form>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($produk as $item)
                <article class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                    <a href="{{ route('produk.show', $item->slug) }}">
                        <img src="{{ cloudinaryUrl($item->gambar) }}" alt="{{ $item->nama }}" class="h-56 w-full object-cover">
                    </a>
                    <div class="p-5">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-xs font-bold uppercase tracking-wide text-green-700">{{ $item->kategori }}</span>
                            <span class="text-xs font-semibold text-slate-500">Stok {{ $item->stok }}</span>
                        </div>
                        <h2 class="mt-2 text-lg font-bold text-slate-900"><a href="{{ route('produk.show', $item->slug) }}">{{ $item->nama }}</a></h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">{{ \Illuminate\Support\Str::limit($item->deskripsi, 96) }}</p>
                        <div class="mt-4 flex items-center justify-between gap-3">
                            <div class="font-black text-green-700">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
                            <form method="POST" action="{{ route('keranjang.add', $item) }}">
                                @csrf
                                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-bold text-white hover:bg-green-700" @disabled($item->stok <= 0)>Tambah</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-slate-500 sm:col-span-2 lg:col-span-3">Produk belum tersedia.</div>
            @endforelse
        </div>

        {{ $produk->links() }}
    </div>
@endsection
