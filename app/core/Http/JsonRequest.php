<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Http\Exception\InvalidRequestException;
use Core\Http\Interfaces\RequestInterface;

class JsonRequest implements RequestInterface
{
    private array $data;
    private string $method;
    private string $url;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        if ($this->method === 'GET') {
            $this->data = $_GET;
        } else {
            $jsonData = file_get_contents('php://input');

            if (!$this->isJson($jsonData)) {
                $this->data = [];
                throw new InvalidRequestException('Request not json', 400);
            }
        }

        $uri = htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES);
        $uriParts = explode('?', $uri);
        $this->url = $uriParts[0];
    }

    private function isJson(string $string): bool
    {
        $this->data = json_decode($string, true);

        return (json_last_error() === JSON_ERROR_NONE);
    }

    public function getRequestParameters(): array
    {
        return $this->data;
    }

    public function getRequestMethod(): string
    {
        return $this->method;
    }

    public function getRequestUrl(): string
    {
        return $this->url;
    }
}
