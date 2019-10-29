<?php


namespace App\Kafka;


use App\Models\Customer;
use PHPEasykafka\KafkaConsumerHandlerInterface;

class CustomerHandler implements KafkaConsumerHandlerInterface
{

    public function __invoke(\RdKafka\Message $message, \RdKafka\KafkaConsumer $consumer)
    {
        $payload = json_decode($message->payload);

        Customer::firstOrCreate(
            ['id' => $payload->id],
            [
                'name' => $payload->name,
                'email' => $payload->email,
                'phone' => $payload->email
            ]
        );
    }
}
