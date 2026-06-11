@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1fr_390px]">
        <form method="POST" action="{{ route('checkout.process') }}" class="card p-5 sm:p-6" data-aos="fade-up" x-data="{ usePoin: {{ old('use_poin') ? 'true' : 'false' }} }">
            @csrf
            <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Checkout</p>
            <h1 class="mt-2 text-3xl font-black text-slate-900">Alamat & Pembayaran</h1>

            <div class="mt-6">
                <label for="alamat_kirim" class="form-label">Alamat Kirim</label>
                <textarea id="alamat_kirim" name="alamat_kirim" rows="4" required class="form-input mt-2 @error('alamat_kirim') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('alamat_kirim', auth()->user()->alamat) }}</textarea>
                @error('alamat_kirim') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="mt-5">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea id="catatan" name="catatan" rows="3" class="form-input mt-2">{{ old('catatan') }}</textarea>
            </div>

            <label class="mt-5 flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-green-200 bg-green-50 p-4 shadow-sm">
                <span>
                    <span class="block font-black text-green-950">Gunakan poin</span>
                    <span class="mt-1 block text-sm text-green-800/80">Potensi diskon Rp{{ number_format($potensiDiskon, 0, ',', '.') }} dari {{ number_format(auth()->user()->poin) }} poin.</span>
                    <span x-show="usePoin" x-transition class="mt-2 block text-sm font-bold text-green-700">Diskon aktif: Rp{{ number_format($potensiDiskon, 0, ',', '.') }}</span>
                </span>
                <span class="relative inline-flex h-7 w-12 shrink-0 items-center rounded-full transition-all duration-200" :class="usePoin ? 'bg-green-600' : 'bg-slate-300'">
                    <input type="checkbox" name="use_poin" value="1" class="sr-only" x-model="usePoin">
                    <span class="inline-block h-5 w-5 rounded-full bg-white shadow transition-all duration-200" :class="usePoin ? 'translate-x-6' : 'translate-x-1'"></span>
                </span>
            </label>

            <button class="btn-primary mt-6 w-full sm:w-auto">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7.5 10.5V8.25a4.5 4.5 0 0 1 9 0v2.25m-11.25 0h13.5v9.75H5.25V10.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Buat Transaksi
            </button>
        </form>

        <aside class="card h-fit p-6 lg:sticky lg:top-24" data-aos="fade-up" data-aos-delay="120">
            <h2 class="text-lg font-black text-slate-900">Ringkasan Order</h2>
            <div class="mt-4 space-y-4">
                @foreach ($items as $item)
                    <div class="flex justify-between gap-3 text-sm">
                        <div>
                            <div class="font-bold text-slate-900">{{ $item->produk?->nama }}</div>
                            <div class="text-slate-500">{{ $item->jumlah }} x Rp{{ number_format($item->produk?->harga ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <div class="font-black text-slate-900">Rp{{ number_format(($item->produk?->harga ?? 0) * $item->jumlah, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 space-y-3 border-t border-slate-200 pt-5 text-sm">
                <div class="flex justify-between text-slate-600"><span>Subtotal</span><span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span></div>
                <div class="flex justify-between text-slate-600"><span>Maks diskon poin</span><span>Rp{{ number_format($maxDiskon, 0, ',', '.') }}</span></div>
                <div class="flex justify-between rounded-xl bg-green-50 p-3 font-black text-green-900"><span>Estimasi total</span><span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span></div>
            </div>
        </aside>
    </div>
@endsection
