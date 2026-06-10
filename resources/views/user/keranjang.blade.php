@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
        <section class="rounded-lg border border-slate-200 bg-white p-6">
            <h1 class="text-3xl font-black text-slate-900">Keranjang</h1>
            <div class="mt-6 divide-y divide-slate-100">
                @forelse ($items as $item)
                    <div class="grid gap-4 py-5 sm:grid-cols-[96px_1fr_auto] sm:items-center">
                        <img src="{{ cloudinaryUrl($item->produk?->gambar) }}" alt="{{ $item->produk?->nama }}" class="h-24 w-24 rounded-lg object-cover">
                        <div>
                            <h2 class="font-bold text-slate-900">{{ $item->produk?->nama }}</h2>
                            <p class="mt-1 text-sm text-slate-500">Rp{{ number_format($item->produk?->harga ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('keranjang.update', $item) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="jumlah" min="0" max="{{ $item->produk?->stok ?? 99 }}" value="{{ $item->jumlah }}" class="w-20 rounded-lg border border-slate-300 px-3 py-2">
                                <button class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Update</button>
                            </form>
                            <form method="POST" action="{{ route('keranjang.remove', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-lg border border-red-200 px-3 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-500">Keranjang masih kosong.</div>
                @endforelse
            </div>
        </section>
        <aside class="h-fit rounded-lg border border-slate-200 bg-white p-6">
            <h2 class="text-lg font-bold text-slate-900">Ringkasan</h2>
            <div class="mt-5 flex justify-between text-sm text-slate-600">
                <span>Subtotal</span>
                <span class="font-bold text-slate-900">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout.page') }}" class="mt-6 block rounded-lg bg-green-600 px-5 py-3 text-center font-bold text-white hover:bg-green-700">Checkout</a>
        </aside>
    </div>
@endsection
