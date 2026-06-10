@extends('layouts.admin')

@section('content')
    <div class="space-y-8">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-green-700">Admin</p>
            <h1 class="mt-2 text-3xl font-black text-slate-900">Dashboard</h1>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-lg border border-slate-200 bg-white p-6"><div class="text-sm font-semibold text-slate-500">Total Users</div><div class="mt-2 text-3xl font-black text-slate-900">{{ number_format($totalUsers) }}</div></div>
            <div class="rounded-lg border border-slate-200 bg-white p-6"><div class="text-sm font-semibold text-slate-500">Transaksi</div><div class="mt-2 text-3xl font-black text-slate-900">{{ number_format($totalTransaksi) }}</div></div>
            <div class="rounded-lg border border-slate-200 bg-white p-6"><div class="text-sm font-semibold text-slate-500">Pemanggilan</div><div class="mt-2 text-3xl font-black text-slate-900">{{ number_format($totalPemanggilan) }}</div></div>
            <div class="rounded-lg border border-green-200 bg-green-50 p-6"><div class="text-sm font-semibold text-green-700">Revenue Paid</div><div class="mt-2 text-3xl font-black text-green-900">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div></div>
        </div>
    </div>
@endsection
