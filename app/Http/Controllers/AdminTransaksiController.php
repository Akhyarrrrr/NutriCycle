<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminTransaksiController extends Controller
{
    public function index(): View
    {
        return view('admin.transaksi.index');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'petugas_id' => ['nullable', 'integer', Rule::exists('users', 'id')->where('role', User::ROLE_PETUGAS)],
            'status_pengiriman' => ['required', 'in:menunggu,dikonfirmasi,dikirim,selesai'],
        ]);

        Transaksi::findOrFail($id)->update([
            'petugas_id' => $validated['petugas_id'] ?? null,
            'status_pengiriman' => $validated['status_pengiriman'],
        ]);

        return back()->with('success', 'Transaksi berhasil diperbarui.');
    }
}
