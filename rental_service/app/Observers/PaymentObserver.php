<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    public function created(Payment $payment) {
        $payment->order->adjustTotal();
        $payment->order->adjustBalance();
    }

    public function updated(Payment $payment) {
        $payment->order->adjustTotal();
        $payment->order->adjustBalance();
    }

    public function deleted(Payment $payment) {
        $payment->order->adjustTotal();
        $payment->order->adjustBalance();
    }
}
