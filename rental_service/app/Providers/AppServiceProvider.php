<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use App\Observers\PaymentObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
