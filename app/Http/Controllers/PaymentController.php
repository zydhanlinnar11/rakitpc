<?php

namespace App\Http\Controllers;

use App\Models\PaymentProcessor;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function createPayment(PaymentProcessor $paymentProcessor, User $user, Transaction $transaction) {
        $payment_handler = new $paymentProcessor['handler']();
        return $payment_handler->createPayment($user, $transaction);
    }
}
