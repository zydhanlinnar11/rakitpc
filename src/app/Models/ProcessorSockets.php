<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessorSockets extends Model
{
    use HasFactory;

    public function processor_brands() {
        return $this->belongsTo(ProcessorBrands::class);
    }

    public function item() {
        return $this->hasMany(item::class);
    }
}
