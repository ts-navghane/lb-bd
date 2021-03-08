<?php

declare(strict_types=1);

namespace Core\Router;

use Core\Http\Interfaces\RequestInterface;
use Core\Http\Interfaces\ResponseInterface;
use Core\Router\Exception\MethodNotAllowedHttpException;
use Core\Router\Exception\RouteNotFoundException;
use DI\Container;

class RouteMatcher
{
    /**
     * @throws MethodNotAllowedHttpException
     * @throws RouteNotFoundException
     */
    public function process(Router $router, RequestInterface $request): ResponseInterface
    {
        $route = $this->getRouteData($request->getRequestUrl(), $request->getRequestMethod(), $router->getRoutes());
        $method = $route[3];

        /** @var Container $container */
        $container = include __DIR__.'/../../config/container.php';
        $routeProcessor = new RouteProcessor($container, $route[2], $method, $request);
        $arguments = $routeProcessor->process();

        return $container->get($route[2])->$method(...$arguments);
    }

    private function getRouteData(string $url, string $method, array $routes): array
    {
        $key = array_search($url, array_column($routes, 1), true);

        if ($key === false) {
            throw new RouteNotFoundException('Route not found.', 400);
        }

        $route = $routes[$key];

        if ($route[0] !== $method) {
            throw new MethodNotAllowedHttpException('Method not allowed. Allowed method: '.$route[0].'.', 400);
        }

        return $route;
    }
}
