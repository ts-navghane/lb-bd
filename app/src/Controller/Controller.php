<?php

declare(strict_types=1);

namespace App\Controller;

use Core\Http\HtmlResponse;
use Core\Http\Interfaces\ResponseInterface;

class Controller
{
    public function index(): ResponseInterface
    {
        return new HtmlResponse('Welcome!');
    }
}
