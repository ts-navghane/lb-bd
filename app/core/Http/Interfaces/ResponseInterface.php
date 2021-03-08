<?php

declare(strict_types=1);

namespace Core\Http\Interfaces;

interface ResponseInterface
{
    public function getContent(): string;

    public function getStatusCode(): int;

    public function send(): void;
}