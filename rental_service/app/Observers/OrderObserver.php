<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    public function created(Order $order) {
        $order->adjustTotal();
    }

    public function updated(Order $order) {
        $order->adjustTotal();
        $order->adjustBalance();
    }
}
