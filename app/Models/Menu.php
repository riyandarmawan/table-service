<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;

    protected $primaryKey = 'id_menu';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function pesanans(): HasMany {
        return $this->hasMany(Pesanan::class);
    }
}
