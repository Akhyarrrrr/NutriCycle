@extends('layouts.guest')

@section('content')
    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-30">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
                <a href="{{ route('landing') }}" class="text-white drop-shadow"><x-application-logo class="text-white" /></a>
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('pelayanan') }}" class="hidden rounded-lg px-3 py-2 text-sm font-bold text-white/90 hover:bg-white/10 hover:text-white sm:inline-flex">Pelayanan</a>
                    @auth
                        <a href="{{ auth()->user()->role === 2 ? route('admin.dashboard') : (auth()->user()->role === 1 ? route('petugas.dashboard') : route('dashboard')) }}" class="rounded-lg bg-white px-4 py-2 text-sm font-bold text-green-700 shadow-sm hover:bg-green-50 hover:shadow-md">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg bg-white/15 px-4 py-2 text-sm font-bold text-white ring-1 ring-white/30 backdrop-blur hover:bg-white/25">Masuk</a>
                        <a href="{{ route('register') }}" class="rounded-lg bg-white px-4 py-2 text-sm font-bold text-green-700 shadow-sm hover:bg-green-50 hover:shadow-md">Daftar</a>
                    @endauth
                </div>
            </nav>
        </header>

        <section class="relative flex min-h-[94vh] items-center overflow-hidden bg-green-950 bg-cover bg-center" style="background-image: linear-gradient(110deg, rgba(20, 83, 45, 0.96) 0%, rgba(22, 163, 74, 0.82) 42%, rgba(15, 23, 42, 0.46) 100%), url('https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1800&q=85');">
            <div class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-green-950/85 to-transparent"></div>
            <div class="relative mx-auto w-full max-w-7xl px-4 pb-20 pt-32 sm:px-6 lg:px-8">
                <div class="max-w-4xl text-white" data-aos="fade-up">
                    <p class="mb-5 inline-flex rounded-full bg-white/15 px-4 py-2 text-xs font-black uppercase tracking-[0.24em] text-green-50 ring-1 ring-white/20 backdrop-blur">NutriCycle circular feed</p>
                    <h1 class="text-5xl font-black leading-[1.02] tracking-normal sm:text-6xl lg:text-7xl">Ubah Sampah Beranak Jadi Pakan Ternak</h1>
                    <p class="mt-6 max-w-2xl text-lg leading-8 text-green-50">Platform sirkular untuk warga dan peternak: sampah organik dijemput, diolah, berubah jadi poin, lalu kembali sebagai pakan bernilai.</p>
                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('produk.index') }}" class="btn-secondary border-white/20 bg-white text-green-700 hover:bg-green-50">Beli Produk</a>
                        <a href="{{ route('pemanggilan.create') }}" class="btn-primary bg-green-950 hover:bg-green-900">Panggil Petugas</a>
                    </div>
                    <div class="mt-10 grid max-w-2xl grid-cols-3 gap-3 text-white">
                        <div class="rounded-lg bg-white/12 p-4 backdrop-blur"><div class="text-2xl font-black">30%</div><div class="text-xs text-green-50/80">maks diskon</div></div>
                        <div class="rounded-lg bg-white/12 p-4 backdrop-blur"><div class="text-2xl font-black">1:10</div><div class="text-xs text-green-50/80">poin rupiah</div></div>
                        <div class="rounded-lg bg-white/12 p-4 backdrop-blur"><div class="text-2xl font-black">5+</div><div class="text-xs text-green-50/80">produk awal</div></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="-mt-12 bg-transparent px-4 sm:px-6 lg:px-8">
            <div class="relative z-10 mx-auto grid max-w-7xl gap-3 rounded-lg border border-white/50 bg-white p-4 shadow-xl sm:grid-cols-2 lg:grid-cols-4" data-aos="fade-up">
                @foreach ([['Pickup terjadwal', 'Tidak perlu antre atau menunggu kabar manual.'], ['Poin otomatis', 'Setiap sampah selesai diproses jadi nilai belanja.'], ['Produk sirkular', 'Pakan hasil olahan siap dibeli dari katalog.'], ['Operasi terlacak', 'Admin dan petugas memantau status dari dashboard.']] as $item)
                    <div class="rounded-lg bg-slate-50 p-4">
                        <div class="text-lg font-black text-slate-900">{{ $item[0] }}</div>
                        <p class="mt-2 text-sm leading-6 text-slate-500">{{ $item[1] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-white py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl" data-aos="fade-up">
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Cara kerja</p>
                    <h2 class="mt-3 text-3xl font-black text-slate-900 sm:text-4xl">Tiga langkah untuk ikut siklus baru.</h2>
                </div>
                <div class="mt-10 grid gap-5 md:grid-cols-3">
                    @foreach ([['Kumpulkan Sampah', 'Pisahkan sisa organik harian yang masih bisa diolah.', 'M4.5 12.75 9 17.25 19.5 6.75'], ['Hubungi Petugas', 'Pilih jadwal pickup dan petugas akan menjemput ke alamat Anda.', 'M8.25 18.75a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm7.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM3.75 6h11.5l3 4.5h2v5.25H18M3.75 6v9.75h3'], ['Dapatkan Poin', 'Sampah selesai diproses, poin masuk dan bisa dipakai untuk diskon.', 'M12 6v12m6-6H6']] as $index => $step)
                        <div class="card card-hover p-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-lg bg-green-600 text-white shadow-sm">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="{{ $step[2] }}" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div class="mb-3 inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-black text-green-700">0{{ $index + 1 }}</div>
                            <h3 class="text-xl font-black text-slate-900">{{ $step[0] }}</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $step[1] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-slate-950 py-24 text-white">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
                <div data-aos="fade-up">
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-green-300">Kenapa berbeda</p>
                    <h2 class="mt-3 text-3xl font-black sm:text-4xl">Bukan cuma jual produk, tapi menghubungkan seluruh siklus.</h2>
                    <p class="mt-5 text-lg leading-8 text-slate-300">NutriCycle menyatukan pickup warga, operasional petugas, point reward, dan marketplace pakan dalam satu alur yang bisa dipantau.</p>
                    <div class="mt-8 grid gap-3 sm:grid-cols-2">
                        @foreach ([['Lebih rapi', 'Semua status pickup dan pengiriman tampil jelas.'], ['Lebih hemat', 'Poin bisa menurunkan total belanja sampai batas diskon.'], ['Lebih cepat', 'Petugas menerima kartu pekerjaan yang siap diupdate.'], ['Lebih bersih', 'Sampah organik punya jalur manfaat baru.']] as $benefit)
                            <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                                <div class="font-black text-white">{{ $benefit[0] }}</div>
                                <p class="mt-2 text-sm leading-6 text-slate-300">{{ $benefit[1] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2" data-aos="fade-up" data-aos-delay="120">
                    <img src="https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&w=900&q=80" alt="Bahan organik yang siap diolah" class="h-72 w-full rounded-lg object-cover shadow-xl sm:mt-12">
                    <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=900&q=80" alt="Peternakan dan rantai pangan" class="h-72 w-full rounded-lg object-cover shadow-xl">
                </div>
            </div>
        </section>

        <section class="bg-slate-50 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between" data-aos="fade-up">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Produk unggulan</p>
                        <h2 class="mt-3 text-3xl font-black text-slate-900 sm:text-4xl">Pakan daur ulang siap pakai.</h2>
                    </div>
                    <a href="{{ route('produk.index') }}" class="btn-secondary">Lihat semua produk</a>
                </div>
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($produk as $item)
                        @php
                            $stockClass = $item->stok <= 0 ? 'bg-red-100 text-red-700' : ($item->stok <= 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-700');
                        @endphp
                        <article class="card card-hover group overflow-hidden" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                            <div class="relative overflow-hidden">
                                <img src="{{ cloudinaryUrl($item->gambar) }}" alt="{{ $item->nama }}" class="aspect-square w-full rounded-t-lg object-cover transition-all duration-300 group-hover:scale-105">
                                <span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-black text-green-700 shadow-sm backdrop-blur">{{ $item->kategori }}</span>
                                <span class="absolute right-3 top-3 rounded-full px-3 py-1 text-xs font-black shadow-sm {{ $stockClass }}">Stok {{ $item->stok }}</span>
                            </div>
                            <div class="p-5">
                                <h3 class="text-lg font-black text-slate-900">{{ $item->nama }}</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-500">{{ \Illuminate\Support\Str::limit($item->deskripsi, 92) }}</p>
                                <div class="mt-4 text-xl font-black text-green-700">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
                                <a href="{{ route('produk.show', $item->slug) }}" class="btn-secondary mt-4 w-full py-2.5">Lihat Detail</a>
                            </div>
                        </article>
                    @empty
                        <div class="card border-dashed p-10 text-center text-slate-500 sm:col-span-2 lg:col-span-3">Produk belum tersedia.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="bg-white py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div data-aos="fade-up">
                        <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Alur ekosistem</p>
                        <h2 class="mt-3 text-3xl font-black text-slate-900 sm:text-4xl">Dari dapur rumah ke kandang ternak.</h2>
                        <p class="mt-5 text-lg leading-8 text-slate-600">Sisa organik yang biasanya berhenti sebagai limbah dapat masuk ke rantai yang lebih berguna: dijemput, diproses, dihitung poinnya, lalu jadi produk pakan.</p>
                        <div class="mt-8 grid gap-3">
                            @foreach ([['01', 'Warga buat request pickup dan memilih jadwal.'], ['02', 'Admin assign petugas, status bergerak real-time.'], ['03', 'Sampah selesai diproses, poin masuk ke akun warga.'], ['04', 'Poin dipakai untuk membeli produk pakan daur ulang.']] as $flow)
                                <div class="flex gap-4 rounded-lg border border-slate-200 bg-white p-4 shadow-sm" data-aos="fade-up" data-aos-delay="{{ $loop->index * 70 }}">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-600 text-sm font-black text-white">{{ $flow[0] }}</div>
                                    <div class="pt-1 font-bold text-slate-800">{{ $flow[1] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="rounded-lg bg-green-50 p-4 shadow-sm" data-aos="fade-up" data-aos-delay="120">
                        <img src="https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=1000&q=85" alt="Sayuran organik segar sebagai sumber limbah bernilai" class="aspect-[4/3] w-full rounded-lg object-cover">
                        <div class="mt-4 grid grid-cols-3 gap-3 text-center">
                            <div class="rounded-lg bg-white p-4"><div class="text-2xl font-black text-green-700">Pickup</div><div class="mt-1 text-xs font-bold text-slate-500">request</div></div>
                            <div class="rounded-lg bg-white p-4"><div class="text-2xl font-black text-green-700">Poin</div><div class="mt-1 text-xs font-bold text-slate-500">reward</div></div>
                            <div class="rounded-lg bg-white p-4"><div class="text-2xl font-black text-green-700">Pakan</div><div class="mt-1 text-xs font-bold text-slate-500">produk</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-slate-50 py-24">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
                <div data-aos="fade-up">
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Tentang kami</p>
                    <h2 class="mt-3 text-3xl font-black text-slate-900 sm:text-4xl">Membangun rantai pangan yang lebih bersih dari rumah.</h2>
                    <p class="mt-5 text-lg leading-8 text-slate-600">NutriCycle menghubungkan warga, petugas lapangan, dan pembeli pakan agar limbah organik rumah tangga kembali menjadi input produktif untuk peternakan.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card bg-green-50 p-6"><div class="text-4xl font-black text-green-700">3</div><div class="mt-2 text-sm font-bold text-green-900">peran aktif</div></div>
                    <div class="card bg-slate-50 p-6"><div class="text-4xl font-black text-slate-900">30%</div><div class="mt-2 text-sm font-bold text-slate-600">maks diskon</div></div>
                    <div class="card bg-emerald-50 p-6"><div class="text-4xl font-black text-green-700">1:10</div><div class="mt-2 text-sm font-bold text-green-900">nilai poin</div></div>
                </div>
            </div>
        </section>

        <section class="bg-green-700 px-4 py-16 text-white sm:px-6 lg:px-8">
            <div class="mx-auto flex max-w-7xl flex-col gap-6 lg:flex-row lg:items-center lg:justify-between" data-aos="fade-up">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-green-100">Mulai siklusnya</p>
                    <h2 class="mt-2 text-3xl font-black sm:text-4xl">Sampah hari ini bisa jadi nilai belanja berikutnya.</h2>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('register') }}" class="btn-secondary bg-white text-green-700 hover:bg-green-50">Daftar Akun</a>
                    <a href="{{ route('produk.index') }}" class="btn-primary bg-green-950 hover:bg-green-900">Lihat Produk</a>
                </div>
            </div>
        </section>

        <footer class="bg-green-950 py-10 text-white">
            <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <div>
                    <div class="text-xl font-black">NutriCycle</div>
                    <div class="mt-1 text-sm text-green-50/70">Ubah Sampah Beranak Jadi Pakan Ternak</div>
                </div>
                <div class="flex gap-5 text-sm text-green-50/75">
                    <a href="{{ route('landing') }}" class="hover:text-white">Beranda</a>
                    <a href="{{ route('pelayanan') }}" class="hover:text-white">Pelayanan</a>
                    <a href="{{ route('produk.index') }}" class="hover:text-white">Produk</a>
                </div>
                <div class="text-sm text-green-50/60">&copy; {{ date('Y') }} NutriCycle</div>
            </div>
        </footer>
    </div>
@endsection
