@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('pemanggilan.store') }}" class="card mx-auto max-w-2xl p-5 sm:p-6" data-aos="fade-up">
        @csrf
        <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Pickup Sampah</p>
        <h1 class="mt-2 text-3xl font-black text-slate-900">Buat Pemanggilan</h1>
        <div class="mt-6">
            <label for="alamat" class="form-label">Alamat Pickup</label>
            <textarea id="alamat" name="alamat" rows="4" required class="form-input mt-2 @error('alamat') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="mt-5 grid gap-4 sm:grid-cols-2">
            <div>
                <label for="jadwal_tanggal" class="form-label">Tanggal</label>
                <input id="jadwal_tanggal" type="date" name="jadwal_tanggal" value="{{ old('jadwal_tanggal') }}" required class="form-input mt-2 @error('jadwal_tanggal') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                @error('jadwal_tanggal') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="jadwal_jam" class="form-label">Jam</label>
                <input id="jadwal_jam" type="time" name="jadwal_jam" value="{{ old('jadwal_jam') }}" required class="form-input mt-2 @error('jadwal_jam') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                @error('jadwal_jam') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="mt-5">
            <label for="estimasi_kg" class="form-label">Estimasi Berat (kg)</label>
            <input id="estimasi_kg" type="number" step="0.01" min="0.1" name="estimasi_kg" value="{{ old('estimasi_kg') }}" required class="form-input mt-2 @error('estimasi_kg') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
            @error('estimasi_kg') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="mt-5">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea id="catatan" name="catatan" rows="3" class="form-input mt-2">{{ old('catatan') }}</textarea>
        </div>
        <div class="mt-6 flex justify-end">
            <button class="btn-primary w-full sm:w-auto">Kirim Permintaan</button>
        </div>
    </form>
@endsection
