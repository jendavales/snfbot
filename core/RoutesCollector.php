<?php

namespace core;

use controllers\HomeController;
use controllers\IndexController;

class RoutesCollector
{
    public static function getRoutes(): array
    {
        return [
            'login' => new Route('/', [Request::METHOD_GET, Request::METHOD_POST], IndexController::class, 'home'),
            'registration' => new Route('/registration', [Request::METHOD_GET, Request::METHOD_POST], IndexController::class, 'registration'),
            'home' => new Route('/home', [Request::METHOD_GET, Request::METHOD_POST], HomeController::class, 'home'),
        ];
    }
}
