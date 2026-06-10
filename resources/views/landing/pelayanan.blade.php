@extends('layouts.guest')

@section('content')
    <div class="min-h-screen bg-white">
        <nav class="border-b border-slate-200">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('landing') }}"><x-application-logo /></a>
                <a href="{{ route('landing') }}" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-bold text-white hover:bg-green-700">Beranda</a>
            </div>
        </nav>
        <main class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-green-700">Pelayanan</p>
            <h1 class="mt-3 text-4xl font-black text-slate-900">Edukasi Daur Ulang Sampah Organik</h1>
            <p class="mt-5 text-lg leading-8 text-slate-600">Sampah organik dari dapur dan halaman bisa menjadi sumber nutrisi untuk pakan ternak jika dipilah, dijemput, dan diproses dengan benar.</p>
            <div class="mt-10 grid gap-5 md:grid-cols-2">
                <section class="rounded-lg border border-slate-200 p-6">
                    <h2 class="text-xl font-bold text-slate-900">Yang Bisa Dijemput</h2>
                    <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-600">
                        <li>Sisa sayur dan buah tanpa plastik atau kemasan.</li>
                        <li>Ampas kelapa, ampas tahu, dan sisa biji-bijian.</li>
                        <li>Daun kering dan bahan organik halaman.</li>
                    </ul>
                </section>
                <section class="rounded-lg border border-slate-200 p-6">
                    <h2 class="text-xl font-bold text-slate-900">Yang Perlu Dihindari</h2>
                    <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-600">
                        <li>Plastik, kaca, logam, dan bahan kimia rumah tangga.</li>
                        <li>Sampah medis, popok, dan bahan berbahaya.</li>
                        <li>Sisa makanan yang tercampur minyak berlebih.</li>
                    </ul>
                </section>
            </div>
            <div class="mt-10 rounded-lg bg-green-50 p-6">
                <h2 class="text-xl font-bold text-green-900">Dampak untuk Warga</h2>
                <p class="mt-3 leading-7 text-green-900/80">Setiap pemanggilan yang selesai dapat diberi poin oleh admin dan dikonfirmasi oleh petugas. Poin tersebut bisa dipakai sebagai diskon belanja produk pakan NutriCycle.</p>
            </div>
        </main>
    </div>
@endsection
