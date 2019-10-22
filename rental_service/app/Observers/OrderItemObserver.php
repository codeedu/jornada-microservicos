<?php

namespace App\Observers;

use App\Models\OrderItem;

class OrderItemObserver
{
    public function created(OrderItem $orderItem) {
        $orderItem->order->adjustTotal();
        $orderItem->order->adjustBalance();
    }

    public function updated(OrderItem $orderItem) {
        $orderItem->order->adjustTotal();
        $orderItem->order->adjustBalance();
    }

    public function deleted(OrderItem $orderItem) {
        $orderItem->order->adjustTotal();
        $orderItem->order->adjustBalance();
    }
}
