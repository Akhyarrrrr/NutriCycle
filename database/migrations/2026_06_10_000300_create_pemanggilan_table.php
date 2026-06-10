<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemanggilan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('petugas_id')->nullable()->index();
            $table->text('alamat');
            $table->date('jadwal_tanggal');
            $table->time('jadwal_jam');
            $table->decimal('estimasi_kg', 5, 2);
            $table->text('catatan')->nullable();
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'dijemput', 'selesai', 'dibatalkan'])->default('menunggu')->index();
            $table->integer('poin_diberikan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemanggilan');
    }
};
