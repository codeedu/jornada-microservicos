<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;
use PHPEasykafka\KafkaProducer;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Uuid as RamseyUuid;

class KafkaProducerSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:produce-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $topicConf = $this->container->get("KafkaTopicConfig");
        $brokerCollection = $this->container->get("KafkaBrokerCollection");

        $customer_id = Uuid::uuid4();

        Customer::create(
            [
                'id' => $customer_id,
                'name' => "Jose - " . $customer_id,
                'email' => "jose-" . $customer_id . "@gmail.com",
                'phone' => "9999-9999"
            ]
        );

        $product_id = Uuid::uuid4();
        $order_id = Uuid::uuid4();

        $order = [
            'order' => [
                'id' => $order_id,
                'customer_id' => $customer_id,
                'status' => 'reservado',
                'discount' => 5,
                'total' => 95,
                'order_date' => '2019-10-01',
                'return_date' => '2019-10-03',

                'items' => [
                    [
                        'id' => RamseyUuid::uuid4(),
                        'order_id' => $order_id,
                        'product' => [
                            'id' => $product_id,
                            'name' => 'Product Name',
                        ],
                        'qtd' => 1,
                        'total' => 100
                    ]
                ]
            ],
        ];


        $producer = new KafkaProducer(
            $brokerCollection,
            "orders",
            $topicConf
        );

        $producer->produce(json_encode($order));

    }
}
