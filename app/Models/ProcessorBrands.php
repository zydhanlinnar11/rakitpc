<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessorBrands extends Model
{
    use HasFactory;

    public function sockets() {
        return $this->hasMany(ProcessorSockets::class);
    }
}
