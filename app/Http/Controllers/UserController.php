<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Pemanggilan;
use App\Models\PoinLog;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Throwable;

class UserController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $pemanggilan = $user->pemanggilan()->latest()->take(5)->get();
        $transaksi = $user->transaksi()->latest()->take(5)->get();

        return view('user.dashboard', compact('user', 'pemanggilan', 'transaksi'));
    }

    public function produk(Request $request): View
    {
        $kategori = $request->string('kategori')->toString();
        $kategoriList = Produk::query()
            ->where('is_active', true)
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $produk = Produk::query()
            ->where('is_active', true)
            ->when($kategori !== '', fn ($query) => $query->where('kategori', $kategori))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('user.produk.index', compact('produk', 'kategoriList', 'kategori'));
    }

    public function produkDetail(string $slug): View
    {
        $produk = Produk::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('user.produk.show', compact('produk'));
    }

    public function keranjang(Request $request): View
    {
        $items = Cart::with('produk')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        $subtotal = $items->sum(fn (Cart $item) => ($item->produk?->harga ?? 0) * $item->jumlah);

        return view('user.keranjang', compact('items', 'subtotal'));
    }

    public function addCart(Request $request, int $id): RedirectResponse
    {
        $produk = Produk::query()
            ->where('is_active', true)
            ->findOrFail($id);

        $validated = $request->validate([
            'jumlah' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $jumlah = (int) ($validated['jumlah'] ?? 1);

        if ($produk->stok < $jumlah) {
            throw ValidationException::withMessages([
                'jumlah' => 'Stok produk tidak mencukupi.',
            ]);
        }

        $cart = Cart::firstOrNew([
            'user_id' => $request->user()->id,
            'produk_id' => $produk->id,
        ]);

        $cart->jumlah = min(($cart->exists ? $cart->jumlah : 0) + $jumlah, $produk->stok);
        $cart->save();

        return redirect()->route('keranjang.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function updateCart(Request $request, int $id): RedirectResponse
    {
        $cart = Cart::with('produk')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'jumlah' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        if ((int) $validated['jumlah'] === 0) {
            $cart->delete();

            return back()->with('success', 'Item keranjang dihapus.');
        }

        if ($cart->produk && $cart->produk->stok < (int) $validated['jumlah']) {
            throw ValidationException::withMessages([
                'jumlah' => 'Jumlah melebihi stok tersedia.',
            ]);
        }

        $cart->update(['jumlah' => (int) $validated['jumlah']]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function removeCart(Request $request, int $id): RedirectResponse
    {
        Cart::query()
            ->where('user_id', $request->user()->id)
            ->findOrFail($id)
            ->delete();

        return back()->with('success', 'Item keranjang dihapus.');
    }

    public function checkoutPage(Request $request): View|RedirectResponse
    {
        $items = Cart::with('produk')->where('user_id', $request->user()->id)->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang masih kosong.');
        }

        $subtotal = $items->sum(fn (Cart $item) => ($item->produk?->harga ?? 0) * $item->jumlah);
        $maxDiskon = (int) floor($subtotal * 0.3);
        $potensiDiskon = min($request->user()->poin * 10, $maxDiskon);

        return view('user.checkout', compact('items', 'subtotal', 'maxDiskon', 'potensiDiskon'));
    }

    public function checkoutProcess(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'alamat_kirim' => ['required', 'string', 'max:1000'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'use_poin' => ['nullable', 'boolean'],
        ]);

        $user = $request->user();
        $items = Cart::with('produk')->where('user_id', $user->id)->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang masih kosong.');
        }

        $transaksi = DB::transaction(function () use ($items, $user, $validated, $request): Transaksi {
            $totalAwal = 0;

            foreach ($items as $item) {
                if (! $item->produk || ! $item->produk->is_active) {
                    throw ValidationException::withMessages(['produk' => 'Ada produk yang tidak lagi tersedia.']);
                }

                if ($item->produk->stok < $item->jumlah) {
                    throw ValidationException::withMessages([
                        'stok' => "Stok {$item->produk->nama} tidak mencukupi.",
                    ]);
                }

                $totalAwal += $item->produk->harga * $item->jumlah;
            }

            $diskonRupiah = 0;
            $poinDipakai = 0;

            if ($request->boolean('use_poin') && $user->poin > 0) {
                $maxDiskon = (int) floor($totalAwal * 0.3);
                $diskonRupiah = min($user->poin * 10, $maxDiskon);
                $poinDipakai = (int) floor($diskonRupiah / 10);
                $diskonRupiah = $poinDipakai * 10;
            }

            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'kode_transaksi' => 'NC-'.now()->format('YmdHis').'-'.Str::upper(Str::random(5)),
                'total_harga' => max(0, $totalAwal - $diskonRupiah),
                'diskon_poin' => $diskonRupiah,
                'metode_bayar' => 'midtrans',
                'status_pembayaran' => 'pending',
                'status_pengiriman' => 'menunggu',
                'alamat_kirim' => $validated['alamat_kirim'],
                'catatan' => $validated['catatan'] ?? null,
            ]);

            foreach ($items as $item) {
                $transaksi->details()->create([
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->produk->harga,
                    'subtotal' => $item->produk->harga * $item->jumlah,
                ]);

                $item->produk->decrement('stok', $item->jumlah);
            }

            if ($poinDipakai > 0) {
                $user->decrement('poin', $poinDipakai);
                PoinLog::create([
                    'user_id' => $user->id,
                    'jumlah' => $poinDipakai,
                    'tipe' => 'keluar',
                    'keterangan' => 'Diskon transaksi '.$transaksi->kode_transaksi,
                    'ref_id' => $transaksi->kode_transaksi,
                ]);
            }

            Cart::where('user_id', $user->id)->delete();

            return $transaksi->load('details.produk', 'user');
        });

        $snapToken = $this->createSnapToken($transaksi);

        if ($snapToken !== null) {
            $transaksi->update(['snap_token' => $snapToken]);
        }

        return redirect()
            ->route('transaksi.show', $transaksi->kode_transaksi)
            ->with($snapToken ? 'success' : 'warning', $snapToken ? 'Checkout berhasil dibuat.' : 'Checkout berhasil dibuat, tetapi Snap token belum tersedia. Periksa konfigurasi Midtrans.');
    }

    public function transaksiIndex(Request $request): View
    {
        $transaksi = Transaksi::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('user.transaksi.index', compact('transaksi'));
    }

    public function transaksiDetail(Request $request, string $kode): View
    {
        $transaksi = Transaksi::with('details.produk', 'petugas')
            ->where('user_id', $request->user()->id)
            ->where('kode_transaksi', $kode)
            ->firstOrFail();

        return view('user.transaksi.show', compact('transaksi'));
    }

    public function pemanggilanIndex(Request $request): View
    {
        $pemanggilan = Pemanggilan::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('user.pemanggilan.index', compact('pemanggilan'));
    }

    public function pemanggilanCreate(Request $request): View
    {
        return view('user.pemanggilan.create', ['user' => $request->user()]);
    }

    public function pemanggilanStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'alamat' => ['required', 'string', 'max:1000'],
            'jadwal_tanggal' => ['required', 'date', 'after_or_equal:today'],
            'jadwal_jam' => ['required', 'date_format:H:i'],
            'estimasi_kg' => ['required', 'numeric', 'min:0.1', 'max:999.99'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        Pemanggilan::create([
            ...$validated,
            'user_id' => $request->user()->id,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pemanggilan.index')->with('success', 'Permintaan pemanggilan berhasil dibuat.');
    }

    private function createSnapToken(Transaksi $transaksi): ?string
    {
        if (blank(config('midtrans.server_key'))) {
            return null;
        }

        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = (bool) config('midtrans.is_production');
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;

        $itemDetails = $transaksi->details->map(fn ($detail) => [
            'id' => (string) $detail->produk_id,
            'price' => (int) $detail->harga_satuan,
            'quantity' => (int) $detail->jumlah,
            'name' => Str::limit($detail->produk?->nama ?? 'Produk NutriCycle', 45, ''),
        ])->values()->all();

        if ($transaksi->diskon_poin > 0) {
            $itemDetails[] = [
                'id' => 'POINTS',
                'price' => -1 * $transaksi->diskon_poin,
                'quantity' => 1,
                'name' => 'Diskon poin',
            ];
        }

        try {
            return Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => $transaksi->kode_transaksi,
                    'gross_amount' => (int) $transaksi->total_harga,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $transaksi->user->name,
                    'email' => $transaksi->user->email,
                    'phone' => $transaksi->user->phone,
                    'shipping_address' => [
                        'address' => $transaksi->alamat_kirim,
                    ],
                ],
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return null;
        }
    }
}
