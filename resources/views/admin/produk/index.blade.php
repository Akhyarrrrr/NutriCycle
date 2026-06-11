@extends('layouts.admin')

@section('content')
    <section class="space-y-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Katalog</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900">Produk</h1>
                <p class="mt-2 text-sm text-slate-500">Kelola stok, harga, gambar, dan status produk pakan.</p>
            </div>
            <a href="{{ route('admin.produk.create') }}" class="btn-primary w-full sm:w-auto">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 5v14m7-7H5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Tambah Produk
            </a>
        </div>

        <div class="card p-4" data-aos="fade-up">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 text-green-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20.25 7.5 12 3 3.75 7.5m16.5 0L12 12m8.25-4.5v9L12 21m0-9L3.75 7.5m8.25 4.5v9m0-9L3.75 16.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <div>
                        <div class="font-bold text-slate-900">{{ $produk->total() }} produk</div>
                        <div>Urutan terbaru ditampilkan lebih dulu.</div>
                    </div>
                </div>
                <div class="rounded-lg bg-slate-50 px-3 py-2 text-xs font-bold uppercase tracking-wide text-slate-500">Page {{ $produk->currentPage() }} / {{ $produk->lastPage() }}</div>
            </div>
        </div>

        <div class="table-shell" data-aos="fade-up">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-900 text-left text-xs font-semibold uppercase tracking-wide text-white">
                    <tr>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3">Stok</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($produk as $item)
                        @php
                            $stockClass = $item->stok <= 0 ? 'bg-red-100 text-red-700 ring-red-200' : ($item->stok <= 10 ? 'bg-yellow-100 text-yellow-800 ring-yellow-200' : 'bg-green-100 text-green-700 ring-green-200');
                        @endphp
                        <tr class="{{ $loop->odd ? 'bg-white' : 'bg-slate-50/70' }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 40 }}">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ cloudinaryUrl($item->gambar) }}" alt="{{ $item->nama }}" class="h-14 w-14 rounded-lg object-cover shadow-sm">
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $item->nama }}</div>
                                        <div class="text-xs text-slate-500">{{ $item->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 font-medium text-slate-700">{{ $item->kategori }}</td>
                            <td class="px-4 py-4 font-black text-green-700">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $stockClass }}">Stok {{ $item->stok }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $item->is_active ? 'bg-green-100 text-green-800 ring-green-200' : 'bg-slate-100 text-slate-700 ring-slate-200' }}">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.produk.edit', $item) }}" class="icon-button" title="Edit produk {{ $item->nama }}" aria-label="Edit produk {{ $item->nama }}">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m16.86 4.49 2.65 2.65M7.5 16.5l-3 3 .75-3.75L15.8 5.2a1.87 1.87 0 0 1 2.65 2.65L7.5 16.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.produk.destroy', $item) }}" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-button border-red-200 text-red-600 hover:border-red-200 hover:bg-red-50 hover:text-red-700" title="Hapus produk {{ $item->nama }}" aria-label="Hapus produk {{ $item->nama }}">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 7.5h12m-10.5 0 .75 12h7.5l.75-12M9.75 7.5V5.25h4.5V7.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-lg bg-green-50 text-green-700">
                                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20.25 7.5 12 3 3.75 7.5m16.5 0L12 12m8.25-4.5v9L12 21m0-9L3.75 7.5m8.25 4.5v9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div class="mt-4 font-bold text-slate-900">Belum ada produk</div>
                                <div class="mt-1 text-sm text-slate-500">Tambahkan produk pertama untuk mulai berjualan.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $produk->links() }}</div>
    </section>
@endsection
