<?php

declare(strict_types=1);

use App\Controller\Controller;
use App\Controller\Transaction\TransactionController;
use Core\Http\Interfaces\RequestInterface;
use Core\Http\JsonRequest;
use Core\Services\QueueService;
use DI\Container;
use DI\ContainerBuilder;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

use function DI\create;
use function DI\get;

$builder = new ContainerBuilder();
$builder->useAutowiring(false);
$builder->useAnnotations(false);

$builder->addDefinitions(
    [
        'amqp.host' => 'lbdbrabbitmq',
        'amqp.port' => 5672,
        'amqp.user' => 'guest',
        'amqp.pass' => 'guest',
        RequestInterface::class => create(JsonRequest::class),
        AMQPStreamConnection::class => static function (Container $container) {
            return new AMQPStreamConnection(
                $container->get('amqp.host'),
                $container->get('amqp.port'),
                $container->get('amqp.user'),
                $container->get('amqp.pass')
            );
        },
        AMQPMessage::class => new AMQPMessage(),
        QueueService::class => create(QueueService::class)->constructor(
            get(AMQPStreamConnection::class),
            get(AMQPMessage::class)
        ),
        Controller::class => create(Controller::class),
        TransactionController::class => create(TransactionController::class)->constructor(
            get(QueueService::class)
        ),
    ],
);

return $builder->build();
