<?php

namespace App\Providers;

use App\Models\Customer;
use App\Observers\KafkaCustomerObserver;
use Illuminate\Support\ServiceProvider;
use PHPEasykafka\Broker;
use PHPEasykafka\BrokerCollection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("KafkaBrokerCollection", function () {
            $broker = new Broker(env("KAFKA_HOST","kafka"), env("KAFKA_PORT","9092"));
            $kafkaBrokerCollection = new BrokerCollection();
            $kafkaBrokerCollection->addBroker($broker);
            return $kafkaBrokerCollection;
        });

        $this->app->bind("KafkaTopicConfig", function () {
            return [
                'topic' => [
                    'auto.offset.reset' => 'largest'
                ],
                'consumer' => [
                    'enable.auto.commit' => "true",
                    'auto.commit.interval.ms' => "100",
                    'offset.store.method' => 'broker'
                ]
            ];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Customer::observe(KafkaCustomerObserver::class);
    }
}
