<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kategori() {
        return $this->belongsTo(kategori::class);
    }

    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }
}
