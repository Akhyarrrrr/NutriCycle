@extends('layouts.admin')

@section('content')
    @php
        $roleLabels = ['User', 'Petugas', 'Admin'];
        $roleClasses = [
            0 => 'bg-slate-100 text-slate-700 ring-slate-200',
            1 => 'bg-blue-100 text-blue-700 ring-blue-200',
            2 => 'bg-green-100 text-green-700 ring-green-200',
        ];
    @endphp

    <section class="space-y-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.22em] text-green-700">Akses</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900">Users</h1>
                <p class="mt-2 text-sm text-slate-500">Pantau warga, petugas, admin, dan saldo poin mereka.</p>
            </div>
            <form method="GET" class="card flex flex-col gap-2 p-3 sm:flex-row">
                <select name="role" class="form-input min-w-44">
                    <option value="">Semua role</option>
                    <option value="0" @selected($role === '0')>User</option>
                    <option value="1" @selected($role === '1')>Petugas</option>
                    <option value="2" @selected($role === '2')>Admin</option>
                </select>
                <button type="submit" class="btn-primary py-2">Filter</button>
            </form>
        </div>

        <div class="table-shell" data-aos="fade-up">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-900 text-left text-xs font-semibold uppercase tracking-wide text-white">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Kontak</th>
                        <th class="px-4 py-3">Poin</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Update</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="{{ $loop->odd ? 'bg-white' : 'bg-slate-50/70' }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 40 }}">
                            <td class="px-4 py-4 align-top">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-50 text-sm font-black text-green-700">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $user->name }}</div>
                                        <div class="mt-1 max-w-sm text-xs leading-5 text-slate-500">{{ $user->alamat }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 align-top text-slate-700">
                                <div class="font-medium">{{ $user->email }}</div>
                                <div class="mt-1 text-slate-500">{{ $user->phone }}</div>
                            </td>
                            <td class="px-4 py-4 align-top font-black text-green-700">{{ number_format($user->poin) }}</td>
                            <td class="px-4 py-4 align-top">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $roleClasses[$user->role] ?? $roleClasses[0] }}">
                                    {{ $roleLabels[$user->role] ?? 'User' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex min-w-64 gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="form-input">
                                        <option value="0" @selected($user->role === 0)>User</option>
                                        <option value="1" @selected($user->role === 1)>Petugas</option>
                                        <option value="2" @selected($user->role === 2)>Admin</option>
                                    </select>
                                    <button type="submit" class="icon-button bg-green-600 text-white hover:bg-green-700 hover:text-white" title="Simpan role {{ $user->name }}" aria-label="Simpan role {{ $user->name }}">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-lg bg-green-50 text-green-700">
                                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 1 1 15 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div class="mt-4 font-bold text-slate-900">Data user tidak ditemukan</div>
                                <div class="mt-1 text-sm text-slate-500">Coba ganti filter role.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $users->links() }}</div>
    </section>
@endsection
