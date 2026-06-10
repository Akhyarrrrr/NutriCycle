<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoinLog extends Model
{
    use HasFactory;

    protected $table = 'poin_log';

    protected $fillable = [
        'user_id',
        'jumlah',
        'tipe',
        'keterangan',
        'ref_id',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
