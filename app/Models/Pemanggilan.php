<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemanggilan extends Model
{
    use HasFactory;

    protected $table = 'pemanggilan';

    protected $fillable = [
        'user_id',
        'petugas_id',
        'alamat',
        'jadwal_tanggal',
        'jadwal_jam',
        'estimasi_kg',
        'catatan',
        'status',
        'poin_diberikan',
    ];

    protected function casts(): array
    {
        return [
            'jadwal_tanggal' => 'date',
            'estimasi_kg' => 'decimal:2',
            'poin_diberikan' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
