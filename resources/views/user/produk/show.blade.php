@extends('layouts.app')

@section('content')
    @php
        $stockClass = $produk->stok <= 0 ? 'bg-red-100 text-red-700' : ($produk->stok <= 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-700');
    @endphp

    <div class="grid gap-8 lg:grid-cols-[1fr_0.9fr]">
        <div class="card overflow-hidden" data-aos="fade-up">
            <img src="{{ cloudinaryUrl($produk->gambar) }}" alt="{{ $produk->nama }}" class="aspect-square w-full object-cover">
        </div>
        <section class="card p-6 lg:p-8" data-aos="fade-up" data-aos-delay="100">
            <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-black uppercase tracking-wide text-green-700">{{ $produk->kategori }}</span>
                <span class="rounded-full px-3 py-1 text-xs font-black {{ $stockClass }}">Stok {{ $produk->stok }}</span>
            </div>
            <h1 class="mt-4 text-3xl font-black text-slate-900 sm:text-4xl">{{ $produk->nama }}</h1>
            <p class="mt-4 leading-7 text-slate-600">{{ $produk->deskripsi }}</p>
            <div class="mt-6 rounded-xl bg-green-50 p-5">
                <div class="text-sm font-bold text-green-700">Harga</div>
                <div class="mt-1 text-3xl font-black text-green-900">Rp{{ number_format($produk->harga, 0, ',', '.') }}</div>
            </div>
            <form method="POST" action="{{ route('keranjang.add', $produk) }}" class="mt-6" x-data="{ qty: 1 }">
                @csrf
                <label for="jumlah" class="form-label">Jumlah</label>
                <div class="mt-2 flex flex-col gap-3 sm:flex-row">
                    <div class="flex rounded-lg border border-slate-300 bg-white shadow-sm">
                        <button type="button" x-on:click="qty = Math.max(1, qty - 1)" class="px-4 text-lg font-black text-slate-600 hover:bg-slate-50">-</button>
                        <input id="jumlah" type="number" name="jumlah" min="1" max="{{ max($produk->stok, 1) }}" x-model.number="qty" class="w-20 border-0 text-center font-bold focus:ring-0">
                        <button type="button" x-on:click="qty = Math.min({{ max($produk->stok, 1) }}, qty + 1)" class="px-4 text-lg font-black text-slate-600 hover:bg-slate-50">+</button>
                    </div>
                    <button class="btn-primary flex-1" @disabled($produk->stok <= 0)>
                        Tambah ke Keranjang
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
