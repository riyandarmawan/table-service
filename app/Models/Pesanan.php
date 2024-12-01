<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    /** @use HasFactory<\Database\Factories\PesananFactory> */
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_pesanan';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public static function generateIdPesanan()
    {
        $lastPesanan = self::withTrashed()->orderBy('id_pesanan', 'desc')->first(); // Get the latest record
        if ($lastPesanan) {
            $lastId = $lastPesanan->id_pesanan;
            $number = (int) substr($lastId, 3); // Extract the numeric part
            $nextNumber = str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad
        } else {
            $nextNumber = '001'; // Default if no records exist
        }

        return "PS-{$nextNumber}";
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'detail_pesanans', 'id_menu', 'id_pesanan');
    }

    public function meja(): BelongsTo
    {
        return $this->belongsTo(Meja::class, 'id_meja', 'id_meja');
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) =>
            $query->where('id_pesanan', 'like', "%$search%")

                ->orWhereHas('menu', fn(Builder $query, $search) =>
                    $query->where('id_menu', 'like', "%$search%")
                        ->orWhere('nama_menu', 'like', "%$search%"))

                ->orWhereHas('meja', fn(Builder $query, $search) =>
                    $query->where('id_meja', 'like', "%$search%")
                        ->orWhere('kapasitas_kursi', 'like', "%$search%"))

                ->orWhereHas('user', fn(Builder $query, $search) =>
                    $query->where('username', 'like', "%$search%")
                        ->orWhere('nama', 'like', "%$search%"))
        );
    }
}
