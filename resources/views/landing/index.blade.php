@extends('layouts.guest')

@section('content')
    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-30">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
                <a href="{{ route('landing') }}" class="text-white drop-shadow"><x-application-logo class="text-white" /></a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('pelayanan') }}" class="hidden text-sm font-semibold text-white/90 hover:text-white sm:inline">Pelayanan</a>
                    @auth
                        <a href="{{ auth()->user()->role === 2 ? route('admin.dashboard') : (auth()->user()->role === 1 ? route('petugas.dashboard') : route('dashboard')) }}" class="rounded-lg bg-white px-4 py-2 text-sm font-bold text-green-700 hover:bg-green-50">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg bg-white/15 px-4 py-2 text-sm font-bold text-white ring-1 ring-white/30 hover:bg-white/25">Masuk</a>
                        <a href="{{ route('register') }}" class="rounded-lg bg-white px-4 py-2 text-sm font-bold text-green-700 hover:bg-green-50">Daftar</a>
                    @endauth
                </div>
            </nav>
        </header>

        <section class="relative min-h-[640px] overflow-hidden bg-slate-950">
            <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1800&q=80" alt="Bahan organik segar untuk didaur ulang menjadi pakan" class="absolute inset-0 h-full w-full object-cover opacity-45">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/70 to-slate-900/20"></div>
            <div class="relative mx-auto flex min-h-[640px] max-w-7xl items-center px-4 pb-16 pt-28 sm:px-6 lg:px-8">
                <div class="max-w-3xl text-white">
                    <p class="mb-4 text-sm font-bold uppercase tracking-[0.24em] text-green-200">NutriCycle</p>
                    <h1 class="text-4xl font-black leading-tight tracking-normal sm:text-6xl">Ubah Sampah Beranak Jadi Pakan Ternak</h1>
                    <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-100">Jadwalkan pickup sampah organik, kumpulkan poin, dan beli produk pakan ternak hasil daur ulang yang lebih hemat dan bertanggung jawab.</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('produk.index') }}" class="rounded-lg bg-green-600 px-6 py-3 text-center text-sm font-bold text-white hover:bg-green-700">Beli Produk</a>
                        <a href="{{ route('pemanggilan.create') }}" class="rounded-lg bg-white px-6 py-3 text-center text-sm font-bold text-green-700 hover:bg-green-50">Panggil Petugas</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-white py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-black text-slate-900">Cara Kerja</h2>
                    <p class="mt-3 text-slate-600">Alurnya sederhana agar rumah tangga bisa ikut sirkular ekonomi tanpa proses yang rumit.</p>
                </div>
                <div class="mt-10 grid gap-5 md:grid-cols-3">
                    @foreach ([['Kumpulkan Sampah', 'Pisahkan sisa organik harian yang masih bisa diolah.'], ['Hubungi Petugas', 'Pilih jadwal pickup dan petugas akan menjemput ke alamat Anda.'], ['Dapatkan Poin', 'Sampah selesai diproses, poin masuk dan bisa dipakai untuk diskon.']] as $index => $step)
                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-6">
                            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-lg bg-green-600 text-lg font-black text-white">{{ $index + 1 }}</div>
                            <h3 class="text-lg font-bold text-slate-900">{{ $step[0] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $step[1] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-slate-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-3xl font-black text-slate-900">Produk Unggulan</h2>
                        <p class="mt-3 text-slate-600">Pakan hasil olahan yang siap membantu peternak kecil dan pembudidaya.</p>
                    </div>
                    <a href="{{ route('produk.index') }}" class="text-sm font-bold text-green-700 hover:text-green-800">Lihat semua produk</a>
                </div>
                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($produk as $item)
                        <article class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                            <img src="{{ cloudinaryUrl($item->gambar) }}" alt="{{ $item->nama }}" class="h-56 w-full object-cover">
                            <div class="p-5">
                                <div class="text-xs font-bold uppercase tracking-wide text-green-700">{{ $item->kategori }}</div>
                                <h3 class="mt-2 text-lg font-bold text-slate-900">{{ $item->nama }}</h3>
                                <p class="mt-2 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($item->deskripsi, 92) }}</p>
                                <div class="mt-4 font-black text-green-700">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-slate-500 sm:col-span-2 lg:col-span-3">Produk belum tersedia.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="bg-white py-16">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
                <div>
                    <h2 class="text-3xl font-black text-slate-900">Tentang Kami</h2>
                    <p class="mt-4 text-lg leading-8 text-slate-600">NutriCycle membantu rumah tangga mengubah sampah organik menjadi nilai baru. Kami menghubungkan warga, petugas lapangan, dan pembeli pakan agar limbah harian bisa kembali ke rantai produksi yang bermanfaat.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-lg bg-green-50 p-5"><div class="text-3xl font-black text-green-700">3</div><div class="mt-1 text-sm font-semibold text-slate-600">Peran aktif</div></div>
                    <div class="rounded-lg bg-slate-100 p-5"><div class="text-3xl font-black text-slate-900">30%</div><div class="mt-1 text-sm font-semibold text-slate-600">Maks diskon poin</div></div>
                    <div class="rounded-lg bg-emerald-50 p-5"><div class="text-3xl font-black text-green-700">1:10</div><div class="mt-1 text-sm font-semibold text-slate-600">Poin ke rupiah</div></div>
                </div>
            </div>
        </section>

        <footer class="border-t border-slate-200 bg-slate-950 py-10 text-white">
            <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <div>
                    <div class="text-xl font-black">NutriCycle</div>
                    <div class="mt-1 text-sm text-slate-300">Ubah Sampah Beranak Jadi Pakan Ternak</div>
                </div>
                <div class="flex gap-5 text-sm text-slate-300">
                    <a href="{{ route('landing') }}" class="hover:text-white">Beranda</a>
                    <a href="{{ route('pelayanan') }}" class="hover:text-white">Pelayanan</a>
                    <a href="{{ route('produk.index') }}" class="hover:text-white">Produk</a>
                </div>
                <div class="text-sm text-slate-400">© {{ date('Y') }} NutriCycle</div>
            </div>
        </footer>
    </div>
@endsection
