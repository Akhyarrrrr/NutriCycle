<?php

namespace App\Http\Controllers;

use App\Models\Pemanggilan;
use App\Models\PoinLog;
use App\Models\Transaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PetugasController extends Controller
{
    public function dashboard(Request $request): View
    {
        $petugasId = $request->user()->id;
        $pickupCount = Pemanggilan::where('petugas_id', $petugasId)->where('status', '!=', 'selesai')->count();
        $deliveryCount = Transaksi::where('petugas_id', $petugasId)->where('status_pengiriman', '!=', 'selesai')->count();

        return view('petugas.dashboard', compact('pickupCount', 'deliveryCount'));
    }

    public function pickupIndex(Request $request): View
    {
        $pemanggilan = Pemanggilan::with('user')
            ->where('petugas_id', $request->user()->id)
            ->where('status', '!=', 'selesai')
            ->latest()
            ->paginate(10);

        return view('petugas.pickup.index', compact('pemanggilan'));
    }

    public function pickupUpdate(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:dijemput,selesai,dibatalkan'],
        ]);

        DB::transaction(function () use ($request, $id, $validated): void {
            $pemanggilan = Pemanggilan::with('user')
                ->where('petugas_id', $request->user()->id)
                ->findOrFail($id);

            $previousStatus = $pemanggilan->status;
            $pemanggilan->update(['status' => $validated['status']]);

            if ($validated['status'] === 'selesai' && $previousStatus !== 'selesai' && $pemanggilan->poin_diberikan > 0) {
                $pemanggilan->user->increment('poin', $pemanggilan->poin_diberikan);

                PoinLog::create([
                    'user_id' => $pemanggilan->user_id,
                    'jumlah' => $pemanggilan->poin_diberikan,
                    'tipe' => 'masuk',
                    'keterangan' => 'Poin pemanggilan sampah selesai',
                    'ref_id' => (string) $pemanggilan->id,
                ]);
            }
        });

        return back()->with('success', 'Status pickup diperbarui.');
    }

    public function pengirimanIndex(Request $request): View
    {
        $transaksi = Transaksi::with('user')
            ->where('petugas_id', $request->user()->id)
            ->where('status_pengiriman', '!=', 'selesai')
            ->latest()
            ->paginate(10);

        return view('petugas.pengiriman.index', compact('transaksi'));
    }

    public function pengirimanUpdate(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status_pengiriman' => ['required', 'in:dikonfirmasi,dikirim,selesai'],
        ]);

        Transaksi::where('petugas_id', $request->user()->id)
            ->findOrFail($id)
            ->update(['status_pengiriman' => $validated['status_pengiriman']]);

        return back()->with('success', 'Status pengiriman diperbarui.');
    }
}
