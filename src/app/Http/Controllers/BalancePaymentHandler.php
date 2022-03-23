<?php

namespace App\Http\Controllers;

use App\Models\PaymentRequest;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class BalancePaymentHandler extends Controller
{
    //
    public function createPayment(User $user, Transaction $transaction) {
        if($user['saldo'] < $transaction['total_harga'])
            return NULL;
        try {
            $payment_request = new PaymentRequest();
            $payment_request['id_payment_processor'] = 1;
            $payment_request->save();
            $user['saldo'] -= $transaction['total_harga'];
            $user->save();
            $transaction['done'] = true;
            return $payment_request['id'];
        } catch (Exception $e) {
            return NULL;
        }
    }
}
