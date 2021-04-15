<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;

    public function item() {
        return $this->hasMany(item::class);
    }

    public function subcategory() {
        return $this->hasMany(subcategory::class);
    }
}
