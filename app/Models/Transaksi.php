<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'petugas_id',
        'kode_transaksi',
        'total_harga',
        'diskon_poin',
        'metode_bayar',
        'snap_token',
        'status_pembayaran',
        'status_pengiriman',
        'alamat_kirim',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'total_harga' => 'integer',
            'diskon_poin' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
