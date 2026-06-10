@extends('layouts.admin')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-3xl font-black text-slate-900">Users</h1>
            <form method="GET" class="flex gap-2">
                <select name="role" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Semua role</option>
                    <option value="0" @selected($role === '0')>User</option>
                    <option value="1" @selected($role === '1')>Petugas</option>
                    <option value="2" @selected($role === '2')>Admin</option>
                </select>
                <button class="rounded-lg bg-green-600 px-4 py-2 text-sm font-bold text-white hover:bg-green-700">Filter</button>
            </form>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Kontak</th><th class="px-4 py-3">Poin</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Update</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-4"><div class="font-bold text-slate-900">{{ $user->name }}</div><div class="max-w-sm text-xs text-slate-500">{{ $user->alamat }}</div></td>
                            <td class="px-4 py-4">{{ $user->email }}<br><span class="text-slate-500">{{ $user->phone }}</span></td>
                            <td class="px-4 py-4">{{ number_format($user->poin) }}</td>
                            <td class="px-4 py-4">{{ ['User', 'Petugas', 'Admin'][$user->role] ?? 'User' }}</td>
                            <td class="px-4 py-4">
                                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="rounded-lg border border-slate-300 px-3 py-2">
                                        <option value="0" @selected($user->role === 0)>User</option>
                                        <option value="1" @selected($user->role === 1)>Petugas</option>
                                        <option value="2" @selected($user->role === 2)>Admin</option>
                                    </select>
                                    <button class="rounded-lg bg-green-600 px-4 py-2 font-bold text-white hover:bg-green-700">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $users->links() }}</div>
    </section>
@endsection
