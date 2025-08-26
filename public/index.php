<?php

use Framework\Router\Router;

require_once __DIR__ . '../../vendor/autoload.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router = new Router();
print $router->dispatch($method, $uri);

die;
