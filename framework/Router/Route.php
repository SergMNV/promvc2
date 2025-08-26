<?php

namespace Framework\Router;

final class Route
{
    public readonly string $method;
    public readonly string $path;
    public readonly mixed $handler;

    private ?string $name;

    public function __construct(
        string $method,
        string $path,
        mixed $handler,
    ) {
        $this->method = strtoupper($method);
        $this->path = trim($path);
        $this->handler = $handler;
    }

    public function name(?string $name = null): string|null|Route
    {
        if ($name) {
            $this->name = $name;
            return $this;
        }

        return $this->name;
    }
}
