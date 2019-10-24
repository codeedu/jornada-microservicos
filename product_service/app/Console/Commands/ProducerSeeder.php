<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use PHPEasykafka\KafkaProducer;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;

class ProducerSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:produce-product';

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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ContainerInterface $container
     * @return mixed
     * @throws \Exception
     */
    public function handle(ContainerInterface $container)
    {
        $topicConf = $container->get("KafkaTopicConfig");
        $brokerCollection = $container->get("KafkaBrokerCollection");

        $product_id = Uuid::uuid4();
        $product = Product::create(
            [
                "id" => $product_id,
                "name" => "Product - " . $product_id,
                "description" => "Description",
                "price" => 15,
                "qtd_available" => 10,
                "qtd_total" => 20

            ]
        );

        $producer = new KafkaProducer(
            $brokerCollection,
            "products",
            $topicConf
        );
        $producer->produce($product->toJson());
    }
}
