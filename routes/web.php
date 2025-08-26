<?php

use Framework\Router\Router;

return function (Router $r) {
    $r->addRoute(
        'GET',
        '/',
        fn() => 'forward page',
    );
    $r->addRoute(
        'GET',
        '/home',
        fn() => 'home page',
    );
};
