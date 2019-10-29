<?php


namespace App\Kafka;


use App\Models\Customer;
use App\Models\Product;
use PHPEasykafka\KafkaConsumerHandlerInterface;

class ProductHandler implements KafkaConsumerHandlerInterface
{

    public function __invoke(\RdKafka\Message $message, \RdKafka\KafkaConsumer $consumer)
    {
        $payload = json_decode($message->payload);

        Product::firstOrCreate(
            ['id' => $payload->id],
            [
                'name' => $payload->name,
                'price' => $payload->price,
            ]
        );
    }
}
