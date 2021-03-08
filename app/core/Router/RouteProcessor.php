<?php

declare(strict_types=1);

namespace Core\Router;

use Core\Http\Interfaces\RequestInterface;
use DI\Container;
use ReflectionMethod;
use ReflectionNamedType;

class RouteProcessor
{
    private Container $container;
    private string $routeClass;
    private string $routeMethod;
    private RequestInterface $request;

    /**
     * RouteProcessor constructor.
     * @param  string  $routeClass
     * @param  string  $routeMethod
     */
    public function __construct(Container $container, string $routeClass, string $routeMethod, RequestInterface $request)
    {
        $this->container = $container;
        $this->routeClass = $routeClass;
        $this->routeMethod = $routeMethod;
        $this->request = $request;
    }

    public function process(): array
    {
        $reflectionMethod = new ReflectionMethod($this->routeClass, $this->routeMethod);
        $parameters = $reflectionMethod->getParameters();
        $arguments = [];

        foreach ($parameters as $parameter) {
            /** @var ReflectionNamedType $type */
            $type = $parameter->getType();
            $name = $type->getName();

            if (!$this->isCallable($name)) {
                $arguments[] = $this->request->getRequestParameters();
            } else {
                $arguments[] = $this->container->get($name);
            }
        }

        return $arguments;
    }

    private function isCallable(string $name): bool
    {
        if (class_exists($name)) {
            return true;
        }

        if (interface_exists($name)) {
            return true;
        }

        return false;
    }
}
