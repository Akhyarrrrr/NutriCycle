@csrf
@if(isset($produk))
    @method('PUT')
@endif

<div class="grid gap-6" x-data="{ imagePreview: @js(isset($produk) && $produk->gambar ? cloudinaryUrl($produk->gambar) : null) }">
    <div>
        <label for="nama" class="form-label">Nama Produk</label>
        <input id="nama" name="nama" value="{{ old('nama', $produk->nama ?? '') }}" required class="form-input mt-2 @error('nama') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Contoh: Pakan Maggot Premium">
        @error('nama') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="5" required class="form-input mt-2 @error('deskripsi') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Jelaskan manfaat, komposisi, dan cara pakai produk.">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        <div>
            <label for="harga" class="form-label">Harga</label>
            <input id="harga" type="number" min="0" name="harga" value="{{ old('harga', $produk->harga ?? '') }}" required class="form-input mt-2 @error('harga') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
            @error('harga') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="stok" class="form-label">Stok</label>
            <input id="stok" type="number" min="0" name="stok" value="{{ old('stok', $produk->stok ?? '') }}" required class="form-input mt-2 @error('stok') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
            @error('stok') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="kategori" class="form-label">Kategori</label>
            <input id="kategori" name="kategori" value="{{ old('kategori', $produk->kategori ?? '') }}" required class="form-input mt-2 @error('kategori') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Pakan / Kompos">
            @error('kategori') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="gambar" class="form-label">Gambar Produk</label>
        <label for="gambar" class="mt-2 grid cursor-pointer gap-4 rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 transition-all duration-200 hover:border-green-300 hover:bg-green-50 sm:grid-cols-[9rem_1fr] sm:items-center">
            <div class="aspect-square overflow-hidden rounded-lg bg-white shadow-sm">
                <template x-if="imagePreview">
                    <img :src="imagePreview" alt="Preview gambar produk" class="h-full w-full object-cover">
                </template>
                <div x-show="!imagePreview" class="flex h-full w-full items-center justify-center text-green-700">
                    <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3.75 16.5 8.25 12l3 3 4.5-5.25 4.5 6.75M5.25 19.5h13.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H5.25A1.5 1.5 0 0 0 3.75 6v12a1.5 1.5 0 0 0 1.5 1.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <div>
                <div class="text-sm font-black text-slate-900">Pilih gambar produk</div>
                <p class="mt-1 text-sm leading-6 text-slate-500">Format JPG, PNG, atau WEBP. Maksimal 4 MB.</p>
                <div class="mt-3 inline-flex rounded-lg bg-white px-3 py-2 text-xs font-bold text-green-700 shadow-sm">Browse file</div>
            </div>
        </label>
        <input id="gambar" type="file" name="gambar" accept="image/*" class="sr-only" x-on:change="
            const file = $event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = event => imagePreview = event.target.result;
            reader.readAsDataURL(file);
        ">
        @error('gambar') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center justify-between gap-4 rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
        <span>
            <span class="block text-sm font-bold text-slate-900">Produk aktif</span>
            <span class="mt-1 block text-sm text-slate-500">Produk aktif tampil di katalog warga.</span>
        </span>
        <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-green-600 focus:ring-green-600" @checked(old('is_active', $produk->is_active ?? true))>
    </label>

    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        <a href="{{ route('admin.produk.index') }}" class="btn-secondary w-full sm:w-auto">Batal</a>
        <button type="submit" class="btn-primary w-full sm:w-auto">{{ isset($produk) ? 'Simpan Perubahan' : 'Tambah Produk' }}</button>
    </div>
</div>
