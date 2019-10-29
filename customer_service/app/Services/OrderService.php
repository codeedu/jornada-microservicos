<?php


namespace App\Services;


use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderService
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function insert()
    {
        print_r($this->data->order);
        $order = Order::find($this->data->order->id);
        if ($order) {
            $order->delete();
        }


        Order::create([
            'id' => $this->data->order->id,
            'customer_id' => $this->data->order->customer_id,
            'status' => $this->data->order->status,
            'discount' => $this->data->order->discount,
            'total' => $this->data->order->total,
            'order_date' => $this->data->order->order_date,
        ]);

        foreach ($this->data->order->items as $item) {

            Product::firstOrCreate(['id' => $item->product->id], [
                'name' => $item->product->name,
            ]);

            OrderItem::create(
                [
                    'id' => $item->id,
                    'order_id' => $item->order_id,
                    'product_id' => $item->product->id,
                    'qtd' => $item->qtd,
                    'total' => $item->total
                ]
            );
        }

    }

}
