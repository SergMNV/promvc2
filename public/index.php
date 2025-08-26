<?php

use Framework\Router\Router;

require_once __DIR__ . '../../vendor/autoload.php';

$routes = require_once __DIR__ . '../../routes/web.php';
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router = new Router();

$routes($router);

print $router->dispatch($method, $uri);

die;
