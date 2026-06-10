@csrf
@if(isset($produk))
    @method('PUT')
@endif

<div class="grid gap-5">
    <div>
        <label for="nama" class="text-sm font-semibold text-slate-700">Nama Produk</label>
        <input id="nama" name="nama" value="{{ old('nama', $produk->nama ?? '') }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">
        @error('nama') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="deskripsi" class="text-sm font-semibold text-slate-700">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="5" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div class="grid gap-5 md:grid-cols-3">
        <div>
            <label for="harga" class="text-sm font-semibold text-slate-700">Harga</label>
            <input id="harga" type="number" min="0" name="harga" value="{{ old('harga', $produk->harga ?? '') }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>
        <div>
            <label for="stok" class="text-sm font-semibold text-slate-700">Stok</label>
            <input id="stok" type="number" min="0" name="stok" value="{{ old('stok', $produk->stok ?? '') }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>
        <div>
            <label for="kategori" class="text-sm font-semibold text-slate-700">Kategori</label>
            <input id="kategori" name="kategori" value="{{ old('kategori', $produk->kategori ?? '') }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>
    </div>
    <div>
        <label for="gambar" class="text-sm font-semibold text-slate-700">Gambar</label>
        <input id="gambar" type="file" name="gambar" accept="image/*" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">
        @if(isset($produk) && $produk->gambar)
            <img src="{{ cloudinaryUrl($produk->gambar) }}" alt="{{ $produk->nama }}" class="mt-3 h-32 w-32 rounded-lg object-cover">
        @endif
    </div>
    <label class="flex items-center gap-3">
        <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-green-600 focus:ring-green-600" @checked(old('is_active', $produk->is_active ?? true))>
        <span class="text-sm font-semibold text-slate-700">Produk aktif</span>
    </label>
    <div class="flex gap-3">
        <button class="rounded-lg bg-green-600 px-5 py-3 font-bold text-white hover:bg-green-700">{{ isset($produk) ? 'Simpan Perubahan' : 'Tambah Produk' }}</button>
        <a href="{{ route('admin.produk.index') }}" class="rounded-lg border border-slate-300 px-5 py-3 font-bold text-slate-700 hover:bg-slate-50">Batal</a>
    </div>
</div>
