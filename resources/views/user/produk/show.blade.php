@extends('layouts.app')

@section('content')
    <div class="grid gap-8 lg:grid-cols-[1fr_0.9fr]">
        <img src="{{ cloudinaryUrl($produk->gambar) }}" alt="{{ $produk->nama }}" class="h-full min-h-[420px] w-full rounded-lg object-cover">
        <section class="rounded-lg border border-slate-200 bg-white p-6">
            <div class="text-sm font-bold uppercase tracking-[0.2em] text-green-700">{{ $produk->kategori }}</div>
            <h1 class="mt-3 text-3xl font-black text-slate-900">{{ $produk->nama }}</h1>
            <p class="mt-4 leading-7 text-slate-600">{{ $produk->deskripsi }}</p>
            <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="rounded-lg bg-green-50 p-4">
                    <div class="text-sm font-semibold text-green-700">Harga</div>
                    <div class="mt-1 text-2xl font-black text-green-900">Rp{{ number_format($produk->harga, 0, ',', '.') }}</div>
                </div>
                <div class="rounded-lg bg-slate-100 p-4">
                    <div class="text-sm font-semibold text-slate-600">Stok</div>
                    <div class="mt-1 text-2xl font-black text-slate-900">{{ $produk->stok }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('keranjang.add', $produk) }}" class="mt-6 flex flex-col gap-3 sm:flex-row">
                @csrf
                <input type="number" name="jumlah" min="1" max="{{ max($produk->stok, 1) }}" value="1" class="w-full rounded-lg border border-slate-300 px-3 py-3 sm:w-32">
                <button class="rounded-lg bg-green-600 px-6 py-3 font-bold text-white hover:bg-green-700" @disabled($produk->stok <= 0)>Tambah ke Keranjang</button>
            </form>
        </section>
    </div>
@endsection
