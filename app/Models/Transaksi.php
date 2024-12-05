<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_transaksi';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public static function generateIdTransaksi()
    {
        $lastTransaksi = self::withTrashed()->orderBy('id_transaksi', 'desc')->first(); // Get the latest record
        if ($lastTransaksi) {
            $lastId = $lastTransaksi->id_transaksi;
            $number = (int) substr($lastId, 3); // Extract the numeric part
            $nextNumber = str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad
        } else {
            $nextNumber = '001'; // Default if no records exist
        }

        return "TR-{$nextNumber}";
    }

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan',  'id_pesanan');
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) =>
            $query->where('id_transaksi', 'like', "%$search%")
                ->orWhere('total', 'like', "%$search%")
                ->orWhere('bayar', 'like', "%$search%")
                ->orWhere('kembalian', 'like', "%$search%")
        );
    }
}
