<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('petugas_id')->nullable()->index();
            $table->string('kode_transaksi')->unique();
            $table->bigInteger('total_harga');
            $table->integer('diskon_poin')->default(0);
            $table->string('metode_bayar')->default('midtrans');
            $table->string('snap_token')->nullable();
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed'])->default('pending')->index();
            $table->enum('status_pengiriman', ['menunggu', 'dikonfirmasi', 'dikirim', 'selesai'])->default('menunggu')->index();
            $table->text('alamat_kirim');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
