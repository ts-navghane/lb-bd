<?php

declare(strict_types=1);

namespace Core\Http\Interfaces;

interface RequestInterface
{
    public function getRequestParameters(): array;

    public function getRequestMethod(): string;

    public function getRequestUrl(): string;
}