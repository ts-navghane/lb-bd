<?php

declare(strict_types=1);

namespace Core\Router;

class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $path, string $controller, string $function): void
    {
        $this->routes[] = [$method, $path, $controller, $function];
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
