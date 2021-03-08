<?php

declare(strict_types=1);

namespace App\Worker;

use App\Controller\TransactionController;
use App\Model\Entity\Product;
use App\Model\Entity\Variant;
use App\Model\Repository\ProductRepository;
use App\Model\Repository\VariantRepository;
use Core\Database\DatabaseConnector;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class TransactionWorker
{
    public function start(): void
    {
        $db = DatabaseConnector::getEntityManager();
        /** @var ProductRepository $productRepo */
        $productRepo = $db->getRepository(Product::class);
        /** @var VariantRepository $variantRepo */
        $variantRepo = $db->getRepository(Variant::class);


        $connection = new AMQPStreamConnection('lbdbrabbitmq', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare(TransactionController::TRANSACTIONS_QUEUE, false, false, false, false);

        $callback = function (AMQPMessage $message) use ($productRepo, $variantRepo) {
            $data = json_decode($message->getBody(), true);
            $productId = $data['id'];
            $sku = $data['sku'];
            $variantId = $data['variant_id'];
            $title = $data['title'];

            $product = $productRepo->findOneBy(['uuid' => $productId]);

            if (!$product instanceof Product) {
                $product = $productRepo->findOneBy(['sku' => $sku]);

                if (!$product instanceof Product) {
                    $product = new Product();
                }
            }

            $variant = $variantRepo->findOneBy(['uuid' => $variantId]);

            if (!$variant instanceof Variant) {
                $variant = new Variant();
            }

            $product->setTitle($title);
            $product->setSku($sku);

            $variant->setColor('Yellow');
            $variant->setSize('M');

            $productRepo->save($product);
            $variantRepo->save($variant);

            echo "Transaction saved.\n";
        };

        $channel->basic_consume(TransactionController::TRANSACTIONS_QUEUE, '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
