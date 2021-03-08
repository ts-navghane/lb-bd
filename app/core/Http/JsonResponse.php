<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Http\Interfaces\ResponseInterface;

class JsonResponse implements ResponseInterface
{
    private string $content;
    private int $statusCode;

    public function __construct(string $content, int $statusCode = 200)
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function send(): void
    {
        header('Content-Type: application/json');
        echo $this->getContent();
    }

    public function getContent(): string
    {
        return json_encode(['message' => $this->content], JSON_THROW_ON_ERROR);
    }
}
