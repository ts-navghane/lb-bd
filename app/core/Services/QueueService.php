<?php

declare(strict_types=1);

namespace Core\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueService
{
    /**
     * @var AMQPStreamConnection
     */
    private AMQPStreamConnection $amqpStreamConnection;

    /**
     * @var AMQPMessage
     */
    private AMQPMessage $amqpMessage;

    /**
     * QueueService constructor.
     * @param  AMQPStreamConnection  $amqpStreamConnection
     * @param  AMQPMessage  $amqpMessage
     */
    public function __construct(AMQPStreamConnection $amqpStreamConnection, AMQPMessage $amqpMessage)
    {
        $this->amqpStreamConnection = $amqpStreamConnection;
        $this->amqpMessage = $amqpMessage;
    }

    /**
     * @return AMQPStreamConnection
     */
    public function getAmqpStreamConnection(): AMQPStreamConnection
    {
        return $this->amqpStreamConnection;
    }

    /**
     * @param  AMQPStreamConnection  $amqpStreamConnection
     */
    public function setAmqpStreamConnection(AMQPStreamConnection $amqpStreamConnection): void
    {
        $this->amqpStreamConnection = $amqpStreamConnection;
    }

    /**
     * @return AMQPMessage
     */
    public function getAmqpMessage(): AMQPMessage
    {
        return $this->amqpMessage;
    }

    /**
     * @param  AMQPMessage  $amqpMessage
     */
    public function setAmqpMessage(AMQPMessage $amqpMessage): void
    {
        $this->amqpMessage = $amqpMessage;
    }
}
