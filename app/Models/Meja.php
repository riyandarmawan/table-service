<?php

namespace App\Models;

use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meja extends Model
{
    /** @use HasFactory<\Database\Factories\MejaFactory> */
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_meja';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public static function generateIdMeja()
    {
        $lastMeja = self::withTrashed()->orderBy('id_meja', 'desc')->first(); // Get the latest record
        if ($lastMeja) {
            $lastId = $lastMeja->id_meja;
            $number = (int) substr($lastId, 3); // Extract the numeric part
            $nextNumber = str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad
        } else {
            $nextNumber = '001'; // Default if no records exist
        }

        return "MJ-{$nextNumber}";
    }

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) =>
            $query->where('id_meja', 'like', "%$search%")
        );
    }
}
