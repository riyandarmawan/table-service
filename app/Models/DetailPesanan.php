<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPesanan extends Model
{
    /** @use HasFactory<\Database\Factories\DetailPesananFactory> */
    use HasFactory;

    protected $guarded = [];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
