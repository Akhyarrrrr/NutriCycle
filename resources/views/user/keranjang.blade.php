@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
        <section class="card p-5 sm:p-6" data-aos="fade-up">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Keranjang</p>
                    <h1 class="mt-2 text-3xl font-black text-slate-900">Produk Pilihan</h1>
                </div>
                <a href="{{ route('produk.index') }}" class="btn-secondary">Tambah Produk</a>
            </div>

            @if ($items->isNotEmpty())
                <div class="mt-6 table-shell">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-black uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Produk</th>
                                <th class="px-4 py-3">Harga</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Subtotal</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($items as $item)
                                <tr class="odd:bg-white even:bg-slate-50" data-aos="fade-up">
                                    <td class="px-4 py-4">
                                        <div class="flex min-w-64 items-center gap-3">
                                            <img src="{{ cloudinaryUrl($item->produk?->gambar) }}" alt="{{ $item->produk?->nama }}" class="h-16 w-16 rounded-xl object-cover shadow-sm">
                                            <div>
                                                <div class="font-black text-slate-900">{{ $item->produk?->nama }}</div>
                                                <div class="mt-1 text-xs text-slate-500">{{ $item->produk?->kategori }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 font-semibold text-slate-700">Rp{{ number_format($item->produk?->harga ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4">
                                        <form method="POST" action="{{ route('keranjang.update', $item) }}" class="flex items-center gap-2" x-data="{ qty: {{ $item->jumlah }} }">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex rounded-lg border border-slate-300 bg-white shadow-sm">
                                                <button type="button" x-on:click="qty = Math.max(0, qty - 1)" class="px-3 text-lg font-black text-slate-600 hover:bg-slate-50">-</button>
                                                <input type="number" name="jumlah" min="0" max="{{ $item->produk?->stok ?? 99 }}" x-model.number="qty" class="w-16 border-0 text-center text-sm font-bold focus:ring-0">
                                                <button type="button" x-on:click="qty = Math.min({{ $item->produk?->stok ?? 99 }}, qty + 1)" class="px-3 text-lg font-black text-slate-600 hover:bg-slate-50">+</button>
                                            </div>
                                            <button class="icon-button" aria-label="Update jumlah" title="Update">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4.5 12a7.5 7.5 0 0 1 13.18-4.9M19.5 4.5v5h-5M19.5 12a7.5 7.5 0 0 1-13.18 4.9M4.5 19.5v-5h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4 font-black text-green-700">Rp{{ number_format(($item->produk?->harga ?? 0) * $item->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-right">
                                        <form method="POST" action="{{ route('keranjang.remove', $item) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="icon-button text-red-600 hover:border-red-200 hover:bg-red-50 hover:text-red-700" aria-label="Hapus item" title="Hapus">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 7h12m-9 0V5.25A1.25 1.25 0 0 1 10.25 4h3.5A1.25 1.25 0 0 1 15 5.25V7m2 0-.75 12A2 2 0 0 1 14.25 21h-4.5a2 2 0 0 1-2-1.88L7 7m3 3.75v6.5m4-6.5v6.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mt-8 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-green-100 text-green-700">
                        <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6.5 7h14l-1.8 8.2a2 2 0 0 1-2 1.6H9.1a2 2 0 0 1-2-1.7L5.8 5.8A2 2 0 0 0 3.8 4H3M9 20.5h.01M17 20.5h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h2 class="mt-5 text-xl font-black text-slate-900">Keranjang masih kosong</h2>
                    <p class="mt-2 text-sm text-slate-500">Pilih produk pakan daur ulang untuk memulai checkout.</p>
                    <a href="{{ route('produk.index') }}" class="btn-primary mt-6">Lihat Produk</a>
                </div>
            @endif
        </section>

        <aside class="card h-fit p-6 lg:sticky lg:top-24" data-aos="fade-up" data-aos-delay="120">
            <h2 class="text-lg font-black text-slate-900">Ringkasan Pesanan</h2>
            <div class="mt-5 space-y-3 text-sm">
                <div class="flex justify-between text-slate-600">
                    <span>Jumlah item</span>
                    <span class="font-bold text-slate-900">{{ number_format($items->sum('jumlah')) }}</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal</span>
                    <span class="font-black text-green-700">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            <a href="{{ route('checkout.page') }}" class="btn-primary mt-6 w-full {{ $items->isEmpty() ? 'pointer-events-none opacity-60' : '' }}">
                Checkout
            </a>
        </aside>
    </div>
@endsection
