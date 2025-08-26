<?php

namespace Framework\Router;

use InvalidArgumentException;

final class Route
{
    private array $supportedMethods = [
        'GET',
        'POST',
    ];

    public readonly string $method;
    public readonly string $path;
    public readonly mixed $handler;

    private ?string $name;

    public function __construct(
        string $method,
        string $path,
        mixed $handler,
    ) {
        if (!in_array($method, $this->supportedMethods)) {
            throw new InvalidArgumentException($method . ' not supported');
        }
        $this->method = $method;
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
