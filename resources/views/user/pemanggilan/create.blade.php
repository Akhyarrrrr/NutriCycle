@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('pemanggilan.store') }}" class="mx-auto max-w-2xl rounded-lg border border-slate-200 bg-white p-6">
        @csrf
        <h1 class="text-3xl font-black text-slate-900">Buat Pemanggilan</h1>
        <div class="mt-6">
            <label for="alamat" class="text-sm font-semibold text-slate-700">Alamat Pickup</label>
            <textarea id="alamat" name="alamat" rows="4" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="mt-5 grid gap-4 sm:grid-cols-2">
            <div>
                <label for="jadwal_tanggal" class="text-sm font-semibold text-slate-700">Tanggal</label>
                <input id="jadwal_tanggal" type="date" name="jadwal_tanggal" value="{{ old('jadwal_tanggal') }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">
            </div>
            <div>
                <label for="jadwal_jam" class="text-sm font-semibold text-slate-700">Jam</label>
                <input id="jadwal_jam" type="time" name="jadwal_jam" value="{{ old('jadwal_jam') }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">
            </div>
        </div>
        <div class="mt-5">
            <label for="estimasi_kg" class="text-sm font-semibold text-slate-700">Estimasi Berat (kg)</label>
            <input id="estimasi_kg" type="number" step="0.01" min="0.1" name="estimasi_kg" value="{{ old('estimasi_kg') }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>
        <div class="mt-5">
            <label for="catatan" class="text-sm font-semibold text-slate-700">Catatan</label>
            <textarea id="catatan" name="catatan" rows="3" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('catatan') }}</textarea>
        </div>
        <button class="mt-6 rounded-lg bg-green-600 px-6 py-3 font-bold text-white hover:bg-green-700">Kirim Permintaan</button>
    </form>
@endsection
