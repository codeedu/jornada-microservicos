<?php


namespace App\Kafka;


use App\Services\OrderService;
use PHPEasykafka\KafkaConsumerHandlerInterface;

class OrderHandler implements KafkaConsumerHandlerInterface
{

    public function __invoke(\RdKafka\Message $message, \RdKafka\KafkaConsumer $consumer)
    {
        $payload = json_decode($message->payload);
//        print_r(json_decode($message->payload));

        $orderService = new OrderService($payload);
        $orderService->insert();
//        $consumer->commit();
    }
}
