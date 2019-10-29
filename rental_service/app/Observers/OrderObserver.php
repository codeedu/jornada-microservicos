<?php

namespace App\Observers;

use App\Models\Order;
use Carbon\Carbon;
use PHPEasykafka\KafkaProducer;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid as RamseyUuid;

class OrderObserver
{
    private $producer;

    public function __construct(ContainerInterface $container)
    {
        $topicConf = $container->get("KafkaTopicConfig");
        $brokerCollection = $container->get("KafkaBrokerCollection");

        $this->producer = new KafkaProducer(
            $brokerCollection,
            "orders",
            $topicConf
        );
    }

    public function created(Order $order)
    {
        $order->adjustTotal();
        $this->producer->produce(json_encode($this->prepare($order)));
    }

    public function updated(Order $order)
    {
        $order->adjustTotal();
        $order->adjustBalance();
        $this->producer->produce(json_encode($this->prepare($order)));
    }

    public function prepare(Order $order)
    {
        $preparedOrder = [
            'order' => [
                'id' => $order->id,
                'customer_id' => $order->customer_id,
                'status' => $order->status,
                'discount' => $order->discount,
                'total' => $order->total,
                'order_date' => $order->order_date->format('Y-m-d'),
            ]
        ];

        $itemsFinal = [];
        foreach ($order->items as $item) {
            $items['id'] = $item->id;
            $items['order_id'] = $item->order_id;
            $items['qtd'] = $item->qtd;
            $items['total'] = $item->qtd * $item->product->price;
            $items['product']['id'] = $item->product->id;
            $items['product']['name'] = $item->product->name;
            $itemsFinal[] = $items;
        }
        $preparedOrder['order']['items'] = $itemsFinal;
        return $preparedOrder;
    }
}
