@extends('layouts.admin')

@section('content')
    @php
        $stats = [
            ['label' => 'Total Users', 'value' => number_format($totalUsers), 'tone' => 'text-slate-900', 'bg' => 'bg-slate-100', 'path' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 1 1 15 0'],
            ['label' => 'Transaksi', 'value' => number_format($totalTransaksi), 'tone' => 'text-blue-700', 'bg' => 'bg-blue-50', 'path' => 'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5'],
            ['label' => 'Pemanggilan', 'value' => number_format($totalPemanggilan), 'tone' => 'text-orange-700', 'bg' => 'bg-orange-50', 'path' => 'M8.25 18.75a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm7.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM3.75 6h11.5l3 4.5h2v5.25H18M3.75 6v9.75h3'],
            ['label' => 'Revenue Paid', 'value' => 'Rp'.number_format($totalRevenue, 0, ',', '.'), 'tone' => 'text-green-700', 'bg' => 'bg-green-50', 'path' => 'M12 6v12m6-6H6'],
        ];
    @endphp

    <div class="space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Admin</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900">Dashboard Operasional</h1>
                <p class="mt-2 text-sm text-slate-500">Ringkasan cepat untuk transaksi, pickup, produk, dan akun NutriCycle.</p>
            </div>
            <a href="{{ route('admin.produk.create') }}" class="btn-primary w-full sm:w-auto">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 5v14m7-7H5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Tambah Produk
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="card card-hover p-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-sm font-semibold text-slate-500">{{ $stat['label'] }}</div>
                            <div class="mt-3 text-3xl font-black {{ $stat['tone'] }}">{{ $stat['value'] }}</div>
                        </div>
                        <div class="flex h-11 w-11 items-center justify-center rounded-lg {{ $stat['bg'] }} {{ $stat['tone'] }}">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="{{ $stat['path'] }}" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid gap-4 lg:grid-cols-3">
            <a href="{{ route('admin.pemanggilan.index') }}" class="card card-hover p-5" data-aos="fade-up">
                <div class="text-sm font-bold text-slate-500">Kelola Pickup</div>
                <div class="mt-2 text-lg font-black text-slate-900">Assign petugas dan poin</div>
            </a>
            <a href="{{ route('admin.transaksi.index') }}" class="card card-hover p-5" data-aos="fade-up" data-aos-delay="80">
                <div class="text-sm font-bold text-slate-500">Kelola Transaksi</div>
                <div class="mt-2 text-lg font-black text-slate-900">Pantau pembayaran dan kiriman</div>
            </a>
            <a href="{{ route('admin.users.index') }}" class="card card-hover p-5" data-aos="fade-up" data-aos-delay="160">
                <div class="text-sm font-bold text-slate-500">Kelola Users</div>
                <div class="mt-2 text-lg font-black text-slate-900">Atur role user dan petugas</div>
            </a>
        </div>
    </div>
@endsection
