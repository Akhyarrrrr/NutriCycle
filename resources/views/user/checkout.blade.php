@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1fr_380px]">
        <form method="POST" action="{{ route('checkout.process') }}" class="rounded-lg border border-slate-200 bg-white p-6">
            @csrf
            <h1 class="text-3xl font-black text-slate-900">Checkout</h1>
            <div class="mt-6">
                <label for="alamat_kirim" class="text-sm font-semibold text-slate-700">Alamat Kirim</label>
                <textarea id="alamat_kirim" name="alamat_kirim" rows="4" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('alamat_kirim', auth()->user()->alamat) }}</textarea>
                @error('alamat_kirim') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="mt-5">
                <label for="catatan" class="text-sm font-semibold text-slate-700">Catatan</label>
                <textarea id="catatan" name="catatan" rows="3" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('catatan') }}</textarea>
            </div>
            <label class="mt-5 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-4">
                <input type="checkbox" name="use_poin" value="1" class="mt-1 rounded border-slate-300 text-green-600 focus:ring-green-600" @checked(old('use_poin'))>
                <span>
                    <span class="block font-bold text-green-900">Gunakan poin</span>
                    <span class="mt-1 block text-sm text-green-800/80">Potensi diskon Rp{{ number_format($potensiDiskon, 0, ',', '.') }} dari {{ number_format(auth()->user()->poin) }} poin.</span>
                </span>
            </label>
            <button class="mt-6 rounded-lg bg-green-600 px-6 py-3 font-bold text-white hover:bg-green-700">Buat Transaksi</button>
        </form>
        <aside class="h-fit rounded-lg border border-slate-200 bg-white p-6">
            <h2 class="text-lg font-bold text-slate-900">Pesanan</h2>
            <div class="mt-4 space-y-4">
                @foreach ($items as $item)
                    <div class="flex justify-between gap-3 text-sm">
                        <div>
                            <div class="font-semibold text-slate-900">{{ $item->produk?->nama }}</div>
                            <div class="text-slate-500">{{ $item->jumlah }} x Rp{{ number_format($item->produk?->harga ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <div class="font-bold text-slate-900">Rp{{ number_format(($item->produk?->harga ?? 0) * $item->jumlah, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 border-t border-slate-200 pt-5">
                <div class="flex justify-between text-sm text-slate-600"><span>Subtotal</span><span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span></div>
                <div class="mt-2 flex justify-between text-sm text-slate-600"><span>Maks diskon poin</span><span>Rp{{ number_format($maxDiskon, 0, ',', '.') }}</span></div>
            </div>
        </aside>
    </div>
@endsection
