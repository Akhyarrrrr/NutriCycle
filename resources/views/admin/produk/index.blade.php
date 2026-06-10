@extends('layouts.admin')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-3xl font-black text-slate-900">Produk</h1>
            <a href="{{ route('admin.produk.create') }}" class="rounded-lg bg-green-600 px-4 py-2 text-center text-sm font-bold text-white hover:bg-green-700">Tambah Produk</a>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-4 py-3">Produk</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Harga</th><th class="px-4 py-3">Stok</th><th class="px-4 py-3">Status</th><th class="px-4 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($produk as $item)
                        <tr>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ cloudinaryUrl($item->gambar) }}" alt="{{ $item->nama }}" class="h-14 w-14 rounded-lg object-cover">
                                    <div><div class="font-bold text-slate-900">{{ $item->nama }}</div><div class="text-xs text-slate-500">{{ $item->slug }}</div></div>
                                </div>
                            </td>
                            <td class="px-4 py-4">{{ $item->kategori }}</td>
                            <td class="px-4 py-4">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">{{ $item->stok }}</td>
                            <td class="px-4 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-700' }}">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.produk.edit', $item) }}" class="rounded-lg border border-slate-300 px-3 py-2 font-bold text-slate-700 hover:bg-slate-50">Edit</a>
                                    <form method="POST" action="{{ route('admin.produk.destroy', $item) }}" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-200 px-3 py-2 font-bold text-red-700 hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-10 text-center text-slate-500">Belum ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $produk->links() }}</div>
    </section>
@endsection
