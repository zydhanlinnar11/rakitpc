<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_simulasi extends Model
{
    use HasFactory;

    protected $table = 'data_simulasi';

    public function items() {
        return $this->hasMany(item::class);
    }
}
