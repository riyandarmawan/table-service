<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    /** @use HasFactory<\Database\Factories\PesananFactory> */
    use HasFactory;

    protected $primaryKey = 'id_pesanan';

    protected $guarded = [];

    public function menu(): BelongsTo {
        return $this->belongsTo(Menu::class);
    }

    public function pelanggan(): BelongsTo {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function transaksis(): HasMany {
        return $this->hasMany(Transaksi::class);
    }
}
