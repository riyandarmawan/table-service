<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
    use HasFactory;

    protected $primaryKey = 'id_transaksi';

    protected $guarded = [];

    public function pesanan(): BelongsTo {
        return $this->belongsTo(Pesanan::class);
    }
}
