<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $casts = ['data' => 'array'];

    public function payment_request() {
        return $this->belongsTo(PaymentRequest::class, 'id_payment_request', 'id');
    }
}
