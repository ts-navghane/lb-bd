<?php

declare(strict_types=1);

namespace App;

use Core\Http\Interfaces\RequestInterface;
use Core\Http\Interfaces\ResponseInterface;
use Core\Router\Exception\MethodNotAllowedHttpException;
use Core\Router\Exception\RouteNotFoundException;
use Core\Router\RouteMatcher;

class Application
{
    /**
     * @throws MethodNotAllowedHttpException
     * @throws RouteNotFoundException
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $router = include CONFIG_DIR.'routing.php';
        $routeMatcher = new RouteMatcher();

        return $routeMatcher->process($router, $request);
    }
}
