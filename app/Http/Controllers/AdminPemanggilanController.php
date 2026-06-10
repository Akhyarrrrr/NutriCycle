<?php

namespace App\Http\Controllers;

use App\Models\Pemanggilan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPemanggilanController extends Controller
{
    public function index(): View
    {
        return view('admin.pemanggilan.index');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'petugas_id' => ['nullable', 'integer', Rule::exists('users', 'id')->where('role', User::ROLE_PETUGAS)],
            'status' => ['required', 'in:menunggu,dikonfirmasi,dijemput,selesai,dibatalkan'],
            'poin_diberikan' => ['required', 'integer', 'min:0', 'max:100000'],
        ]);

        Pemanggilan::findOrFail($id)->update([
            'petugas_id' => $validated['petugas_id'] ?? null,
            'status' => $validated['status'],
            'poin_diberikan' => (int) $validated['poin_diberikan'],
        ]);

        return back()->with('success', 'Pemanggilan berhasil diperbarui.');
    }
}
