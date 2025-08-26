<?php

namespace Framework\Router;

use Exception;

class Router
{
    private array $routes = [];
    private array $errorHandlers = [];
    private ?Route $current = null;

    public function addRoute(string $method, string $path, mixed $handler): Route
    {
        $route = $this->routes[] = new Route($method, $path, $handler);
        return $route;
    }

    public function dispatch(string $method, string $uri): string
    {
        print $this->normalisePath($uri);
        echo "<br>";

        try {
            $matching = $this->matching($method, $uri);

            if ($matching) {
                $this->current = $matching;

                return call_user_func($matching->handler);
            }

            $paths = $this->paths();

            if (in_array($uri, $paths)) {
                return call_user_func($this->dispatchNotAllowed());
            }

            return call_user_func($this->dispatchNotFound());
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "<br>";
            return call_user_func($this->dispatchServerError());
        }
    }

    public function current(): ?Route
    {
        return $this->current;
    }

    public function setErrorHandler(int $code, mixed $handler): void
    {
        $this->errorHandlers[$code] = $handler;
    }

    public function dispatchNotFound(): mixed
    {
        return $this->errorHandlers[404] ??= fn() => 'dispatch not found 404';
    }

    public function dispatchServerError(): mixed
    {
        return $this->errorHandlers[500] ??= fn() => 'dispatch server error 500';
    }

    public function dispatchNotAllowed(): mixed
    {
        return $this->errorHandlers[400] ??= fn() => 'dispatch not allowed 400';
    }

    private function matching(string $method, string $uri): ?Route
    {
        foreach ($this->routes as $route) {
            if (
                $route->method === $method &&
                $route->path === $uri
            ) {
                return $route;
            }
        }

        return null;
    }

    private function paths(): array
    {
        $paths = [];
        foreach ($this->routes as $route) {
            $paths[] = $route->path;
        }

        return $paths;
    }

    private function normalisePath(string $path): string
    {
        $path = trim($path);
        $path = preg_replace('#/{2,}#', '/', $path);
        // return "/{$path}/";
        return $path;
    }
}
