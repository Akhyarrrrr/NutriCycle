@extends('layouts.admin')

@section('content')
    <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data" class="card mx-auto max-w-4xl p-6" data-aos="fade-up">
        <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Katalog</p>
        <h1 class="mt-2 text-3xl font-black text-slate-900">Tambah Produk</h1>
        <p class="mb-6 mt-2 text-sm text-slate-500">Lengkapi detail produk agar siap tampil di halaman warga.</p>
        @include('admin.produk._form')
    </form>
@endsection
