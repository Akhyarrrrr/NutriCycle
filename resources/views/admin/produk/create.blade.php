@extends('layouts.admin')

@section('content')
    <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data" class="mx-auto max-w-3xl rounded-lg border border-slate-200 bg-white p-6">
        <h1 class="mb-6 text-3xl font-black text-slate-900">Tambah Produk</h1>
        @include('admin.produk._form')
    </form>
@endsection
