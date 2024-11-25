<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_pelanggan';

    protected $guarded = [];

    public static function generateIdPelanggan()
    {
        $lastPelanggan = self::withTrashed()->orderBy('id_pelanggan', 'desc')->first(); // Get the latest record
        if ($lastPelanggan) {
            $lastId = $lastPelanggan->id_pelanggan;
            $number = (int) substr($lastId, 3); // Extract the numeric part
            $nextNumber = str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad
        } else {
            $nextNumber = '001'; // Default if no records exist
        }

        return "PL-{$nextNumber}";
    }

    public function pesanans(): HasMany {
        return $this->hasMany(Pesanan::class);
    }
}
