<?php

namespace App\Http\Controllers;

use App\Models\Pemanggilan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalTransaksi' => Transaksi::count(),
            'totalPemanggilan' => Pemanggilan::count(),
            'totalRevenue' => Transaksi::where('status_pembayaran', 'paid')->sum('total_harga'),
        ]);
    }
}
