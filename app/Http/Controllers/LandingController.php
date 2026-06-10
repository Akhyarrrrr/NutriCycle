<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $produk = Schema::hasTable('produk')
            ? Produk::query()
                ->where('is_active', true)
                ->latest()
                ->take(6)
                ->get()
            : new Collection();

        return view('landing.index', compact('produk'));
    }

    public function pelayanan(): View
    {
        return view('landing.pelayanan');
    }
}
