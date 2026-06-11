@extends('layouts.admin')

@section('content')
    <div class="card p-6" data-aos="fade-up">
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Pickup</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900">Pemanggilan Sampah</h1>
                <p class="mt-2 text-sm text-slate-500">Assign petugas, ubah status, dan tentukan poin yang diberikan.</p>
            </div>
        </div>
        <livewire:admin-pemanggilan-table />
    </div>
@endsection
