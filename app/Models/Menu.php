<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_menu';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public static function generateIdMenu() {
        $lastMenu = self::withTrashed()->orderBy('id_menu', 'desc')->first(); // Get the latest record
        if ($lastMenu) {
            $lastId = $lastMenu->id_menu;
            $number = (int) substr($lastId, 3); // Extract the numeric part
            $nextNumber = str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad
        } else {
            $nextNumber = '001'; // Default if no records exist
        }

        return "MN-{$nextNumber}";
    }

    public function pesanans(): HasMany {
        return $this->hasMany(Pesanan::class);
    }
}
