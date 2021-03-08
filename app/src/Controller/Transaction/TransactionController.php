<?php

declare(strict_types=1);

namespace App\Controller\Transaction;

use Core\Http\Interfaces\RequestInterface;
use Core\Http\Interfaces\ResponseInterface;
use Core\Http\JsonResponse;
use Core\Services\QueueService;

class TransactionController
{
    public const TRANSACTIONS_QUEUE = 'transactions';

    /**
     * @var QueueService
     */
    private QueueService $queueService;

    /**
     * TransactionController constructor.
     * @param  QueueService  $queueService
     */
    public function __construct(QueueService $queueService)
    {
        $this->queueService = $queueService;
    }

    public function transactions(RequestInterface $request): ResponseInterface
    {
        $data = $request->getRequestParameters();
        $channel = $this->queueService->getAmqpStreamConnection()->channel();
        $channel->queue_declare(self::TRANSACTIONS_QUEUE, false, false, false, false);
        $body = $this->queueService->getAmqpMessage()->setBody(json_encode($data));
        $channel->basic_publish($body, '', self::TRANSACTIONS_QUEUE);
        $channel->close();
        $this->queueService->getAmqpStreamConnection()->close();

        return new JsonResponse('Transaction pushed.');
    }

    public function newTransaction(string $a): ResponseInterface
    {
        return new JsonResponse($a);
    }
}
